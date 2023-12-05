<script setup>
import TransactionSearch from '@/Components/TransactionSearch.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { ref } from 'vue'
import axios from 'axios'

const props = defineProps({
    transaction: Object,
})

const invoice = ref({})
const setInvoice = (data) => {
    invoice.value = data
}

const store = () => {
    axios
        .put(route('transactions.update', props.transaction.id), {
            link_id: invoice.value.id,
            link_type: invoice.value.type,
        })
        .then((response) => (props.transaction.link_type = response.data.link_type))
}

let euro = Intl.NumberFormat('nl-NL', {
    style: 'currency',
    currency: 'EUR',
})
</script>

<template>
    <div class="mb-8 p-4 rounded-lg bg-white">
        <div class="w-full flex justify-between gap-4">
            <div>{{ transaction.description }}</div>
            <div class="whitespace-nowrap">
                {{
                    transaction.type === 'C'
                        ? '+ ' + euro.format(transaction.amount)
                        : '- ' + euro.format(transaction.amount)
                }}
            </div>
        </div>
        <TransactionSearch v-model="transaction.link" @submitted="setInvoice" />
        <PrimaryButton
            :disabled="transaction.link_type !== null && transaction.link_type !== ''"
            class="mt-4"
            @click.prevent="store"
            >Opslaan
        </PrimaryButton>
    </div>
</template>

<style scoped></style>
