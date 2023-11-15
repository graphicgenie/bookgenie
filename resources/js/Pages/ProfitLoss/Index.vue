<script setup>
import { router } from '@inertiajs/vue3'

defineProps({
    revenue: Object,
    expenses: Object,
})
</script>

<template>
    <div class="flex justify-between pl-2 pb-8">
        <h1 class="text-3xl font-medium">Resultaatrekening</h1>
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
        <div v-for="item in revenue.data" :key="item.id">{{ item.name }}: {{ item.total }}</div>
        <hr />
        <div v-for="item in expenses.data" :key="item.id">{{ item.name }}: {{ item.total }}</div>
    </div>
</template>
