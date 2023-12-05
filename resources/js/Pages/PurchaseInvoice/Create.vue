<script setup>
import { useForm } from '@inertiajs/vue3'
import { computed, onMounted } from 'vue'
import FormSection from '@/Components/FormSection.vue'
import TextInput from '@/Components/TextInput.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import ContactSearch from '@/Components/ContactSearch.vue'

const props = defineProps({
    ledger_accounts: Object,
    taxes: Object,
    invoice_number: Number,
})

let form = useForm({
    contact_id: Number,
    invoice_date: new Date(Date.now()).toLocaleDateString(),
    invoice_number: props.invoice_number,
    due_date: '',
    type: 'purchase_invoice',
    invoices_details: [],
    invoice_scans: null,
})

const addInvoiceDetail = () => {
    form.invoices_details.push({
        amount: '1',
        description: '',
        price: '',
        tax_id: 0,
        ledger_account_id: 0,
    })
}
const removeInvoiceDetail = (index) => form.invoices_details.splice(index, 1)
const createInvoice = () => form.post(route('purchase_invoices.store'))
const selectContact = (value) => (form.contact_id = value)

const totalExVat = computed(() => {
    let total = 0.0
    form.invoices_details.forEach((detail) => {
        if (detail.price) total += parseFloat(detail.amount) * parseFloat(detail.price)
    })
    return total
})

const totalInclVat = computed(() => {
    let total = 0.0
    form.invoices_details.forEach((detail) => {
        if (detail.price) {
            let tax = props.taxes.find((t) => t.id === detail.tax_id)
            total +=
                parseFloat(detail.amount) *
                (parseFloat(detail.price) + parseFloat(detail.price) * (tax.percentage / 100))
        }
    })
    return total
})

const totalTax = computed(() => {
    let taxes = []
    form.invoices_details.forEach((detail) => {
        if (detail.price) {
            let tax = props.taxes.find((t) => t.id === detail.tax_id)
            if (taxes.find((t) => t.id === detail.tax_id)) {
                let existing = taxes.find((t) => t.id === detail.tax_id)
                existing.total =
                    existing.total +
                    parseFloat(detail.amount) * (parseFloat(detail.price) * (tax.percentage / 100))
            } else {
                taxes.push({
                    id: tax.id,
                    name: tax.name,
                    total:
                        parseFloat(detail.amount) *
                        (parseFloat(detail.price) * (tax.percentage / 100)),
                })
            }
        }
    })

    return taxes
})

let euro = Intl.NumberFormat('nl-NL', {
    style: 'currency',
    currency: 'EUR',
})

onMounted(() => addInvoiceDetail())
</script>

<template>
    <h1 class="text-3xl font-medium pl-2 pb-8">Inkoop factuur</h1>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <FormSection @submitted="createInvoice">
            <template #form>
                <div class="flex flex-col gap-4">
                    <div>
                        <ContactSearch label="Leverancier" @submitted="selectContact" />
                    </div>
                    <div>
                        <InputLabel>Factuurnummer</InputLabel>
                        <TextInput v-model="form.invoice_number" class="w-1/3" />
                    </div>
                    <div class="flex gap-4">
                        <div>
                            <InputLabel>Factuurdatum</InputLabel>
                            <TextInput v-model="form.invoice_date" />
                        </div>
                        <div>
                            <InputLabel>Vervaldatum</InputLabel>
                            <TextInput v-model="form.due_date" />
                        </div>
                    </div>
                    <h2 class="mt-8">Factuurregels</h2>
                    <div
                        v-for="(detail, index) in form.invoices_details"
                        :key="index"
                        class="flex w-full gap-4"
                    >
                        <div class="flex-auto w-2/12">
                            <div class="flex items-center gap-4">
                                <div>
                                    <svg
                                        @click="removeInvoiceDetail(index)"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-5 h-5 text-red-600 hover:cursor-pointer"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                                        />
                                    </svg>
                                </div>
                                <TextInput class="w-full" v-model="detail.amount" type="number" />
                            </div>
                        </div>
                        <div class="flex-auto w-7/12">
                            <textarea
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full h-full"
                                v-model="detail.description"
                            />
                        </div>
                        <div class="flex-auto w-3/12">
                            <div>
                                <TextInput
                                    class="w-full"
                                    v-model="detail.price"
                                    placeholder="prijs ex. btw"
                                />
                            </div>
                            <div>
                                <select
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                    v-model="detail.tax_id"
                                >
                                    <option value="0">-- BTW --</option>
                                    <option v-for="tax in taxes" :value="tax.id">
                                        {{ tax.name }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <select
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                    v-model="detail.ledger_account_id"
                                >
                                    <option value="0">-- Categorie --</option>
                                    <option
                                        v-for="account in ledger_accounts.data"
                                        :value="account.id"
                                    >
                                        {{ account.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="flex-none w-full end">
                        <PrimaryButton @click.prevent="addInvoiceDetail()"
                            >Regel toevoegen
                        </PrimaryButton>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-2">
                    <div class="w-1/3 flex">
                        <div class="font-bold w-1/2">Subtotaal:</div>
                        <div class="text-right w-1/2">
                            {{ euro.format(totalExVat) }}
                        </div>
                    </div>
                    <div class="w-1/3">
                        <div class="flex" v-for="tax in totalTax">
                            <div class="w-1/2">{{ tax.name }}:</div>
                            <div class="text-right w-1/2">
                                {{ euro.format(tax.total) }}
                            </div>
                        </div>
                    </div>
                    <div class="w-1/3 border-t pt-2 flex">
                        <div class="text-left font-bold w-1/2">Totaal:</div>
                        <div class="text-right w-1/2">
                            {{ euro.format(totalInclVat) }}
                        </div>
                    </div>
                </div>
                <div>
                    <InputLabel>Bestanden</InputLabel>
                    <TextInput
                        multiple="true"
                        type="file"
                        @input="form.invoice_scans = $event.target.files"
                    />
                </div>
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

<style scoped></style>
