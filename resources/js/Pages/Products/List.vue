<script setup>
import Dashboard from '@/Pages/Dashboard.vue';
import TextInput from '@/Components/TextInput.vue';
import CategorySelector from '@/Components/CategorySelector.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';

const props = defineProps({
    categories: {
        type: Object
    },
    products: {
        type: Object
    }
});

const page = usePage();

const search = ref(page.props.parameters.search);

const categorySearch = ref(page.props.parameters.category);

const pageNumber = ref(page.props.parameters.page);

const searchUrl = computed(() => {
    let searchUrl = new URL(route('product.index'))
    searchUrl.searchParams.append('page', pageNumber.value)
    if (search.value || categorySearch.value) {
        searchUrl.searchParams.append('search', search.value)
    }
    if (categorySearch.value) {
        searchUrl.searchParams.append('category', categorySearch.value)
    }
    return searchUrl;
})

watch(() => searchUrl.value, (updatedSearchUrl) => {
    router.visit(updatedSearchUrl, {
        replace: true,
        preserveState: true,
        preserveScroll: true
    })
})

const resetSearch = () => {
    search.value = ''
    categorySearch.value = ''
}

const deleteProduct = (id) => {
    router.delete(route('product.destroy', {
        id: id
    }))
}

</script>

<template>
    <Head title="Product List" />

    <Dashboard>
        <TextInput 
            id="search"
            type="text"
            v-model="search"
        />
        <CategorySelector 
            :categories
            v-model="categorySearch"
        />
        <button 
        class="btn btn-info"
        @click="resetSearch">
            Reset Search
        </button>
        
        <div>
            <Link
                :href="route('product.create')"
                as="button"
                class="btn btn-primary"
                type="button"
            >
                Add Product
            </Link>
        </div>

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
        <Pagination 
            v-if="products.meta.last_page > 1"
            :pageNumber="pageNumber"
            :links="products.meta.links"
            :numberOfPages="products.meta.last_page"
            @update-page="(updatedPageNumber) => pageNumber = updatedPageNumber"
        />
    </Dashboard>
</template>
