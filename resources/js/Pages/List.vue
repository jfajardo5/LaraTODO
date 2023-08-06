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
                        <div class="flex flex-row justify-evenly">
                            <ListBody title="Ongoing">
                                <li v-for="task in tasks">
                                    <Task v-if="!task.completed" :task="task" @update:task="updateTask" />
                                </li>
                            </ListBody>
                            <ListBody title="Completed">
                                <li v-for="task in tasks">
                                    <Task v-if="task.completed" :task="task" @update:task="updateTask" />
                                </li>
                            </ListBody>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ListTask } from '@/types/todo';
import { computed } from 'vue';

import ListTitleInput from '@/Components/TODO/ListTitleInput.vue';
import TaskInput from '@/Components/TODO/TaskInput.vue';
import Task from '@/Components/TODO/Task.vue';
import ListBody from '@/Components/TODO/ListBody.vue';

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
    if (task.todo !== '') {
        router.patch(route('tasks.update', { list_id: props.list.id, task_id: task.id }), task);
        return;
    }
    router.delete(route('tasks.delete', { list_id: props.list.id, task_id: task.id }));
}
</script>
