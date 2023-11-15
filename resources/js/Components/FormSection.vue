<script setup>
import { computed, useSlots } from 'vue'
import SectionTitle from './SectionTitle.vue'

defineEmits(['submitted'])

const hasActions = computed(() => !!useSlots().actions)
</script>

<template>
    <div class="pt-4">
        <!--        <h1 class="text-3xl font-medium px-4 py-6 sm:px-6">-->
        <!--            <slot name="title" />-->
        <!--        </h1>-->
        <form @submit.prevent="$emit('submitted')">
            <div>
                <div class="px-4 py-3 sm:px-6">
                    <slot name="form" />
                </div>
            </div>

            <div
                v-if="hasActions"
                class="flex items-center justify-end px-4 py-3 sm:px-6 bg-gray-50 text-right shadow sm:rounded-bl-md sm:rounded-br-md"
            >
                <slot name="actions" />
            </div>
        </form>
    </div>
</template>
