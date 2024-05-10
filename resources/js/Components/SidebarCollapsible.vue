<script setup>
import { ref, computed } from 'vue';
    const props = defineProps({
        show: {
            type: Boolean
        },
        label: {
            type: String,
            required: true,
        },
    });

    const collapseId = computed(() => {
        return `collapsible${props.label}`
    })

    const collapsed = ref(props.show)
</script>

<template>
    <button 
        class="btn mt-2 mx-2 ps-3"
        :class="[ collapsed ? 'btn-primary' : 'btn-secondary' ]" 
        type="button" data-bs-toggle="collapse" :data-bs-target="`#${collapseId}`"
        @click="collapsed = !collapsed"
    >
        {{ label }}
    </button>
    <div 
        class="collapse mb-2 mx-2"
        :class="{ 'show': show }"
        :id="collapseId">
        <div class="d-flex flex-column">
            <slot />
        </div>
    </div>
</template>