<template>
    <div class="sm:mt-20 min-w-[30vw]">
        <form @submit.prevent="onSubmit">
            <p class="mb-2 text-center text-xl font-black">
                Create new lunch plan
            </p>
            <BaseInput name="title" label="Title" />
            <BaseInput name="description" label="Description" />
            <RangeDatepicker name="active_range" label="Active range" />
            <BaseInput name="period_length" label="Period Length" />
            <LunchMultiselect name="claimables" label="Claimables" />
            <RangeDatepicker name="holds" label="Holds" />
            <RangeDatepicker name="extras" label="Extras" />
            <WeekdaysChechkbox name="tags" />
            <BaseInput name="price_day" label="Price per day" />
            <BaseInput name="price_period" label="Price per period" />
            <Button text="Save Lunch" />
        </form>
    </div>
</template>

<script setup>
import axios from "../../config/axios/index";
import BaseInput from "../form-components/BaseInput";
import RangeDatepicker from "../form-components/RangeDatepicker.vue";
import LunchMultiselect from "./LunchMultiselect.vue";
import WeekdaysChechkbox from "./WeekdaysCechkbox.vue";
import Button from "../ui/Button.vue";
import { useForm } from "vee-validate";
const { handleSubmit } = useForm();

const onSubmit = handleSubmit((values) => {
    axios
        .post("lunch", {
            title: values.title,
            description: values.description,
            active_range: values.active_range,
            period_length: values.period_length,
            claimables: values.claimables,
            holds: values.holds,
            extras: values.extras,
            tags: values.tags,
            price_day: values.price_day,
            price_period: values.price_period,
        })
        .then((response) => {
            console.log(response);
        })
        .catch((error) => {
            console.log(error);
        });
});
</script>
