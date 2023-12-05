<script setup>
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid/index.js'
import {
    Combobox,
    ComboboxButton,
    ComboboxInput,
    ComboboxOption,
    ComboboxOptions,
} from '@headlessui/vue'
import InputLabel from '@/Components/InputLabel.vue'
import { computed, onMounted, ref, watch } from 'vue'
import throttle from 'lodash/throttle.js'

const props = defineProps({
    label: {
        type: String,
        default: 'Klant',
    },
    modelValue: Object,
})

const emit = defineEmits(['update:modelValue, submitted'])

let transactions = ref([])
let ledgers = ref([])
const query = ref('')
const selectedTransaction = ref(props.modelValue)
const filteredTransactions = computed(() =>
    query.value === ''
        ? transactions.value.filter((transaction) => {
              return (
                  transaction.contact.company_name
                      ?.toLowerCase()
                      .includes(query.value.toLowerCase()) ||
                  transaction.invoice_number.toLowerCase().includes(query.value.toLowerCase()) ||
                  transaction.contact.firstname
                      ?.toLowerCase()
                      .includes(query.value.toLowerCase()) ||
                  transaction.contact.lastname?.toLowerCase().includes(query.value.toLowerCase())
              )
          })
        : ledgers.value.filter((ledger) => {
              return ledger.name?.toLowerCase().includes(query.value.toLowerCase())
          })
)

watch(
    query,
    throttle(function () {
        axios(route('transaction.search'), { params: { query: query.value } }).then((response) => {
            transactions = ref(response.data.invoices)
            ledgers = ref(response.data.ledgers)
        })
    }, 10)
)

watch(selectedTransaction, () => emit('submitted', selectedTransaction.value))

const displayName = (transaction) => {
    let response = ''
    switch (transaction.type) {
        case 'purchase_invoice':
        case 'sales_invoice':
            if (transaction?.invoice_number) response += transaction.invoice_number
            if (transaction?.contact?.company_name)
                response += ' - ' + transaction.contact.company_name
            else if (transaction?.contact?.firstname)
                response +=
                    ' - ' + transaction.contact.firstname + ' ' + transaction.contact.lastname
            if (transaction?.invoice_date) response += ' - ' + transaction.invoice_date
            if (transaction?.total) response += ' - ' + transaction.total
            break
        case 'current_assets':
        case 'current_liabilities':
        case 'non_current_assets':
        case 'expenses':
        case 'revenue':
        case 'equity':
            response = transaction.name
    }

    return response
}
</script>

<template>
    <Combobox as="div" v-model="selectedTransaction" class="w-1/3">
        <InputLabel>{{ label }}</InputLabel>
        <div class="relative mt-2">
            <ComboboxInput
                class="w-full rounded-md border-0 bg-white text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:leading-6"
                @change="query = $event.target.value"
                :display-value="(transaction) => displayName(transaction)"
            />
            <ComboboxButton
                class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none"
            >
                <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
            </ComboboxButton>

            <ComboboxOptions
                v-if="filteredTransactions.length > 0"
                class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
            >
                <ComboboxOption
                    v-for="transaction in filteredTransactions"
                    :key="transaction.id"
                    :value="transaction"
                    as="template"
                    v-slot="{ active, selected }"
                >
                    <li
                        :class="[
                            'relative cursor-default select-none py-2 pl-3 pr-9',
                            active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                        ]"
                    >
                        <span :class="['block truncate', selected && 'font-semibold']">
                            {{ displayName(transaction) }}
                        </span>

                        <span
                            v-if="selected"
                            :class="[
                                'absolute inset-y-0 right-0 flex items-center pr-4',
                                active ? 'text-white' : 'text-indigo-600',
                            ]"
                        >
                            <CheckIcon class="h-5 w-5" aria-hidden="true" />
                        </span>
                    </li>
                </ComboboxOption>
            </ComboboxOptions>
        </div>
    </Combobox>
</template>

<style scoped></style>