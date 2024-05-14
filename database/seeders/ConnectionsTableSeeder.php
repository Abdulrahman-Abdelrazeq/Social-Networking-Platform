<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Connection;

class ConnectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            for ($j = $i + 1; $j <= 10; $j++) {
                Connection::create([
                    'user_id' => $i,
                    'friend_id' => $j,
                    'status' => 'accepted',
                ]);
            }
        }
    }
}
