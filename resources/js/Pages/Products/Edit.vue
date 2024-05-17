<template>
    <head title="Edit" />
    <AuthenticatedLayout>

        <form @submit.prevent="updateProduct">
            <div>
                <InputLabel for="name" value="Nom Produit" />
                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"  autocomplete="name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>


            <div class="mt-3">
                <InputLabel for="qte" value="Quantité" />
                <TextInput id="qte" type="number" class="mt-1 block w-full" v-model="form.qte" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-3">
                <InputLabel for="init_price" value="Prix de Gros" />
                <TextInput id="init_price" type="number" class="mt-1 block w-full" v-model="form.init_price" autocomplete="init_price" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-3">
                <InputLabel for="selling_price" value="Prix de vente" />
                <TextInput id="selling_price" type="number" class="mt-1 block w-full" v-model="form.selling_price" autocomplete="selling_price" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <div class="mt-3">
                <InputLabel for="description" value="Description" />
                <TextInput id="description" type="text" class="mt-1 block w-full" v-model="form.description" autocomplete="description" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>




            <div class="flex flex-row p-10">
                <div class="basis-1/2"></div>
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Mettre à jour
                </PrimaryButton>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<script setup>
import {Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';


const props = defineProps({
    product: Object
});

const form = useForm({
    name: props.product.name,
    qte: props.product.qte,
    init_price: props.product.init_price,
    selling_price: props.product.selling_price,
    description: props.product.description,
});

const updateProduct = () => {
    form.put(route('products.update', props.product.id), {
        onFinish: () => form.reset()
    });
};
</script>