<template>
    <section class="w-1/2 border border-black rounded-lg p-4 m-4">
        <h2>
            <h2 class="text-2xl font-bold underline">
                {{ title }}
            </h2>
        </h2>
        <ul class="p-4">
            <slot />
        </ul>
    </section>
</template>
<script setup lang="ts">

const props = defineProps({
    'title': {
        type: String
    }
});
</script>

