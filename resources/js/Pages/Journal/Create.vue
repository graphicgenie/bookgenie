<script setup>
import TextInput from '@/Components/TextInput.vue'
import { useForm } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import FormSection from '@/Components/FormSection.vue'
import { onMounted } from 'vue'
import FormGroup from '@/Components/FormGroup.vue'

defineProps({
    accounts: Object,
})

const form = useForm({
    reference: '',
    journal_date: new Date(Date.now()).toLocaleDateString(),
    journal_entries: [],
})

const addJournalEntry = () => {
    form.journal_entries.push({
        ledger_account_id: '0',
        description: '',
        debit: 0.0,
        credit: 0.0,
    })
}

const createLedgerAccount = () => form.post(route('journal.store'))

onMounted(() => {
    addJournalEntry()
    addJournalEntry()
})
</script>

<template>
    <h1 class="text-3xl font-medium pl-2 pb-8">Memoriaalboeking toevoegen</h1>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <FormSection @submitted="createLedgerAccount">
            <template #form>
                <FormGroup class="flex gap-4">
                    <div>
                        <InputLabel>Kenmerk</InputLabel>
                        <TextInput v-model="form.reference" />
                    </div>
                    <div>
                        <InputLabel>Datum</InputLabel>
                        <TextInput v-model="form.journal_date" />
                    </div>
                </FormGroup>
                <FormGroup class="flex gap-4">
                    <div class="w-4/12">Grootboek</div>
                    <div class="w-4/12">Omschrijving</div>
                    <div class="w-2/12">Debit</div>
                    <div class="w-2/12">Credit</div>
                </FormGroup>
                <FormGroup v-for="entry in form.journal_entries" class="flex gap-4">
                    <div class="w-4/12">
                        <select
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            v-model="entry.ledger_account_id"
                        >
                            <option value="0">-- Selecteer een categorie --</option>
                            <option v-for="account in accounts.data" :value="account.id">
                                {{ account.name }}
                            </option>
                        </select>
                    </div>
                    <div class="w-4/12">
                        <TextInput class="w-full" v-model="entry.description" />
                    </div>
                    <div class="w-2/12">
                        <TextInput class="w-full" v-model="entry.debit" />
                    </div>
                    <div class="w-2/12">
                        <TextInput class="w-full" v-model="entry.credit" />
                    </div>
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
