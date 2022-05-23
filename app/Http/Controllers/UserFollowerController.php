<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFollower;
use Illuminate\Support\Facades\Auth;

class UserFollowerController extends Controller
{
    public function store($id)
    {
        $user = User::findOrFail($id);
        UserFollower::firstOrCreate([
            'user_id' => $user->getKey(),
            'followed_by_id' => Auth::id(),
        ]);
        return back();
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $follower = UserFollower::query()
            ->where('user_id', $user->getKey())
            ->where('followed_by_id', Auth::id())
            ->firstOrFail();
        $follower->deleteOrFail();
        return back();
    }
}
