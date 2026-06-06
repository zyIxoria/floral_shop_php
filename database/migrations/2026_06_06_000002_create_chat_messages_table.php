<?php
 
 use Illuminate\Database\Migrations\Migration;
 use Illuminate\Database\Schema\Blueprint;
 use Illuminate\Support\Facades\Schema;
 
 return new class extends Migration
 {
     public function up(): void
     {
         Schema::create('chat_messages', function (Blueprint $table) {
             $table->id();
             $table->string('session_id');
             $table->unsignedBigInteger('user_id')->nullable();
             $table->string('sender_type'); // 'customer' or 'admin'
             $table->string('sender_name');
             $table->text('message');
             $table->boolean('is_read_by_admin')->default(false);
             $table->boolean('is_read_by_customer')->default(false);
             $table->timestamps();
 
             $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
             $table->index('session_id');
             $table->index('is_read_by_admin');
             $table->index('is_read_by_customer');
         });
     }
 
     public function down(): void
     {
         Schema::dropIfExists('chat_messages');
     }
 };
