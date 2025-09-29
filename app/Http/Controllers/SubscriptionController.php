<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with('user')->latest()->get();

        return view('dashboard', compact('subscriptions'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.subscriptions.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_paid' => 'required|boolean',
        ]);
        Subscription::create($request->all());
        return redirect()->route('admin.subscriptions.index')->with('success', 'Подписка добавлена');
    }

    public function edit($id)
    {
        $subscription = Subscription::findOrFail($id);
        $users = User::all();
        return view('admin.subscriptions.edit', compact('subscription', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_paid' => 'required|boolean',
        ]);
        Subscription::findOrFail($id)->update($request->all());
        return redirect()->route('admin.subscriptions.index')->with('success', 'Подписка обновлена');
    }
}

