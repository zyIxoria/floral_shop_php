<?php
 
 namespace App\Http\Controllers\Admin;
 
 use App\Http\Controllers\Controller;
 use App\Models\ChatMessage;
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Auth;
 
 class ChatAdminController extends Controller
 {
     public function __construct()
     {
         $this->middleware('admin');
     }
 
     public function index()
     {
         return view('admin.chats.index');
     }
 
     public function getSessions()
     {
         // Get the ID of the last message in each chat session
         $latestMessageIds = ChatMessage::selectRaw('MAX(id) as id')
             ->groupBy('session_id')
             ->pluck('id');
 
         // Retrieve the messages matching those IDs, ordered by latest
         $sessions = ChatMessage::whereIn('id', $latestMessageIds)
             ->orderBy('created_at', 'desc')
             ->get();
 
         // Calculate unread message counts from customers for each session
         $unreadCounts = ChatMessage::where('sender_type', 'customer')
             ->where('is_read_by_admin', false)
             ->groupBy('session_id')
             ->selectRaw('session_id, COUNT(*) as count')
             ->pluck('count', 'session_id')
             ->toArray();
 
         foreach ($sessions as $session) {
             $session->unread_count = $unreadCounts[$session->session_id] ?? 0;
         }
 
         return response()->json([
             'status' => 'success',
             'sessions' => $sessions,
         ]);
     }
 
     public function getMessages($sessionId)
     {
         // Mark customer messages in this session as read by admin
         ChatMessage::where('session_id', $sessionId)
             ->where('sender_type', 'customer')
             ->update(['is_read_by_admin' => true]);
 
         $messages = ChatMessage::where('session_id', $sessionId)
             ->orderBy('created_at', 'asc')
             ->get();
 
         return response()->json([
             'status' => 'success',
             'messages' => $messages,
         ]);
     }
 
     public function sendMessage(Request $request, $sessionId)
     {
         $request->validate([
             'message' => 'required|string',
         ]);
 
         $admin = Auth::user();
 
         $message = ChatMessage::create([
             'session_id' => $sessionId,
             'user_id' => $admin->id,
             'sender_type' => 'admin',
             'sender_name' => $admin->name,
             'message' => $request->message,
             'is_read_by_admin' => true,
             'is_read_by_customer' => false,
         ]);
 
         return response()->json([
             'status' => 'success',
             'message' => $message,
         ]);
     }
 }
