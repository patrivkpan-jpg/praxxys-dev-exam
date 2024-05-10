<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import SelectOption from '@/Components/SelectOption.vue';
import CategorySelector from '@/Components/CategorySelector.vue';
import HTMLEditor from '@/Components/HTMLEditor.vue';
import FileInput from '@/Components/FileInput.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Dashboard from '@/Pages/Dashboard.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    categories: {
        type: Object
    },
    product: {
        type: Object
    }
});

const isUpdate = computed(() => {
    return (props.product !== undefined)
})

const action = computed(() => {
    return (isUpdate.value) ? 'Edit' : 'Create';
})


const form = useForm({
    name: (isUpdate.value) ? props.product.data.name : '',
    category: (isUpdate.value) ? props.product.data.category.name : '',
    description: (isUpdate.value) ? props.product.data.description : '',
    images: '',
    datetime: (isUpdate.value) ? props.product.data.datetime : new Date(),
});

const formStep = ref(1);

const submit = () => {
    let submitAction = (isUpdate.value) ? 'update' : 'store';
    let id = (isUpdate.value) ? { id: props.product.data.id } : {}
    form.transform((data) => ({
        ...data,
        '_method' : (isUpdate.value) ? 'PUT' : 'POST'
    }))
    .post(route(`product.${submitAction}`, id));
};

const nextStep = () => {
    form.transform((data) => ({
        ...data,
        'step' : formStep.value,
        'isUpdate' : isUpdate.value,
    }))
    .post(route('product.validate'), {
        onSuccess: () => {
            formStep.value++;
        }
    })
}

const prevStep = () => {
    formStep.value--;
}

</script>

<template>
    <Dashboard>
        <Head :title="action + ' Product'" />

        <h1 class="fw-semibold">{{ action }} Product</h1>
        <div class="d-flex justify-content-evenly my-4">
            <span class="step-counter border"
                :class="[ formStep === 1 ? 'bg-warning border-secondary' : 'bg-secondary-subtle border-warning' ]" 
            >
                1
            </span>
            <span class="step-counter border"
                :class="[ formStep === 2 ? 'bg-warning border-secondary' : 'bg-secondary-subtle border-warning' ]" 
            >
                2
            </span>
            <span class="step-counter border"
                :class="[ formStep === 3 ? 'bg-warning border-secondary' : 'bg-secondary-subtle border-warning' ]" 
            >
                3
            </span>
        </div>
        <form @submit.prevent="submit">
            <section class="row" v-show="formStep === 1">
                <div class="form-group mt-4">
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        type="text"
                        v-model="form.name"
                    />

                    <InputError 
                        class="text-danger"
                        :message="form.errors.name" 
                    />
                </div>

                <div class="form-group mt-4">
                    <InputLabel for="email" value="Category" />

                    <CategorySelector 
                        class="mt-1"
                        :categories
                        v-model="form.category"
                    />

                    <InputError 
                        class="text-danger"
                        :message="form.errors.category" 
                    />
                </div>

                <div class="form-group mt-4">
                    <InputLabel for="description" value="Description" />

                    <HTMLEditor 
                        id="description"
                        class="mt-1"
                        v-model="form.description"
                    />

                    <InputError 
                        class="text-danger"
                        :message="form.errors.description" 
                    />
                </div>
            </section>

            <section v-show="formStep === 2">
                <div class="form-group mt-4">
                    <InputLabel for="images" value="Image" />

                    <FileInput 
                        id="images"
                        class="mt-1"
                        canMultiple
                        accept="image/jpg, image/jpeg, image/png"
                        @file-changed="(images) => form.images = images"
                    />

                    <InputError 
                        class="text-danger"
                        :message="form.errors.images" 
                    />
                </div>
            </section>

            <section v-show="formStep === 3">
                <div class="form-group mt-4">
                    <InputLabel for="datetime" value="Datetime" />

                    <VueDatePicker
                        id="datetime"
                        class="mt-1"
                        v-model="form.datetime"
                        readonly
                    />
                    <VueDatePicker
                        id="datetime"
                        class="mt-3"
                        v-model="form.datetime"
                        inline auto-apply dark required
                    />

                    <InputError 
                        class="text-danger"
                        :message="form.errors.datetime" 
                    />
                </div>
            </section>

            <div class="flex items-center justify-end mt-4">

                <button class="btn btn-secondary me-3 border border-dark fw-semibold" v-show="formStep !== 1" type="button" @click="prevStep">
                    Prev
                </button>
                <button class="btn btn-primary border border-dark fw-semibold" v-show="formStep !== 3" type="button" @click="nextStep">
                    Next
                </button>
                <button class="btn btn-success border border-dark fw-semibold" v-show="formStep === 3" type="button" @click="submit">
                    {{ action }}
                </button>
            </div>
        </form>
        
    </Dashboard>
</template>

<style>
    .step-counter {
        width: 50px;
        height: 50px;
        text-align: center;
        padding: 6px 0;
        font-size: 24px;
        border-radius: 50px;
    }
</style>