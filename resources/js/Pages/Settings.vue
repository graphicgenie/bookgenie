<script setup>
import { router } from '@inertiajs/vue3'
</script>

<template>
    <div class="flex justify-between pl-2 pb-8">
        <h1 class="text-3xl font-medium">Instellingen</h1>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div
            class="bg-white shadow-xl sm:rounded-lg p-8 cursor-pointer"
            @click="router.get(route('company.index'))"
        >
            Bedrijfsgegevens
        </div>
        <div class="bg-white shadow-xl sm:rounded-lg p-8">Grootboek</div>
        <div class="bg-white shadow-xl sm:rounded-lg p-8">BTW</div>
    </div>
</template>
