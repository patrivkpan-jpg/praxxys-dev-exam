<script setup>
    const props = defineProps({
        canMultiple: Boolean,
        accept: String
    })

</script>

<template>
    <input
        type="file"
        class="form-control"
        :multiple="canMultiple"
        :accept="accept"
        @change="$emit('fileChanged', $event.target.files)"
    />
</template>
