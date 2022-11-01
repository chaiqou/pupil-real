<template>
    <Form @submit="onSubmitMerchantForm">
        <MerchantLabel label="Title" />
        <Field
            placeholder="Title"
            v-model="store.title"
            name="title"
            type="text"
            class="inline-block w-full placeholder-[#626262] rounded-md border border-[#626262] whitespace-nowrap"
        />
        <MerchantLabel label="Description" />
        <Field
            placeholder="Description"
            v-model="store.description"
            name="description"
            type="text"
            class="inline-block w-full placeholder-[#626262] rounded-md border border-[#626262] whitespace-nowrap"
        />
        <MerchantLabel label="Active Range" />
        <Datepicker v-model="store.dateRange" range />
        <MerchantLabel label="Period Length" />
        <Field
            v-model="store.period"
            name="period"
            type="number"
            class="inline-block w-full placeholder-[#626262] rounded-md border border-[#626262] whitespace-nowrap"
        />
        <MerchantRadioGroup />
        <MerchantLabel label="Holds" />
        <Datepicker v-model="store.holds" range />
        <MerchantLabel label="Extras" />
        <Datepicker v-model="store.extras" range />
        <TagInput />
        <MerchantLabel label="Price/Day" />
        <Field
            v-model="store.priceDay"
            name="priceDay"
            type="number"
            class="inline-block w-full placeholder-[#626262] rounded-md border border-[#626262] whitespace-nowrap"
        />
        <MerchantLabel label="Price/Period" />
        <Field
            v-model="store.pricePeriod"
            name="pricePeriod"
            type="number"
            class="inline-block w-full placeholder-[#626262] rounded-md border border-[#626262] whitespace-nowrap"
        />
    </Form>
</template>

<script setup>
import { Form, Field } from "vee-validate";
import { useMerchantFormStore } from "../../stores/useMerchantFormStore";

import MerchantRadioGroup from "./MerchantRadioGroup.vue";
import MerchantLabel from "./MerchantLabel.vue";
import TagInput from "./TagInput.vue";

const store = useMerchantFormStore();

function onSubmitMerchantForm(values) {
    console.log(date.value);
}
</script>
