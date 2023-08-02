<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import Task from '@/Components/TODO/Task.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ListTask } from '@/types/todo';
import { computed } from 'vue';

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

const form = useForm({
    'task': ''
});

function submit() {
    form.post(route('tasks.create', { 'list_id': props.list.id }), {
        onFinish: () => {
            form.task = '';
        },
    });
}

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
                            <input v-model="form.task" class="rounded-lg text-gray-800" type="text" name="task">
                            <SecondaryButton type="submit">Add Task</SecondaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
