<?php
 
 namespace App\Models;
 
 use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Illuminate\Database\Eloquent\Model;
 
 class ChatMessage extends Model
 {
     use HasFactory;
 
     protected $fillable = [
         'session_id',
         'user_id',
         'sender_type',
         'sender_name',
         'message',
         'is_read_by_admin',
         'is_read_by_customer',
     ];
 
     protected $casts = [
         'is_read_by_admin' => 'boolean',
         'is_read_by_customer' => 'boolean',
     ];
 
     public function user()
     {
         return $this->belongsTo(User::class);
     }
 }
