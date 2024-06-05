<template>
    <AuthenticatedLayout>
        <template #header>
            <BackButton :href="route('factures.index')" />
            Modifier le Crédit
        </template>

        <form @submit.prevent="updateFacture">
            <div class="mt-3">
                <InputLabel for="status" value="Status" />
                <select id="status" class="mt-1 block w-full pl-3 pr-10 py-2 h-12 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" v-model="form.status"> 
                    <option value="payer">Crédit Payer</option>
                    <option value="non_payer">Crédit non payer</option>
                </select>
                <InputError class="mt-2" :message="form.errors.status" />
            </div>

            <div class="flex flex-row p-10">
                <div class="basis-1/2"></div>
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Changer Status
                </PrimaryButton>
            </div>
        </form>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import BackButton from '@/Components/BackButton.vue';
import CustomDropdown from "@/Components/CustomDropdown.vue";

const props = defineProps({
    facture: {
        type: Object,
        required: true,
        default: () => ({})
    }
});

const dropdownItems = [
  { label: 'Crédit Payer', value: 'payer' },
  { label: 'Crédit Non Payer', value: 'non_payer' }
];

let selectedItem = null;

const form = useForm({
    status: props.facture.status,
});


const updateFacture  = () => {
    form.put(route('factures.update', props.facture.id), {
        onFinish: () => form.reset()
    });
};
</script>


