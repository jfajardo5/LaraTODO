<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (\App\Models\User::all() as $user) {
            $this->createTasks($user);
        }
    }

    protected function createTasks(\App\Models\User $user): void
    {
        foreach ($user->lists()->get() as $list) {
            for ($i = 0; $i < 20; $i++) {
                $task = new \App\Models\Tasks;
                $task->todo = fake()->sentence();
                $task->lists_id = $list->id;
                $task->user_id = $user->id;
                $task->save();
            }
        }
    }
}
