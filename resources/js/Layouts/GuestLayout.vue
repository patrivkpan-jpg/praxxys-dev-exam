<template>
    <div class="main-container h-100 bg-secondary d-flex align-items-center justify-content-center">
        <div class="mb-3">
            <span class="h2 text-dark fw-semibold"><span class="praxxys">PRA<span class="text-warning">XX</span>YS</span> Technical Exam</span>
        </div>
        <div class="slot-container bg-body p-5 rounded">
            <slot />
        </div>
    </div>
</template>

<style>
    .main-container {
        flex-direction: column;
    }
    .praxxys {
        letter-spacing: 10px;
    }
    .slot-container {
        box-shadow: 1px 1px 5px black;
    }
</style>