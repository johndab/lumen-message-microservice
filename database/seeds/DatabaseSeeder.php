<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Thread::class, 50)->create()->each(function ($t) {
            factory(App\Message::class, 10)->create(['thread_id' => $t->id]);
            App\ClientThread::create(['thread_id' => $t->id, 'client_id' => 1]);
            App\ClientThread::create(['thread_id' => $t->id, 'client_id' => 2]);
            App\ClientThread::create(['thread_id' => $t->id, 'client_id' => 3]);
        });
    }
}
