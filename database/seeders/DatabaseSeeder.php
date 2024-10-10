<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//use Illuminte\Database\Eloquent\Factories\HasFactory;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
*/
    public function run(): void
    {
        
        
         User::factory(100)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            //'created_at'=> date('Y-m-d'),
        ]);
    }
}
