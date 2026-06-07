<?php
 
 namespace App\Http\Controllers;
 
 use App\Models\ChatMessage;
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Auth;
 
 class ChatController extends Controller
 {
     public function getMessages(Request $request)
     {
         $request->validate([
             'session_id' => 'required|string',
         ]);
 
         $sessionId = $request->session_id;
 
         // Mark admin messages as read by the customer
         ChatMessage::where('session_id', $sessionId)
             ->where('sender_type', 'admin')
             ->update(['is_read_by_customer' => true]);
 
         $messages = ChatMessage::where('session_id', $sessionId)
             ->orderBy('created_at', 'asc')
             ->get();
 
         return response()->json([
             'status' => 'success',
             'messages' => $messages,
         ]);
     }
 
     public function sendMessage(Request $request)
     {
         $request->validate([
             'session_id' => 'required|string',
             'message' => 'required|string',
         ]);
 
         $sessionId = $request->session_id;
         $text = trim($request->message);
         $user = Auth::user();
 
         $message = ChatMessage::create([
             'session_id' => $sessionId,
             'user_id' => $user ? $user->id : null,
             'sender_type' => 'customer',
             'sender_name' => $user ? $user->name : 'Khách vãng lai',
             'message' => $text,
             'is_read_by_admin' => false,
             'is_read_by_customer' => true,
         ]);
 
         // Bot Auto-Replies logic for template questions
         $autoReply = null;
         $lowerText = mb_strtolower($text, 'UTF-8');
 
         if (str_contains($lowerText, 'hỏa tốc') || str_contains($lowerText, 'giao hoa trong 2h') || str_contains($lowerText, 'giao hoa hỏa tốc')) {
             $autoReply = "Floral Shop hỗ trợ giao hoa hỏa tốc trong vòng 2 giờ kể từ khi xác nhận đơn hàng tại khu vực nội thành. Bạn có thể chọn phương thức giao hàng hỏa tốc khi thanh toán hoặc nhắn tin trực tiếp mẫu hoa bạn muốn giao gấp nhé! 🛵💨";
         } elseif (str_contains($lowerText, 'thiết kế riêng') || str_contains($lowerText, 'đặt thiết kế') || str_contains($lowerText, 'hoa theo yêu cầu')) {
             $autoReply = "Chúng tôi rất sẵn lòng thiết kế hoa theo yêu cầu! Bạn vui lòng cung cấp thông tin về dịp tặng (sinh nhật, khai trương, kỷ niệm...), ngân sách dự kiến, màu sắc hoặc loài hoa yêu thích để Floral Shop tư vấn chi tiết nhất cho bạn nhé! 💐🎨";
         } elseif (str_contains($lowerText, 'thanh toán') || str_contains($lowerText, 'phương thức thanh toán')) {
             $autoReply = "Floral Shop hỗ trợ các hình thức thanh toán thuận tiện: Thanh toán khi nhận hàng (COD) hoặc Chuyển khoản ngân hàng trực tiếp (Chuyển khoản giả lập). 💳✨";
         } elseif (str_contains($lowerText, 'bảo hành') || str_contains($lowerText, 'đổi trả') || str_contains($lowerText, 'hoàn tiền')) {
             $autoReply = "Để khách hàng hoàn toàn yên tâm, Floral Shop cam kết hoàn tiền hoặc đổi sản phẩm mới miễn phí 100% nếu hoa bị dập nát, héo úa hoặc không đúng mẫu khi giao đến tay khách hàng. Bạn chỉ cần chụp ảnh hoa nhận được và gửi ngay cho shop hỗ trợ nhé! 🛡️❤️";
         }
 
         if ($autoReply) {
             ChatMessage::create([
                 'session_id' => $sessionId,
                 'user_id' => null,
                 'sender_type' => 'admin',
                 'sender_name' => 'Trợ lý ảo Floral',
                 'message' => $autoReply,
                 'is_read_by_admin' => true,
                 'is_read_by_customer' => false,
             ]);
         }
 
         return response()->json([
             'status' => 'success',
             'message' => $message,
             'auto_replied' => !is_null($autoReply),
         ]);
     }
 
     public function getUnreadCount(Request $request)
     {
         $request->validate([
             'session_id' => 'required|string',
         ]);
 
         $count = ChatMessage::where('session_id', $request->session_id)
             ->where('sender_type', 'admin')
             ->where('is_read_by_customer', false)
             ->count();
 
         return response()->json([
             'status' => 'success',
             'unread_count' => $count,
         ]);
     }
 }
