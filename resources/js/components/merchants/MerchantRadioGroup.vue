<template>
    <div>
        <RadioGroup v-model="store.radioDay" class="mt-2">
            <RadioGroupLabel class="sr-only">
                Choose a day option
            </RadioGroupLabel>
            <div class="grid grid-cols-3 gap-2 sm:grid-cols-6">
                <RadioGroupOption
                    as="template"
                    v-for="option in dayOptions"
                    :key="option.name"
                    :value="option.fullName"
                    :disabled="!option.validOption"
                    v-slot="{ active, checked }"
                    v-model="store.radioDay"
                >
                    <div
                        :class="[
                            option.validOption
                                ? 'cursor-pointer focus:outline-none'
                                : 'opacity-25 cursor-not-allowed',
                            active ? 'ring-2 ring-offset-2 ring-red-500' : '',
                            checked
                                ? 'bg-red-600 border-transparent text-white hover:bg-red-700'
                                : 'bg-white border-gray-200 text-gray-900 hover:bg-gray-50',
                            'border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1',
                        ]"
                    >
                        <RadioGroupLabel as="span">{{
                            option.name
                        }}</RadioGroupLabel>
                    </div>
                </RadioGroupOption>
            </div>
        </RadioGroup>
    </div>
</template>

<script setup>
import { RadioGroup, RadioGroupLabel, RadioGroupOption } from "@headlessui/vue";
import { useMerchantFormStore } from "../../stores/useMerchantFormStore";

const dayOptions = [
    { name: "M", fullName: "monday", validOption: true },
    { name: "T", fullName: "tuesday", validOption: true },
    { name: "W", fullName: "wednesday", validOption: true },
    { name: "T", fullName: "thursday", validOption: true },
    { name: "F", fullName: "friday", validOption: true },
    { name: "S", fullName: "saturday", validOption: true },
    { name: "S", fullName: "sunday", validOption: true },
];

const store = useMerchantFormStore();
</script>
