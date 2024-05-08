<script setup>
import Dashboard from '@/Pages/Dashboard.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    products: {
        type: Object
    }
});

</script>

<template>
    <Head title="Product List" />

    <Dashboard>
        <ul v-for="product in products.data">
            <li>{{ product.name }}</li>
            <li>
                <div v-html="product.description">

                </div>
            </li>
            <li>{{ product.category.name }}</li>
            <li>{{ product.datetime }}</li>
        </ul>
    </Dashboard>
</template>
