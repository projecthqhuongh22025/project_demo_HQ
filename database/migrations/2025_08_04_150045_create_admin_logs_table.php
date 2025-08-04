<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('action');               // Ví dụ: 'update_user'
            $table->string('target_type')->nullable(); // Ví dụ: 'User'
            $table->unsignedBigInteger('target_id')->nullable(); // ID bị thao tác
            $table->json('data')->nullable();       // Dữ liệu đầu vào
            $table->ipAddress('ip')->nullable();
            $table->timestamps();

            // Optional: nếu bạn muốn ràng buộc FK với bảng users
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_logs');
    }
};
