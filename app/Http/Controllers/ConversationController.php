<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of conversations for the authenticated user.
     */
    public function index()
    {
        $conversations = Auth::user()->conversations()
            ->with(['users' => function($query) {
                $query->where('users.id', '!=', Auth::id())
                      ->with('profile');
            }, 'latestMessage.sender'])
            ->withCount('messages')
            ->orderBy('last_message_at', 'desc')
            ->paginate(15); // Use pagination so Blade can call hasPages()/links()

        return view('conversations.index', compact('conversations'));
    }

    /**
     * Show the form for creating a new conversation.
     */
    public function create(Request $request)
    {
        $recipientId = $request->get('recipient_id');
        $recipient = null;
        
        if ($recipientId) {
            $recipient = User::findOrFail($recipientId);
        }

        return view('conversations.create', compact('recipient'));
    }

    /**
     * Store a newly created conversation in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id|different:' . Auth::id(),
            'message' => 'required|string|max:1000',
        ]);

        // Check if conversation already exists between these users
        $existingConversation = Conversation::whereHas('users', function($query) {
            $query->where('user_id', Auth::id());
        })->whereHas('users', function($query) use ($request) {
            $query->where('user_id', $request->recipient_id);
        })->where('is_group', false)->first();

        if ($existingConversation) {
            // Add message to existing conversation
            $message = $existingConversation->messages()->create([
                'sender_id' => Auth::id(),
                'message' => $request->message,
            ]);

            $existingConversation->update(['last_message_at' => now()]);

            return redirect()->route('conversations.show', $existingConversation);
        }

        // Create new conversation
        $conversation = null;
        DB::transaction(function() use ($request, &$conversation) {
            $conversation = Conversation::create([
                'is_group' => false,
                'last_message_at' => now(),
            ]);

            // Add users to conversation
            $conversation->users()->attach([Auth::id(), $request->recipient_id]);

            // Create first message
            $conversation->messages()->create([
                'sender_id' => Auth::id(),
                'message' => $request->message,
            ]);
        });

        return redirect()->route('conversations.show', $conversation);
    }

    /**
     * Display the specified conversation.
     */
    public function show(Conversation $conversation)
    {
        // Check if user is part of this conversation
        if (!$conversation->users->contains(Auth::id())) {
            abort(403);
        }

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        $conversation->markAsReadForUser(Auth::id());

        // Get other participants
        $otherUsers = $conversation->users->where('id', '!=', Auth::id());

        return view('conversations.show', compact('conversation', 'messages', 'otherUsers'));
    }

    /**
     * Store a new message in the conversation.
     */
    public function storeMessage(Request $request, Conversation $conversation)
    {
        // Check if user is part of this conversation
        if (!$conversation->users->contains(Auth::id())) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        $conversation->update(['last_message_at' => now()]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return redirect()->route('conversations.show', $conversation);
    }

    /**
     * Mark conversation as read for the authenticated user.
     */
    public function markAsRead(Conversation $conversation)
    {
        if (!$conversation->users->contains(Auth::id())) {
            abort(403);
        }

        $conversation->markAsReadForUser(Auth::id());

        return response()->json(['success' => true]);
    }
}
