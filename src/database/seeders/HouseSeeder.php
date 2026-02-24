<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        House::factory()->count(20)->create();
        foreach (House::all() as $house) {
            $users = User::inRandomOrder()->take(rand(1, 3))->pluck('id');
            foreach ($users as $user) {
                $house->user()->attach($users, ['is_owner' => rand(0,1)]);
            }
        }
    }
}
