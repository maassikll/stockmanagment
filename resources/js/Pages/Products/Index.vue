<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            Stock
        </template>

        
        <form @submit.prevent="searchProducts" class="mb-4 flex ">
            <input
                type="text"
                v-model="form.search"
                placeholder="Chercher un produit..."
                class="w-full rounded-md border border-gray-300 p-2 m-1"
                @input="searchProducts"
            />

        </form>

        <div class="flex justify-end">
            <LinkButton :href="route('products.create')" :active="route().current('products.create')">Ajouter produit</LinkButton>
            
        </div>


        <div class="inline-block min-w-full overflow-hidden rounded-lg shadow">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Nom produit
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Quantité
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Prix gros
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Prix vente
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Bénefice
                        </th>
                        <th class="border-b-2 border-gray-200 bg-gray-100 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products.data" :key="product.id" class="text-gray-700">
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ product.name }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ product.qte }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ product.init_price }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ product.selling_price }}</p>
                        </td>
                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ product.profit }}</p>
                        </td>

                        <td class="border-b border-gray-200 bg-white   px-0 py-2 text-xxs flex ">
                            <LinkButton :href="route('products.show', { id: product.id })" :active="route().current('products.show')">Detailes</LinkButton>
                            <LinkButton :href="route('products.edit', { id: product.id })" :active="route().current('products.edit')">Modifier</LinkButton>
                            <LinkButton :href="route('products.destroy',product.id)"  method="DELETE">Supprimer</LinkButton>
                   
                        </td>


                    </tr>
                </tbody>
            </table>

            <div class="flex flex-col items-center border-t bg-white px-5 py-5 xs:flex-row xs:justify-between">
                <pagination :links="products.links" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue'
import { Head, useForm } from '@inertiajs/vue3';
import LinkButton from '@/Components/LinkButton.vue'
import debounce from 'lodash.debounce'

const props = defineProps({
    products: Object,
    search: String
});


const form = useForm({
    search: props.search || '',
});

const searchProducts = debounce(() => {
    form.get(route('products.index'), { preserveState: true, replace: true });
}, 300);

</script>
