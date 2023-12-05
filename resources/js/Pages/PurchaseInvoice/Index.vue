<script setup>
import Checkbox from '@/Components/Checkbox.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { router } from '@inertiajs/vue3'

defineProps({
    invoices: Object,
})
let euro = Intl.NumberFormat('nl-NL', {
    style: 'currency',
    currency: 'EUR',
})
</script>

<template>
    <div class="flex justify-between pl-2 pb-8">
        <h1 class="text-3xl font-medium">Inkoop facturen</h1>
        <PrimaryButton @click.prevent="router.get(route('purchase_invoices.create'))">
            + Nieuwe factuur
        </PrimaryButton>
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
                <tr>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0"></th>
                    <th
                        scope="col"
                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0"
                    >
                        Factuurnummer
                    </th>
                    <th
                        scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                    >
                        Factuurdatum
                    </th>
                    <th
                        scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                    >
                        Contact
                    </th>
                    <th
                        scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                    >
                        Totaal
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr
                    v-for="invoice in invoices.data"
                    :key="invoice.id"
                    @click="router.get(route('purchase_invoices.edit', invoice.id))"
                    class="cursor-pointer"
                >
                    <td
                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-sm font-medium sm:pr-0"
                    >
                        <Checkbox />
                    </td>
                    <td
                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0"
                    >
                        {{ invoice.invoice_number }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        {{ invoice.invoice_date }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        {{
                            invoice.contact.company_name ??
                            invoice.contact.firstname + ' ' + invoice.contact.lastname
                        }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        {{ euro.format(invoice.total) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped></style>
