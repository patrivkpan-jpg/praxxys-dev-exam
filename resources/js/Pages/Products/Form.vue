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

        <form @submit.prevent="submit">
            <section v-show="formStep === 1">
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        type="text"
                        v-model="form.name"
                    />

                    <InputError :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="email" value="Category" />

                    <CategorySelector 
                        :categories
                        v-model="form.category"
                    />

                    <InputError :message="form.errors.category" />
                </div>

                <div>
                    <InputLabel for="description" value="Description" />

                    <HTMLEditor 
                        id="description"
                        v-model="form.description"
                    />

                    <InputError :message="form.errors.description" />
                </div>
            </section>

            <section v-show="formStep === 2">
                <div>
                    <InputLabel for="images" value="Image" />

                    <FileInput 
                        id="images"
                        canMultiple
                        accept="image/jpg, image/jpeg, image/png"
                        @file-changed="(images) => form.images = images"
                    />

                    <InputError :message="form.errors.images" />
                </div>
            </section>

            <section v-show="formStep === 3">
                <div>
                    <InputLabel for="datetime" value="Datetime" />

                    <VueDatePicker
                        id="datetime"
                        v-model="form.datetime"
                        readonly
                    />
                    <VueDatePicker
                        id="datetime"
                        v-model="form.datetime"
                        inline auto-apply dark required
                    />

                    <InputError :message="form.errors.datetime" />
                </div>
            </section>

            <div class="flex items-center justify-end mt-4">

                <button class="btn btn-secondary" v-show="formStep !== 1" type="button" @click="prevStep">
                    Prev
                </button>
                <button class="btn btn-primary" v-show="formStep !== 3" type="button" @click="nextStep">
                    Next
                </button>
                <button class="btn btn-success" v-show="formStep === 3" type="button" @click="submit">
                    {{ action }}
                </button>
            </div>
        </form>
    </Dashboard>
</template>
