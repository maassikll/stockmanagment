<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            Restauration des produits supprimés
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

        <div v-if="restoreProducts && restoreProducts.data && restoreProducts.data.length" class="inline-block min-w-full overflow-hidden rounded-lg shadow">
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
                    <tr v-for="product in restoreProducts.data" :key="product.id" class="text-gray-700">
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

                        <td class="border-b border-gray-200 bg-white px-5 py-5 text-sm">
                            <form @submit.prevent=" restoreProduct(product.id)">
                                <button type="submit" class="text-indigo-600 hover:text-indigo-900">Restaurer</button>
                            </form>
                        </td>
                        
                    </tr>
                </tbody>
            </table>

            <div class="flex flex-col items-center border-t bg-white px-5 py-5 xs:flex-row xs:justify-between">
                <pagination :links="restoreProducts.links" />
            </div>
        </div>
        <div v-else class="text-center py-10">
            <p class="text-gray-500">No products to restore</p>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head, useForm } from '@inertiajs/vue3';
import debounce from 'lodash.debounce'

const props = defineProps({
    restoreProducts: {
        type: Object,
        required: true,
        default: () => ({ data: [], links: [] })
    },
    search: String
});
const form = useForm({
    search: props.search || '',
});

const restoreProduct = (id) => {
    form.post(route('products.productRestore', id));
};

const searchProducts = debounce(() => {
    form.get(route('products.restore'), { preserveState: true, replace: true });
}, 300);
</script>
