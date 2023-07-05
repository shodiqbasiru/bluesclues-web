<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\News;
use App\Models\Song;
use App\Models\Admin;
use App\Models\MerchCategory;
use App\Models\Merchandise;
use App\Models\Event;
use App\Models\Message;
use App\Models\ShowRequest;


class DatabaseSeeder extends Seeder
{
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run()
        {
                User::factory(1)->create();
                News::factory(54)->create();
                // Song::factory(31)->create();
                Admin::factory(1)->create();
                MerchCategory::factory(4)->create();
                Merchandise::factory(100)->create();
                Event::factory(31)->create();
                Message::factory(41)->create();
                ShowRequest::factory(50)->create();

                // \App\Models\User::factory()->create([
                //     'name' => 'Test User',
                //     'email' => 'test@example.com',
                // ]);
        }
}
