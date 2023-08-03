<template>
    <div class="inline-flex justify-between items-center">
        <input type="checkbox" v-model="task.completed" @click="updatedCheckbox">
        <input class="w-full dark:bg-gray-700 border-none" type="text" v-model="task.todo" @change="updatedTodo">
    </div>
</template>

<script setup lang="ts">
const props = defineProps({
    'task': {
        type: Object,
        required: true
    }
});

const emit = defineEmits();

const updatedTodo = () => {
    emit('update:task', { ...props.task });
}

const updatedCheckbox = () => {
    emit('update:task', { ...props.task, completed: !props.task.completed });
}
</script>
