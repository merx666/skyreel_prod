<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display the messaging interface.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get conversations (unique users the current user has messaged with)
        $conversations = DB::table('messages')
            ->select(
                DB::raw('CASE 
                    WHEN sender_id = ? THEN receiver_id 
                    ELSE sender_id 
                END as other_user_id'),
                DB::raw('MAX(created_at) as last_message_at'),
                DB::raw('COUNT(CASE WHEN receiver_id = ? AND read_at IS NULL THEN 1 END) as unread_count')
            )
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
            })
            ->groupBy('other_user_id')
            ->orderBy('last_message_at', 'desc')
            ->get();

        // Load user details for conversations
        $conversationUsers = User::whereIn('id', $conversations->pluck('other_user_id'))
            ->with('profile')
            ->get()
            ->keyBy('id');

        // Add user details to conversations
        $conversations = $conversations->map(function ($conversation) use ($conversationUsers) {
            $conversation->user = $conversationUsers->get($conversation->other_user_id);
            return $conversation;
        });

        $selectedUserId = $request->get('user_id');
        $selectedUser = null;
        $messages = collect();

        if ($selectedUserId) {
            $selectedUser = User::with('profile')->find($selectedUserId);
            if ($selectedUser) {
                $messages = Message::betweenUsers($user->id, $selectedUserId)
                    ->with(['sender', 'receiver', 'job'])
                    ->orderBy('created_at', 'asc')
                    ->get();

                // Mark messages as read
                Message::where('sender_id', $selectedUserId)
                    ->where('receiver_id', $user->id)
                    ->whereNull('read_at')
                    ->update(['read_at' => now()]);
            }
        }

        return view('messages.index', compact('conversations', 'selectedUser', 'messages'));
    }

    /**
     * Send a new message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
            'job_id' => 'nullable|exists:job_listings,id',
        ]);

        $user = Auth::user();

        // Check if user is trying to message themselves
        if ($user->id == $request->receiver_id) {
            return back()->withErrors(['message' => __('Nie możesz wysłać wiadomości do siebie.')]);
        }

        $message = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'job_id' => $request->job_id,
            'message' => $request->message,
        ]);

        $message->load(['sender', 'receiver', 'job']);

        // Broadcast the message
        broadcast(new MessageSent($message));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load(['sender', 'receiver', 'job']),
            ]);
        }

        return redirect()->route('messages.index', ['user_id' => $request->receiver_id])
            ->with('success', __('Wiadomość została wysłana.'));
    }

    /**
     * Start a conversation with a user (from job or profile).
     */
    public function startConversation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'job_id' => 'nullable|exists:job_listings,id',
        ]);

        $userId = $request->user_id;
        $jobId = $request->job_id;

        $queryParams = ['user_id' => $userId];
        if ($jobId) {
            $queryParams['job_id'] = $jobId;
        }

        return redirect()->route('messages.index', $queryParams);
    }

    /**
     * Get messages for a specific conversation (AJAX).
     */
    public function getMessages(Request $request, $userId)
    {
        $user = Auth::user();
        
        $messages = Message::betweenUsers($user->id, $userId)
            ->with(['sender', 'receiver', 'job'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json($messages);
    }

    /**
     * Mark messages as read.
     */
    public function markAsRead(Request $request, $userId)
    {
        $user = Auth::user();

        Message::where('sender_id', $userId)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}