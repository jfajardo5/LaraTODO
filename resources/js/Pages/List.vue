<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Task from '@/Components/TODO/Task.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ListTask } from '@/types/todo';
import { reactive } from 'vue';

const props = defineProps

const tasks = reactive([
    {
        'id': 1,
        'text': "Task 1",
        'completed': true,
    },
    {
        'id': 2,
        'text': "Task 2",
        'completed': false,
    },
    {
        'id': 3,
        'text': "Task 3",
        'completed': false,
    },
    {
        'id': 4,
        'text': "Task 4",
        'completed': false,
    },
    {
        'id': 5,
        'text': "Task 5",
        'completed': false,
    },
]);

const form = useForm({
    'task': ''
});

function updateTask(updated: ListTask) {
    console.log(updated);
    const index = tasks.findIndex((t) => t.id === updated.id);
    console.log(index);
    tasks[index] = updated;
}

function submit() {
    tasks.push({
        id: 11,
        text: form.task,
        completed: false
    })
    // form.post(route('login'), {
    //     onFinish: () => {
    //         form.reset('task');
    //     },
    // });
}
</script>

<template>
    <Head title="List X" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex flex-row justify-evenly">
                            <section class="justify-self-start">
                                <h2>
                                    <h2 class="text-xl font-bold">Ongoing</h2>
                                </h2>
                                <ul class="p-2">
                                    <li v-for="task in tasks">
                                        <Task v-if="!task.completed" :task="task" @update:task="updateTask" />
                                    </li>
                                </ul>
                            </section>
                            <section class="justify-self-end">
                                <h2>
                                    <h2 class="text-xl font-bold">Completed</h2>
                                </h2>
                                <ul class="p-2">
                                    <li v-for="task in tasks">
                                        <Task v-if="task.completed" :task="task" @update:task="updateTask" />
                                    </li>
                                </ul>
                            </section>
                        </div>
                        <form @submit.prevent="submit">
                            <input v-model="form.task" class="rounded-lg" type="text" name="task">
                            <SecondaryButton type="submit">Add Task</SecondaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
