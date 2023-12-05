<script setup>
import FormGroup from '@/Components/FormGroup.vue'
import FormSection from '@/Components/FormSection.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import { useForm } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const props = defineProps({
    company: Object,
})

const form = useForm({
    name: props.company.name,
    address: props.company.address,
    postcode: props.company.postcode,
    city: props.company.city,
    country: props.company.country,
    vat_number: props.company.vat_number,
    coc_number: props.company.coc_number,
    email: props.company.email,
    type: props.company.type,
    iban: props.company.iban,
    iban_name: props.company.iban_name,
    vat_liable: props.company.vat_liable,
})
</script>

<template>
    <div class="flex justify-between pl-2 pb-8">
        <h1 class="text-3xl font-medium">Bedrijfsgegevens</h1>
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <FormSection @submitted="form.put(route('company.update', props.company.id))">
            <template #form>
                <FormGroup>
                    <InputLabel>Rechtsvorm</InputLabel>
                    <select
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.type"
                    >
                        <option>-- maak een keuze --</option>
                        <option value="emz">Eenmanszaak</option>
                        <option value="vof">Venootschap onder Firma</option>
                        <option value="bv">Besloten venootschap</option>
                        <option value="mts">Maatschap</option>
                        <option value="cv">Commanditaire vennootschap</option>
                    </select>
                </FormGroup>
                <FormGroup>
                    <InputLabel>Bedrijfsnaam</InputLabel>
                    <TextInput v-model="form.name" />
                </FormGroup>
                <FormGroup>
                    <InputLabel>Adres</InputLabel>
                    <TextInput v-model="form.address" />
                </FormGroup>
                <div class="flex gap-4">
                    <FormGroup>
                        <InputLabel>Postcode</InputLabel>
                        <TextInput v-model="form.postcode" />
                    </FormGroup>
                    <FormGroup>
                        <InputLabel>Plaats</InputLabel>
                        <TextInput v-model="form.city" />
                    </FormGroup>
                </div>
                <!--                <FormGroup>-->
                <!--                    <InputLabel>Land</InputLabel>-->
                <!--                    <select-->
                <!--                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"-->
                <!--                        v-model="form.country"-->
                <!--                    >-->
                <!--                        <option value="NL">Nederland</option>-->
                <!--                        <option value="BE">Belgie</option>-->
                <!--                    </select>-->
                <!--                </FormGroup>-->
                <FormGroup>
                    <InputLabel>BTW Nummer</InputLabel>
                    <TextInput v-model="form.vat_number" />
                </FormGroup>
                <FormGroup>
                    <InputLabel>KvK Nummer</InputLabel>
                    <TextInput v-model="form.coc_number" />
                </FormGroup>
                <FormGroup>
                    <InputLabel>E-mailadres</InputLabel>
                    <TextInput v-model="form.email" />
                </FormGroup>
                <div class="flex gap-4">
                    <FormGroup>
                        <InputLabel>IBAN</InputLabel>
                        <TextInput v-model="form.iban" />
                    </FormGroup>
                    <FormGroup>
                        <InputLabel>IBAN Ten name van</InputLabel>
                        <TextInput v-model="form.iban_name" />
                    </FormGroup>
                </div>
                <FormGroup>
                    <InputLabel>BTW Plichtig?</InputLabel>
                    <select
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.vat_liable"
                    >
                        <option value="1">BTW Plichtig</option>
                        <option value="0">Niet BTW Plichtig (KOR)</option>
                    </select>
                </FormGroup>
            </template>
            <template #actions>
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Bijwerken
                </PrimaryButton>
            </template>
        </FormSection>
    </div>
</template>
