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
import { computed, ref, watch } from 'vue'
import throttle from 'lodash/throttle.js'

defineProps({
    label: {
        type: String,
        default: 'Klant',
    },
})

const emit = defineEmits(['submitted'])

let contacts = ref([])
const query = ref('')
const selectedPerson = ref(null)
const filteredPeople = computed(() =>
    query.value === ''
        ? contacts.value
        : contacts.value.filter((person) => {
              // console.log(person)
              console.log(Object.values(person).indexOf('GraphicGenie') > -1)
              return (
                  person.company_name?.toLowerCase().includes(query.value.toLowerCase()) ||
                  person.firstname.toLowerCase().includes(query.value.toLowerCase()) ||
                  person.email.toLowerCase().includes(query.value.toLowerCase())
              )
          })
)

watch(
    query,
    throttle(function () {
        axios(route('contact.search'), { params: { query: query.value } }).then((response) => {
            contacts = ref(response.data)
        })
    }, 10)
)

watch(selectedPerson, () => emit('submitted', selectedPerson.value.id))

const displayName = (person) => {
    if (person) {
        if (person.company_name) return person.company_name
        else return person.firstname + ' ' + person.lastname
    }
    return ''
}
</script>

<template>
    <Combobox as="div" v-model="selectedPerson" class="w-1/3">
        <InputLabel>{{ label }}</InputLabel>
        <div class="relative mt-2">
            <ComboboxInput
                class="w-full rounded-md border-0 bg-white text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:leading-6"
                @change="query = $event.target.value"
                :display-value="(person) => displayName(person)"
            />
            <ComboboxButton
                class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none"
            >
                <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
            </ComboboxButton>

            <ComboboxOptions
                v-if="filteredPeople.length > 0"
                class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
            >
                <ComboboxOption
                    v-for="person in filteredPeople"
                    :key="person.id"
                    :value="person"
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
                            {{ person.company_name ?? person.firstname + ' ' + person.lastname }}
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