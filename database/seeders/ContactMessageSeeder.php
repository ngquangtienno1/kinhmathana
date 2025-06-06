<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run()
    {
        // Tạo 50 tin nhắn thông thường
        ContactMessage::factory()->count(50)->create();

        // Tạo 10 tin nhắn spam
        ContactMessage::factory()->count(10)->spam()->create();

        // Tạo 20 tin nhắn đã được trả lời
        ContactMessage::factory()->count(20)->replied()->create();

        // Tạo 15 tin nhắn đã được đọc
        ContactMessage::factory()->count(15)->read()->create();
    }
}