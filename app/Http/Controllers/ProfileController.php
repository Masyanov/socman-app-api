<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\SettingLoadcontrol;
use App\Models\Team;
use App\Models\Training;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ProfileController extends Controller {
    /**
     * Display the user's profile form.
     */
    public function edit( Request $request ): View {
        return view( 'profile.edit', [
            'user' => $request->user(),
        ] );
    }

    /**
     * Update the user's profile information.
     */
    public function update( ProfileUpdateRequest $request ): RedirectResponse {
        $active = $request->boolean( 'active' );

        $user      = User::findOrFail( $request->player_id );
        $userEmail = $user->email;

        // Валидация email, если изменился
        if ( $request->email !== $userEmail ) {
            $request->validate( [
                'email' => [ 'required', 'string', 'email', 'max:255', 'unique:' . User::class ],
            ] );
        }

        $request->validate( [
            'avatar' => 'nullable|image',
        ] );

        $userMeta = UserMeta::where( 'user_id', $request->player_id )->first();

        $avatarName = $userMeta ? $userMeta->avatar : null;

        if ( $request->hasFile( 'avatar' ) ) {
            $avatarName = time() . '.' . strtolower( $request->file( 'avatar' )->getClientOriginalExtension() );
            $request->file( 'avatar' )->move( public_path( 'avatars' ), $avatarName );

            $imagePath  = public_path( 'avatars/' . $avatarName );
            $sizeBefore = filesize( $imagePath );
            \Log::info( "Image size before optimization: {$sizeBefore} bytes" );

            try {
                $optimizerChain = OptimizerChainFactory::create();
                $optimizerChain->optimize( $imagePath );

                $sizeAfter = filesize( $imagePath );
                \Log::info( "Image size after optimization: {$sizeAfter} bytes" );
                \Log::info( 'Image optimized successfully: ' . $avatarName );
            } catch ( \Exception $e ) {
                \Log::error( 'Image optimization failed: ' . $e->getMessage() );
            }
        }

        $user->update( [
            'name'        => $request->name,
            'second_name' => $request->second_name,
            'last_name'   => $request->last_name,
            'team_code'   => $user->team_code,
            'email'       => $request->email,
            'active'      => $user->active,
        ] );

        // Обновляем или создаём UserMeta
        if ( $userMeta ) {
            $userMeta->update( [
                'tel'        => $request->tel,
                'birthday'   => $request->birthday,
                'position'   => $request->position,
                'number'     => $request->number,
                'tel_mother' => $request->tel_mother,
                'tel_father' => $request->tel_father,
                'comment'    => $request->comment,
                'avatar'     => $avatarName,
            ] );
        } else {
            UserMeta::create( [
                'user_id'    => $user->id,
                'tel'        => $request->tel,
                'birthday'   => $request->birthday,
                'position'   => $request->position,
                'number'     => $request->number,
                'tel_mother' => $request->tel_mother,
                'tel_father' => $request->tel_father,
                'comment'    => $request->comment,
                'avatar'     => $avatarName,
            ] );
        }

        return Redirect::route( 'profile.edit' )->with( 'status', 'profile-updated' );
    }

    /**
     * Delete the user's account.
     */
    public function destroy( Request $request ): RedirectResponse {
        $request->validateWithBag( 'userDeletion', [
            'password' => [ 'required', 'current_password' ],
        ] );

        $user = $request->user();

        Auth::logout();

        UserMeta::where( 'user_id', $user->id )->delete();
        SettingLoadcontrol::where( 'user_id', $user->id )->delete();
        Team::where( 'user_id', $user->id )->delete();
        Training::where( 'user_id', $user->id )->delete();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to( '/' );
    }
}
