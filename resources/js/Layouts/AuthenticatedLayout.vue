<script setup>
import Sidebar from '@/Components/Sidebar.vue'
import SidebarLink from '@/Components/SidebarLink.vue'

</script>

<template>
    <div class="container-fluid h-100 p-0">
        <div class="row h-100">
            <section class="col-2 p-0">
                
                <nav class="navbar bg-secondary border-bottom">
                    <div class="container-fluid">
                        <span class="navbar-brand mb-0 mx-auto text-dark fw-semibold">PRA<span class="text-warning">XX</span>YS Technical Exam</span>
                    </div>
                </nav>
                <Sidebar class="bg-secondary h-100">
                    <SidebarLink :href="route('product.index')">
                        View Products
                    </SidebarLink>
                    <SidebarLink :href="route('product.create')">
                        Add Product
                    </SidebarLink>
                    <SidebarLink :href="route('logout')" as="button" method="POST">
                        Logout
                    </SidebarLink>
                </Sidebar>
            </section>
            <main class="col-10 p-0">
                <nav class="main-nav navbar bg-body-secondary border-bottom border-start">
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
