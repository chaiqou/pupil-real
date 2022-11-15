<template>
    <div class="sm:mt-20 min-w-[30vw]">
        <form @submit.prevent="onSubmit">
            <p class="mb-2 text-center text-xl font-black">
                Create new lunch plan
            </p>
            <BaseInput v-model="store.title" name="title" label="Title" />
            <BaseInput
                v-model="store.description"
                name="description"
                label="Description"
            />
            <RangeDatepicker
                v-model="store.active_range"
                name="active_range"
                label="Active range"
            />
            <BaseInput
                v-model="store.period_length"
                name="period_length"
                label="Period Length"
            />
            <LunchMultiselect name="claimables" label="Claimables" />
            <RangeDatepicker v-model="store.holds" name="holds" label="Holds" />
            <RangeDatepicker
                v-model="store.extras"
                name="extras"
                label="Extras"
            />
            <WeekdaysChechkbox name="tags" />
            <BaseInput
                v-model="store.price_day"
                name="price_day"
                label="Price per day"
            />
            <BaseInput
                v-model="store.price_period"
                name="price_period"
                label="Price per period"
            />
            <ExtrasAndHolds holds="holds" extras="extras" />
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
import ExtrasAndHolds from "./ExtrasAndHolds.vue";
import Button from "../ui/Button.vue";
import { useForm } from "vee-validate";
import { useLunchFormStore } from "../../stores/useLunchFormStore";

const { handleSubmit } = useForm();
const store = useLunchFormStore();

const onSubmit = handleSubmit((values) => {
    axios
        .post("lunch", store.getLunchFormData)
        .then((response) => {
            console.log(response);
        })
        .catch((error) => {
            console.log(error);
        });
    console.log(store.getLunchFormData);
});
</script>
