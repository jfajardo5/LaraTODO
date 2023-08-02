<template>
    <section>
        <h2>
            <h2>Ongoing</h2>
        </h2>
        <ul>
            <li v-for="task in tasks"> {{ task.text }} <input type="checkbox"></li>
        </ul>
        <form>
            <input class="rounded-lg" type="text">
            <SecondaryButton type="submit">Add Hello</SecondaryButton>
        </form>
    </section>
    <section>
        <h2>
            <h2>Completed</h2>
        </h2>
        <ul>
            <li v-for="task in tasks" v-if="task.completed"> {{ task.text }} <input type="checkbox" checked></li>
        </ul>
    </section>
</template>

<script setup lang="ts">
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    'tasks': {
        type: Object
    }
});
</script>
