<script setup>
    
    import { defineProps } from 'vue'

    const props = defineProps({
        canMultiple: Boolean,
        accept: String
    })

</script>

<template>
    <input
        type="file"
        :multiple="canMultiple"
        :accept="accept"
        @change="$emit('fileChanged', $event.target.files)"
    />
</template>
