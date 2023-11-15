<script setup>
import TextInput from '@/Components/TextInput.vue'
import { useForm } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import FormSection from '@/Components/FormSection.vue'
import FormGroup from '@/Components/FormGroup.vue'

defineProps({
    accounts: Object,
    types: Object,
    parents: Object,
})

const form = useForm({
    name: '',
    type: '',
    parent_id: 0,
    account_type: '',
})

const account_types = [
    {
        name: 'Debit',
        id: 'debit',
    },
    {
        name: 'Credit',
        id: 'credit',
    },
    {
        name: 'Omzet',
        id: 'result',
    },
    {
        name: 'Kosten',
        id: 'result',
    },
]
const createLedgerAccount = () => form.post(route('ledger_accounts.store'))
</script>

<template>
    <h1 class="text-3xl font-medium pl-2 pb-8">Grootboek toevoegen</h1>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <FormSection @submitted="createLedgerAccount">
            <template #title>Balans categorie toevoegen</template>

            <!--        <template #description>-->
            <!--            Update your account's profile information and email address.-->
            <!--        </template>-->

            <template #form>
                <FormGroup>
                    <InputLabel>Categorie naam</InputLabel>
                    <TextInput class="w-1/3" v-model="form.name" />
                </FormGroup>
                <FormGroup>
                    <InputLabel>Type</InputLabel>
                    <select
                        class="w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.type"
                    >
                        <option>-- maak een keuze --</option>
                        <option v-for="type in types" :value="type.id">
                            {{ type.name }}
                        </option>
                    </select>
                </FormGroup>
                <FormGroup>
                    <InputLabel>Bovenliggende categorie</InputLabel>
                    <select
                        class="w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.parent_id"
                    >
                        <option>-- geen --</option>
                        <option v-for="parent in parents" :value="parent.id">
                            {{ parent.name }}
                        </option>
                    </select>
                </FormGroup>
                <FormGroup>
                    <InputLabel>Type</InputLabel>
                    <select
                        class="w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.account_type"
                    >
                        <option>-- geen --</option>
                        <option v-for="parent in account_types" :value="parent.id">
                            {{ parent.name }}
                        </option>
                    </select>
                </FormGroup>
            </template>
            <template #actions>
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Opslaan
                </PrimaryButton>
            </template>
        </FormSection>
    </div>
</template>
