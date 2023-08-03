<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (\App\Models\User::all() as $user) {
            for ($i = 0; $i < 10; $i++) {
                $list = new \App\Models\Lists;
                $list->title = fake()->sentence();
                $user->lists()->save($list);
            }
        }
    }
}
