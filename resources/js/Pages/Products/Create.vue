<template>
    <head title="Create" />
    <AuthenticatedLayout>

        <template #header>
            <BackButton :href="route('products.index')" ></BackButton>
            Ajouter un produit au stock
        </template>


        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Nom Produit" />
                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>


            <div class="mt-3">
                <InputLabel for="qte" value="Quantité" />
                <TextInput id="qte" type="number" class="mt-1 block w-full" v-model="form.qte" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-3">
                <InputLabel for="init_price" value="Prix de Gros" />
                <TextInput id="init_price" type="number" class="mt-1 block w-full" v-model="form.init_price" required autocomplete="init_price" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-3">
                <InputLabel for="selling_price" value="Prix de vente" />
                <TextInput id="selling_price" type="number" class="mt-1 block w-full" v-model="form.selling_price" required autocomplete="selling_price" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <div class="mt-3">
                <InputLabel for="description" value="Description" />
                <TextInput id="description" type="text" class="mt-1 block w-full" v-model="form.description" required autocomplete="description" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>




            <div class="flex flex-row p-10">
                <div class="basis-1/2"></div>
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Créer
                </PrimaryButton>
            </div>
        </form>
        
        



       
    </AuthenticatedLayout>
</template>

<script setup>

import {Head, Link,useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import BackButton from '@/Components/BackButton.vue';





const props = defineProps({
    product: Object
})

const form = useForm({
    name: '',
    qte: '',
    init_price:'',
    selling_price:'',  
    description:'',  
    
});


const submit = () => {
    form.post(route('products.store'), {
        onFinish: () => form.reset()}
    );
};


</script>