<script setup>
import FormSection from '@/Components/FormSection.vue'
import TextInput from '@/Components/TextInput.vue'
import InputLabel from '@/Components/InputLabel.vue'
import { useForm } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import FormGroup from '@/Components/FormGroup.vue'

const form = useForm({
    type: 'company',
    company_name: '',
    firstname: '',
    lastname: '',
    coc: '',
    phone: '',
    email: '',
    invoice_email: '',
    invoice_att: '',
    address: '',
    postcode: '',
    city: '',
    country: '',
})

const notificationMethods = [
    { id: 'company', title: 'Bedrijf' },
    { id: 'private_user', title: 'Particulier' },
]
const createContact = () => form.post(route('contact.store'))
</script>

<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <FormSection @submitted="createContact">
            <template #title>Contact toevoegen</template>
            <template #form>
                <FormGroup>
                    <InputLabel>Type</InputLabel>
                    <fieldset>
                        <legend class="sr-only">Notification method</legend>
                        <div class="flex gap-4">
                            <div
                                v-for="notificationMethod in notificationMethods"
                                :key="notificationMethod.id"
                                class="flex items-center"
                            >
                                <input
                                    :id="notificationMethod.id"
                                    name="notification-method"
                                    type="radio"
                                    v-model="form.type"
                                    :value="notificationMethod.id"
                                    :checked="notificationMethod.id === form.type"
                                    class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                />
                                <label
                                    :for="notificationMethod.id"
                                    class="ml-2 block text-sm font-medium leading-6 text-gray-900"
                                    >{{ notificationMethod.title }}
                                </label>
                            </div>
                        </div>
                    </fieldset>
                </FormGroup>
                <FormGroup v-if="form.type === 'company'">
                    <InputLabel>Bedrijfsnaam</InputLabel>
                    <TextInput v-model="form.company_name" />
                </FormGroup>
                <FormGroup v-if="form.type === 'company'">
                    <InputLabel>KVK Nummer</InputLabel>
                    <TextInput v-model="form.coc" />
                </FormGroup>
                <FormGroup>
                    <InputLabel>Voornaam</InputLabel>
                    <TextInput v-model="form.firstname" />
                </FormGroup>
                <FormGroup>
                    <InputLabel>Achternaam</InputLabel>
                    <TextInput v-model="form.lastname" />
                </FormGroup>
                <FormGroup>
                    <InputLabel>Adres</InputLabel>
                    <TextInput v-model="form.address" />
                </FormGroup>
                <FormGroup>
                    <InputLabel>Postcode</InputLabel>
                    <TextInput v-model="form.postcode" />
                </FormGroup>
                <FormGroup>
                    <InputLabel>Plaats</InputLabel>
                    <TextInput v-model="form.city" />
                </FormGroup>
                <FormGroup>
                    <InputLabel>Land</InputLabel>
                    <TextInput v-model="form.country" />
                </FormGroup>
                <hr />
                <FormGroup>
                    <InputLabel>Telefoonnummer</InputLabel>
                    <TextInput v-model="form.phone" />
                </FormGroup>
                <FormGroup>
                    <InputLabel>E-mailadres</InputLabel>
                    <TextInput v-model="form.email" />
                </FormGroup>
                <hr />
                <FormGroup>
                    <InputLabel>Factuur t.a.v.</InputLabel>
                    <TextInput v-model="form.invoice_att" />
                </FormGroup>
                <FormGroup>
                    <InputLabel>Factuur e-mailadres</InputLabel>
                    <TextInput v-model="form.invoice_email" />
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

<style scoped></style>
