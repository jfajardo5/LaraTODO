<template>
    <form @submit.prevent="update">
        <div class="inline-flex items-center">
            <div class="inline-flex items-center">
                <input type="text" v-model="form.title"
                    class="dark:bg-gray-700 border-gray-900 rounded-l-lg font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <button class="px-4 py-2 bg-purple-800 rounded-r-lg" type="submit">Update Name</button>
            </div>
        </div>
    </form>
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
    'title': props.list.title
});

function update() {
    form.patch(route('lists.update', { 'id': props.list.id }), {
        onFinish: () => {
            form.title = form.title;
        },
    });
}
</script>

