<template>
    <div class="relative">
      <button @click="toggleDropdown" class="inline-flex justify-between items-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
        <span>{{ selectedLabel || placeholder }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
      </button>
      <div v-if="isOpen" class="absolute z-10 right-0 mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 p-1 space-y-1">
        <input v-model="searchTerm" class="block w-full px-4 py-2 text-gray-800 border rounded-md border-gray-300 focus:outline-none" type="text" :placeholder="searchPlaceholder" autocomplete="off">
        <a v-for="item in filteredItems" :key="item.id" @click="selectItem(item)" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md">
          {{ item.label }}
        </a>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, watch } from 'vue';
  
  const props = defineProps({
    items: {
      type: Array,
      required: true
    },
    modelValue: {
      type: [String, Number],
      default: null
    },
    placeholder: {
      type: String,
      default: 'Select an option'
    },
    searchPlaceholder: {
      type: String,
      default: 'Search items'
    }
  });
  const emit = defineEmits(['update:modelValue']);
  
  const isOpen = ref(false);
  const searchTerm = ref('');
  const selectedLabel = computed(() => {
    const selectedItem = props.items.find(item => item.value === props.modelValue);
    return selectedItem ? selectedItem.label : null;
  });
  
  const filteredItems = computed(() => {
    return props.items.filter(item => item.label.toLowerCase().includes(searchTerm.value.toLowerCase()));
  });
  
  const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
  };
  
  const selectItem = (item) => {
    emit('update:modelValue', item.value);
    isOpen.value = false;
  };
  
  watch(() => props.modelValue, () => {
    searchTerm.value = '';
  });
  </script>
  
  <style scoped>
  /* Add any custom styles here */
  </style>
  