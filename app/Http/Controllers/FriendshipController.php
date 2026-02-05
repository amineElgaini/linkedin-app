<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    /**
     * Show friends & friend requests
     */
    public function index()
    {
        $user = Auth::user();

        // Incoming friend requests
        $friendRequests = Friendship::pending()
            ->where('friend_id', $user->id)
            ->with('sender')
            ->get();

        // Accepted friends
        $friends = Friendship::accepted()
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('friend_id', $user->id);
            })
            ->with(['sender', 'receiver'])
            ->get();

        return view('friends.index', compact('friends', 'friendRequests'));
    }

    /**
     * Send friend request
     */
    public function sendRequest(User $user)
    {
        $auth = Auth::user();

        if ($auth->id === $user->id) {
            return back()->with('error', 'Impossible de vous ajouter vous-même.');
        }

        Friendship::firstOrCreate([
            'user_id' => $auth->id,
            'friend_id' => $user->id,
        ], [
            'status' => 'pending',
        ]);

        return back()->with('success', 'Demande d’amitié envoyée.');
    }

    /**
     * Accept request
     */
    public function accept(Friendship $friendship)
    {
        abort_if($friendship->friend_id !== Auth::id(), 403);

        $friendship->accept();

        return back()->with('success', 'Demande acceptée.');
    }

    /**
     * Reject request
     */
    public function reject(Friendship $friendship)
    {
        abort_if($friendship->friend_id !== Auth::id(), 403);

        $friendship->reject();

        return back()->with('success', 'Demande refusée.');
    }

    /**
     * Remove friend
     */
    public function remove(Friendship $friendship)
    {
        abort_if(
            $friendship->user_id !== Auth::id() &&
            $friendship->friend_id !== Auth::id(),
            403
        );

        $friendship->delete();

        return back()->with('success', 'Ami supprimé.');
    }
}
