<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    'new_list': ''
});

function submit() {
    form.post(route('lists.create'), {
    });
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h1 class="text-2xl">Your lists</h1>
                        <form @submit.prevent="submit">
                            <input v-model="form.new_list" type="text" name="new_list">
                            <button type="submit">Add List</button>
                        </form>
                        <!-- TODO Create a component to display lists -->
                        <!-- TODO Create functionality to create a new list -->
                        <!-- TODO Create functionality to add tasks to a list -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
