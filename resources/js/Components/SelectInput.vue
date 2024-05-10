<script setup>
import { ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

</script>

<template>
    <select
        class="form-select mt-1"
        v-model="model"
        ref="input">
        <slot />
    </select>
</template>
