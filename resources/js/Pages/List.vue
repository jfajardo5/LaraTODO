<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import Task from '@/Components/TODO/Task.vue';
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

const taskForm = useForm({
    'task': ''
});

const listForm = useForm({
    'title': props.list.title
});

function updateList() {
    listForm.patch(route('lists.update', { 'id': props.list.id }), {
        onFinish: () => {
            listForm.title = listForm.title;
        },
    });
}

function submitTask() {
    taskForm.post(route('tasks.create', { 'list_id': props.list.id }), {
        onFinish: () => {
            taskForm.task = '';
        },
    });
}

function updateTask(task: ListTask) {
    console.log(task);
    router.patch(route('tasks.update', { list_id: props.list.id, task_id: task.id }), task);
    const index = props.tasks.findIndex((t: ListTask) => t.id === task.id);
    props.tasks[index] = task;
}
</script>

<template>
    <Head :title="list.title" />

    <AuthenticatedLayout>
        <template #header>
            <form @submit.prevent="updateList">
                <div class="inline-flex items-center">
                    <div class="inline-flex items-center">
                        <input type="text" v-model="listForm.title"
                            class="dark:bg-gray-700 border-gray-900 rounded-l-lg font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        <button class="px-4 py-2 bg-purple-800 rounded-r-lg" type="submit">Update Name</button>
                    </div>
                </div>
            </form>
        </template>

        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="w-full inline-flex justify-center items-center p-6">
                            <form @submit.prevent="submitTask">
                                <div class="inline-flex items-center">
                                    <input v-model="taskForm.task" class="border-gray-900 rounded-l-lg text-gray-800"
                                        type="text" name="task" placeholder="Enter a new task">
                                    <button class="px-4 py-2 bg-green-600 rounded-r-lg" type="submit">Add Task</button>
                                </div>
                            </form>
                        </div>
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
