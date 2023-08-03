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
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            $this->createTasks($user);
        }
    }

    protected function createTasks(\App\Models\User $user): void
    {
        $lists = $user->lists()->get();
        foreach ($lists as $list) {
            for ($i = 0; $i < 5; $i++) {
                $task = new \App\Models\Tasks;
                $task->todo = fake()->sentence();
                $task->lists_id = $list->id;
                $task->user_id = $user->id;
                $task->save();
            }
        }
    }
}
