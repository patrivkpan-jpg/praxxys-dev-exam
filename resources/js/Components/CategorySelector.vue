<script setup>
    import SelectInput from '@/Components/SelectInput.vue';
    import SelectOption from '@/Components/SelectOption.vue';

    const props = defineProps({
        categories: {
            type: Object
        }
    })

    const model = defineModel({
        type: String,
        required: true,
    });
</script>

<template>
    <SelectInput
        id="category"
        v-model="model"
    >
        <option disabled value="">Select a category</option>
        <SelectOption v-for="category in categories" :option="category.name" />
    </SelectInput>
</template>