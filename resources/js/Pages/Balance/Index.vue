<script setup>
import { router, useForm } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'

const props = defineProps({
    nonCurrentAssets: Object,
    currentAssets: Object,
    expenses: Object,
    equity: Object,
    currentLiabilities: Object,
    revenue: Number,
    total_assets: Number,
    total_liabilities: Number,

    end_date: null,
})

const form = useForm({
    end_date: props.end_date ?? new Date(new Date().getFullYear(), 11, 31),
})
</script>

<template>
    <div class="flex justify-between pl-2 pb-8">
        <h1 class="text-3xl font-medium">Balans</h1>
        <div>
            <TextInput
                type="date"
                v-model="form.end_date"
                @change="form.submit('get', route('balance-sheet'))"
            />
        </div>
        <PrimaryButton @click.prevent="router.get(route('journal.create'))">
            + Memoriaal boeking
        </PrimaryButton>
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
        <div class="grid grid-cols-2 gap-10">
            <div class="flex flex-col gap-4 border-r pr-4">
                <h2 class="font-bold">Vaste activa</h2>
                <div v-for="account in nonCurrentAssets.data">
                    <div v-if="account.total !== 0" class="flex justify-between">
                        <div>{{ account.name }}</div>
                        <div>{{ account.total.toFixed(2) }}</div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <h2 class="font-bold">Eigen vermogen</h2>
                <div v-for="account in equity.data">
                    <div v-if="account.total !== 0" class="flex justify-between">
                        <div>{{ account.name }}</div>
                        <div>{{ account.total.toFixed(2) }}</div>
                    </div>
                </div>
                <div class="flex justify-between">
                    <div>Resultaat</div>
                    <div>{{ revenue }}</div>
                </div>
            </div>

            <div class="flex flex-col gap-4 border-r pr-4">
                <h2 class="font-bold">Vlottende activa</h2>
                <div v-for="account in currentAssets.data">
                    <div v-if="account.total !== 0" class="flex justify-between">
                        <div>{{ account.name }}</div>
                        <div>{{ account.total.toFixed(2) }}</div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <h2 class="font-bold">Kort vreemd vermogen</h2>
                <div v-for="account in currentLiabilities.data">
                    <div v-if="account.total !== 0" class="flex justify-between">
                        <div>{{ account.name }}</div>
                        <div>{{ account.total.toFixed(2) }}</div>
                    </div>
                </div>
            </div>
            <div class="flex justify-between border-r pr-4">
                <div>Debet</div>
                <div>{{ total_assets.toFixed(2) }}</div>
            </div>
            <div class="flex justify-between">
                <div>Credit</div>
                <div>{{ total_liabilities.toFixed(2) }}</div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
