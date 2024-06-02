<template>
<h2 class="text-xl font-semibold mb-4">{{title}}</h2>
</template>

<script setup>
const props = defineProps({
    title:{
        type: String,
        required: true
    } 
})


</script>