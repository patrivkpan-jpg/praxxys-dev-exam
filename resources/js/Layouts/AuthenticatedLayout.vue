<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Sidebar from '@/Components/Sidebar.vue'
import SidebarLink from '@/Components/SidebarLink.vue'
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <div class="container">
        <div class="row">
            <nav class="col-3">
                <Sidebar>
                    <SidebarLink :href="route('product.index')">
                        View Products
                    </SidebarLink>
                    <SidebarLink :href="route('product.create')">
                        Add Product
                    </SidebarLink>
                    <SidebarLink :href="route('logout')" method="POST">
                        Logout
                    </SidebarLink>
                </Sidebar>
            </nav>
            <main class="col-9">
                <slot />
            </main>
        </div>
    </div>
</template>
