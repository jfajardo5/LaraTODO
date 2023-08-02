<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ListModel } from '@/types/todo';

const props = defineProps({
    'lists': {
        type: Array as () => ListModel
    }
})

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
                            <div class="inline-flex items-center mt-2 mb-2">
                                <input class="border-gray-900 rounded-l-lg" v-model="form.new_list" type="text"
                                    name="new_list">
                                <button class="rounded-r-lg px-4 py-2 bg-purple-800" type="submit">Add List</button>
                            </div>
                        </form>
                        <div class="flex flex-row mt-5">
                            <div v-for="list in  lists">
                                <div class="flex flex-col bg-gray-700 p-4 m-2 rounded-lg">
                                    <a :href="list.url" class="text-xl">{{ list.title }}</a>
                                    <span class="text-sm">({{ list.tasks_count }} tasks)</span>
                                </div>
                            </div>
                        </div>
                        <!-- TODO Create a component to display lists -->
                        <!-- TODO Create functionality to create a new list -->
                        <!-- TODO Create functionality to add tasks to a list -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
