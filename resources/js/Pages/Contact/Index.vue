<script setup>
import { router } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue'

defineProps({
    contacts: Object,
})
</script>

<template>
    <div class="flex justify-between pl-2 pb-8">
        <h1 class="text-3xl font-medium">Contacten</h1>
        <PrimaryButton @click.prevent="router.get(route('contact.create'))">
            + Nieuw contact
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
                        Bedrijfsnaam
                    </th>
                    <th
                        scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                    >
                        Naam
                    </th>
                    <th
                        scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                    >
                        E-mail
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr
                    v-for="contact in contacts.data"
                    :key="contact.id"
                    @click="router.get(route('contact.edit', contact.id))"
                    class="cursor-pointer"
                >
                    <td
                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-sm font-medium sm:pr-0"
                    >
                        {{ contact.id }}
                    </td>
                    <td
                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0"
                    >
                        {{ contact.company_name }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        {{ contact.firstname }} {{ contact.lastname }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        {{ contact.email }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped></style>
