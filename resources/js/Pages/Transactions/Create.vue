<script setup>
import { useForm } from '@inertiajs/vue3'
import FormGroup from '@/Components/FormGroup.vue'
import TextInput from '@/Components/TextInput.vue'
import InputLabel from '@/Components/InputLabel.vue'
import FormSection from '@/Components/FormSection.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

defineProps(['banks'])

const form = useForm({
    transactions: '',
    bank_id: 0,
})

const uploadTransactions = () => form.post(route('transactions.store'))
</script>

<template>
    <div>
        <h1 class="text-3xl font-medium pl-2 pb-8">Import banktransacties</h1>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <FormSection>
                <template #form>
                    <FormGroup>
                        <InputLabel>Bank</InputLabel>
                        <select
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                            v-model="form.bank_id"
                        >
                            <option value="0">-- Bank --</option>
                            <option v-for="bank in banks.data" :value="bank.id">
                                {{ bank.name }} - {{ bank.account_number }}
                            </option>
                        </select>
                    </FormGroup>
                    <FormGroup>
                        <InputLabel>Transacties</InputLabel>
                        <TextInput
                            type="file"
                            class="w-1/3"
                            @input="form.transactions = $event.target.files[0]"
                        />
                    </FormGroup>
                </template>
                <template #actions>
                    <PrimaryButton
                        @click.prevent="uploadTransactions"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Opslaan
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </div>
</template>

<style scoped></style>
