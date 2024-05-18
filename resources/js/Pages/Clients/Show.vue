<template>
    <head title="Show" />
    <AuthenticatedLayout>
        <template #header>
            <BackButton :href="route('clients.index')" ></BackButton>
        </template>

  
        <div class="mb-4 inline-flex w-full overflow-hidden rounded-lg bg-white shadow-md">
              <div class="flex w-12 items-center justify-center bg-blue-500">
                  <svg class="h-6 w-6 fill-current text-white" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                      <path
                          d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"></path>
                  </svg>
              </div>
      
              <div class="-mx-3 px-4 py-2">
                  <div class="mx-3">
                      <span class="font-semibold text-blue-500">Detailes client</span>
                      <p class="text-sm text-gray-600">Affichage des detailes d'un client</p>
                  </div>
              </div>
          </div>
  
        <div class="mt-8">
            <div>
                <InputLabel for="first_name" value="Nom client" />
                <span>{{ client.first_name }}</span>
            </div>
  
            <div class="mt-3">
                <InputLabel for="qte" value="Prénom client" />
                <span>{{ client.last_name }}</span>
            </div>
  
            <div class="mt-3">
                <InputLabel for="phone" value="Téléphone" />
                <span>{{ client.phone }}</span>
            </div>
            
            
            <div class="mt-3">
                <InputLabel for="adresse" value="Adresse" />
                <span>{{ client.adresse }}</span>
            </div>


            
            <div class="mt-3">
                <InputLabel for="description" value="Description" />
                <span>{{ client.description }}</span>
            </div>
  
            <div class="mt-8 flex">
                <LinkButton :href="route('clients.edit', { id: client.id })" :active="route().current('clients.edit')">Modifier</LinkButton>
                <ModalButton @click="confirmDelete(client.id)" >Supprimer</ModalButton>
            </div>
        </div>

         <!-- Modal Backdrop -->
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
      <!-- Modal Content -->
      <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Confirmer la suppression</h2>
        <p class="text-gray-700 mb-4">Êtes-vous sûr de vouloir supprimer ce client ?</p>
        <div class="flex justify-end space-x-2">
          <ModalButton @click="showModal = false">Annuler</ModalButton>
          <DeleteButton :href="route('clients.destroy', { id: client.id })" method="DELETE">Supprimer</DeleteButton>
        </div>
      </div>
    </div>
  
       
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import LinkButton from '@/Components/LinkButton.vue';
import {ref} from 'vue';
import ModalButton from '@/Components/ModalButton.vue';
import DeleteButton from '@/Components/DeleteButton.vue';
import BackButton from '@/Components/BackButton.vue';

const props = defineProps({
    client: {
        type: Object,
        default: null
    }
});


const showModal = ref(false);
const clientIdToDelete = ref(null);
  
const confirmDelete = (id) => {
  clientIdToDelete.value = id;
  showModal.value = true;
};

  </script>