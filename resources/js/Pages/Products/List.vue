<script setup>
import Dashboard from '@/Pages/Dashboard.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    products: {
        type: Object
    }
});

const deleteProduct = (id) => {
    router.delete(route('product.destroy', {
        id: id
    }))
}

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
            <li>
                <Link
                    :href="route('product.edit', {
                        id: product.id
                    })"
                    as="button"
                    class="btn btn-info"
                    type="button"
                >
                    Edit
                </Link>
                <button 
                    class="btn btn-danger"
                    @click="deleteProduct(product.id)"
                >
                    Delete
                </button>
            </li>
        </ul>
    </Dashboard>
</template>
