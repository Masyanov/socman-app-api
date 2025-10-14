<?php

namespace App\Services;

use Spatie\ImageOptimizer\OptimizerChainFactory;

class AvatarService
{
    public function uploadAndOptimize($avatarFile) : string
    {
        $avatarName = time() . '.' . strtolower($avatarFile->getClientOriginalExtension());
        $avatarFile->move(public_path('avatars'), $avatarName);

        $imagePath = public_path('avatars/' . $avatarName);

        try {
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize($imagePath);
        } catch (\Exception $e) {
            // log error
        }

        return $avatarName;
    }
}
