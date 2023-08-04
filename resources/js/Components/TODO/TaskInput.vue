<template>
    <div class="w-full inline-flex justify-center items-center p-6">
        <form @submit.prevent="submit">
            <div class="inline-flex items-center">
                <input v-model="form.todo" class="border-gray-900 rounded-l-lg text-gray-800" type="text" name="todo"
                    placeholder="Enter a new task">
                <button class="px-4 py-2 bg-green-600 rounded-r-lg" type="submit">Add Task</button>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    'list': {
        type: Object,
        required: true
    },
});

const form = useForm({
    'todo': ''
});

function submit() {
    form.post(route('tasks.create', { 'list_id': props.list.id }), {
        onFinish: () => {
            form.todo = '';
        },
    });
}
</script>
