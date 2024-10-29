<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Auth::user()->id;
        $users = User::where('id', '!=', $id)->get();
        $messages = Message::where('from_id', $id)->orWhere('to_id', $id)->get();
        return view('messages', compact('messages', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required',
            'to_id' => 'required',
        ]);
        $data = $request->all();
        $data['from_id'] = Auth::user()->id;
        $message = Message::create($data);

        $message->load('from', 'to');
        $chat = [
            'message' => $message,
        ];
        broadcast(new MessageSent($message));
        return back();
    }

    public function show($user)
    {
        $user = User::findOrFail($user);
        $id = Auth::id();
        $users = User::where('id', '!=', $id)->get();

        $messages = Message::where(function ($query) use ($id, $user) {
            $query->where('from_id', $id)
                ->where('to_id', $user->id);
        })->orWhere(function ($query) use ($id, $user) {
            $query->where('from_id', $user->id)
                ->where('to_id', $id);
        })->get();
        return view('chat', ['chatUser' => $user, 'messages' => $messages, 'users' => $users]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
