<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

</script>

<template>
    <select
        v-model="model"
        ref="input">
        <slot />
    </select>
</template>
