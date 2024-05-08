<script setup>

defineProps({
    option: {
        type: String,
    },
});

</script>

<template>
    <option>{{ option }}</option>
</template>
