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
    <div class="d-flex justify-content-center">
        <button 
        class="page-number mx-2 text-primary"
        :class="{ 'active-page-number': links[n].active }"
        v-for="n in numberOfPages"
        @click="$emit('updatePage', n)"
        >
            {{ links[n].label }}
        </button>
    </div>
</template>

<style>
.page-number {
    background-color: unset!important;;
    border: none;
}
.active-page-number {
    font-weight: 800;
}
</style>