<template>
    <div class="inline-flex justify-between items-center">
        <input type="checkbox" v-model="task.completed" @click="check">
        <span class="px-2">{{ task.text }}</span>
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

const check = () => {
    emit('update:task', { ...props.task, completed: !props.task.completed });
}
</script>
