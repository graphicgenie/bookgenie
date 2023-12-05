<script setup>
import FormSection from '@/Components/FormSection.vue'
import TextInput from '@/Components/TextInput.vue'
import InputLabel from '@/Components/InputLabel.vue'
import { useForm, router } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import FormGroup from '@/Components/FormGroup.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'

const props = defineProps({
    contact: Object,
})

const form = useForm({
    type: props.contact.type,
    company_name: props.contact.company_name,
    firstname: props.contact.firstname,
    lastname: props.contact.lastname,
    coc: props.contact.coc,
    phone: props.contact.phone,
    email: props.contact.email,
    invoice_email: props.contact.invoice_email,
    invoice_att: props.contact.invoice_att,
    address: props.contact.address,
    postcode: props.contact.postcode,
    city: props.contact.city,
    country: props.contact.country,
})

const notificationMethods = [
    { id: 'company', title: 'Bedrijf' },
    { id: 'private_user', title: 'Particulier' },
]
const updateContact = () => form.put(route('contact.update', props.contact.id))
</script>

<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <FormSection @submitted="updateContact">
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
                <SecondaryButton @click="router.get(route('contact.index'))"
                    >Annuleren
                </SecondaryButton>
                <PrimaryButton
                    class="ml-4"
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
