<script setup>
import Sidebar from '@/Components/Sidebar.vue'
import SidebarCollapsible from '@/Components/SidebarCollapsible.vue'
import SidebarLink from '@/Components/SidebarLink.vue'

</script>

<template>
    <div class="container-fluid h-100 p-0">
        <div class="row h-100">
            <aside class="col-2 p-0 h-100 position-fixed">
                <nav class="navbar bg-secondary border-bottom">
                    <div class="container-fluid">
                        <span class="navbar-brand mb-0 mx-auto text-dark fw-semibold">PRA<span class="text-warning">XX</span>YS Technical Exam</span>
                    </div>
                </nav>
                <Sidebar>
                    <SidebarCollapsible
                        :show="$page.props.page === 'products'"
                        :label="'Product'"
                    >
                        <SidebarLink :href="route('product.index')" as="button">
                            > View Products
                        </SidebarLink>
                        <SidebarLink :href="route('product.create')" as="button">
                            > Add Product
                        </SidebarLink>
                    </SidebarCollapsible>
                    <SidebarLink class="btn btn-secondary" :href="route('logout')" as="button" method="POST">
                        Logout
                    </SidebarLink>
                </Sidebar>
            </aside>
            <main class="col-10 p-0">
                <nav class="main-nav navbar w-100 bg-body-secondary border-bottom border-start">
                    <div class="container-fluid">
                        <span></span>
                        <span class="navbar-text float-end me-2">Greetings, {{ $page.props.auth.user.name }}!</span>
                    </div>
                </nav>
                <div class="bg-body border-start p-3">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<style>
    main {
        margin-left: 16.6%!important;
    }
</style>
