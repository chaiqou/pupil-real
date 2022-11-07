<template>
    <div class="mt-[4.2rem] w-96">
        <BaseInput name="title" label="Title" />
        <BaseInput name="description" label="Description" />
        <RangeDatepicker name="active_range" label="Active range" />
        <BaseInput name="period_length" label="Period Length" />
        <LunchMultiselect name="claimables" label="Claimables" />
        <RangeDatepicker name="holds" label="Holds" />
        <RangeDatepicker name="extras" label="Extras" />
        <BaseInput name="price_day" label="Price per day" />
        <BaseInput name="price_period" label="Price per period" />
    </div>
</template>

<script setup>
import axios from "../../config/axios/index";
import BaseInput from "../form-components/BaseInput";
import RangeDatepicker from "../form-components/RangeDatepicker.vue";
import LunchMultiselect from "./LunchMultiselect.vue";

function onSubmitMerchantForm(value) {
    axios
        .post("lunch", "testdata")
        .then((response) => {
            console.log(response);
        })
        .catch((error) => {
            console.log(error);
        });
}
</script>
