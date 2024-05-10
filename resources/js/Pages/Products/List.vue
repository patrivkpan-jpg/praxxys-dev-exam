<script setup>
import Dashboard from '@/Pages/Dashboard.vue';
import TextInput from '@/Components/TextInput.vue';
import CategorySelector from '@/Components/CategorySelector.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import 'bootstrap-icons/font/bootstrap-icons.css'

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

    <Dashboard class="container">
        <div class="row">
            <div class="col-10">
                <div class="row input-group">
                    <div class="col-4 mx-0 pe-0">
                        <TextInput 
                            id="search"
                            type="text"
                            v-model="search"
                            placeholder="Search by name/description..."
                        />
                    </div>
                    <div class="col-4 mx-0 ps-1 pe-0">
                        <CategorySelector 
                            :categories
                            v-model="categorySearch"
                        />
                    </div>
                    <div class="col-4 ps-1">
                        <button 
                            class="btn btn-info mt-1"
                            @click="resetSearch"
                        >
                            Reset Search
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="col-2">
                <Link
                    :href="route('product.create')"
                    as="button"
                    class="btn btn-primary float-end mt-1"
                    type="button"
                >
                    Add Product
                </Link>
            </div>
        </div>

        <div class="mt-4">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Datetime</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="product in products.data">
                        <tr
                            class="product-table-row"
                        >
                            <td class="table-secondary text-center">{{ product.name }}</td>
                            <td class="table-secondary text-center">
                                <i
                                    class="toggle-description bi bi-eye"
                                    data-bs-toggle="collapse" 
                                    :data-bs-target="`#product${product.id}Description`"
                                >
                                </i>
                            </td>
                            <td class="table-secondary text-center">{{ product.category.name }}</td>
                            <td class="table-secondary text-center">{{ product.datetime }}</td>
                            <td class="table-secondary">
                                <div class="row">
                                    <div class="col-3">
                                        <Link
                                            class="product-action text-primary"
                                            :href="route('product.edit', {
                                                id: product.id
                                            })"
                                            as="button"
                                            type="button"
                                        >
                                            Edit
                                        </Link>
                                    </div>
                                    <div class="col-3">
                                        <button 
                                            class="product-action text-danger"
                                            @click.stop
                                            @click="deleteProduct(product.id)"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="product-description table-light py-0">
                                <div
                                    class="collapse show"
                                    :id="`product${product.id}Description`"
                                    v-html="product.description"
                                >
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <Pagination 
            v-if="products.meta.last_page > 1"
            :pageNumber="pageNumber"
            :links="products.meta.links"
            :numberOfPages="products.meta.last_page"
            @update-page="(updatedPageNumber) => pageNumber = updatedPageNumber"
        />
    </Dashboard>
</template>
<style>
    .toggle-description {
        cursor: pointer;
        font-size: 20px;
    }
    .toggle-description:hover {
        color: #0D6DFD;
    }
    .product-description {
        width: 100%;
    }
    .product-action {
        background-color: unset!important;;
        border: none;
    }
    .product-action:hover {
        background-color: unset!important;;
    }
</style>