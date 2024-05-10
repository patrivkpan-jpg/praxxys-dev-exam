<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        class="btn btn-secondary"
        :href="href"
    >
        <slot />
    </Link>
</template>
