<script setup>
import FormGroup from '@/Components/FormGroup.vue'
import FormSection from '@/Components/FormSection.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import { useForm } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const form = useForm({
    name: '',
    address: '',
    postcode: '',
    city: '',
    country: 'NL',
    vat_number: '',
    coc_number: '',
    email: '',
    type: '',
    iban: '',
    iban_name: '',
    vat_liable: 1,
})
</script>

<template>
    <div class="flex justify-between pl-2 pb-8">
        <h1 class="text-3xl font-medium">Bedrijfsgegevens</h1>
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <FormSection @submitted="form.post(route('company.store'))">
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
                        <option value="1">Ja, BTW Plichtig</option>
                        <option value="0">Nee, niet BTW Plichtig (KOR)</option>
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
