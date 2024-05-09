<script setup>

defineProps({
    pageNumber: {
        type: String
    },
    links: {
        type: Object
    },
    numberOfPages: {
        type: Number
    }
});

defineEmits(['updatePage'])


</script>


<template>
    <button 
        class="mx-2"
        :class="{ 'active-page-number': links[n].active }"
        v-for="n in numberOfPages"
        @click="$emit('updatePage', n)"
    >
        {{ links[n].label }}
    </button>
</template>