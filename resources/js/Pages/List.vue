<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ListTask } from '@/types/todo';
import { computed } from 'vue';

import ListTitleInput from '@/Components/TODO/ListTitleInput.vue';
import TaskInput from '@/Components/TODO/TaskInput.vue';
import Task from '@/Components/TODO/Task.vue';

const props = defineProps({
    'list': {
        type: Object,
        required: true
    },
    'tasks': {
        type: Array as () => ListTask,
        reactive: true
    }
});

const tasks = computed(() => props.tasks);

function updateTask(task: ListTask) {
    router.patch(route('tasks.update', { list_id: props.list.id, task_id: task.id }), task);
    const index = props.tasks.findIndex((t: ListTask) => t.id === task.id);
    props.tasks[index] = task;
}
</script>

<template>
    <Head :title="list.title" />

    <AuthenticatedLayout>
        <template #header>
            <ListTitleInput :list="list" />
        </template>

        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <TaskInput :list="list" />
                        <!-- MAYBE make this a component? -->
                        <div class="flex flex-row justify-evenly">
                            <section class="w-1/2 border border-black rounded-lg p-4 m-4">
                                <h2>
                                    <h2 class="text-2xl font-bold underline">Ongoing</h2>
                                </h2>
                                <ul class="p-4">
                                    <li v-for="task in tasks">
                                        <Task v-if="!task.completed" :task="task" @update:task="updateTask" />
                                    </li>
                                </ul>
                            </section>
                            <section class="w-1/2 border border-black rounded-lg p-4 m-4">
                                <h2>
                                    <h2 class="text-2xl font-bold underline">Completed</h2>
                                </h2>
                                <ul class="p-4">
                                    <li v-for="task in tasks">
                                        <Task v-if="task.completed" :task="task" @update:task="updateTask" />
                                    </li>
                                </ul>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
