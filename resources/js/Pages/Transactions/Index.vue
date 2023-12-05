<script setup>
import TransactionSearch from '@/Components/TransactionSearch.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TransAction from '@/Components/TransAction.vue'
import { router } from '@inertiajs/vue3'

defineProps(['transactions'])
</script>

<template>
    <div class="flex justify-between pl-2 pb-8">
        <h1 class="text-3xl font-medium">Bank</h1>
        <PrimaryButton @click.prevent="router.get(route('transactions.create'))">
            + Nieuwe transacties importeren
        </PrimaryButton>
    </div>
    <div>
        <TransAction
            :transaction="transaction"
            v-for="transaction in transactions.data"
            :key="transaction.id"
        >
        </TransAction>
    </div>
</template>
