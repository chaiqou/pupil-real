<template>
    <label class="text-md flex font-bold text-gray-600 whitespace-normal"
        >Vat %
    </label>
    <Multiselect
        v-model="store.vat"
        name="vat"
        :limit="10"
        :max="10"
        ref="multiselectRef"
        required
        autocomplete
        searchable
        :createOption="true"
        :close-on-select="false"
        :searchable="true"
        :options="vatOptions"
        v-bind="$attrs"
    />
</template>

<script setup>
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import Multiselect from "@vueform/multiselect";

const store = useLunchFormStore();

const vatOptions = [
    '"0%"',
    '"1%"',
    '"10%"',
    '"11%"',
    '"12%"',
    '"13%"',
    '"14%"',
    '"15%"',
    '"16%"',
    '"17%"',
    '"18%"',
    '"19%"',
    '"2%"',
    '"20%"',
    '"21%"',
    '"22%"',
    '"23%"',
    '"24%"',
    '"25%"',
    '"26%"',
    '"27%"',
    '"3%"',
    '"4%"',
    '"5%"',
    '"5,5%"',
    '"6%"',
    '"7%"',
    '"7,7%"',
    '"8%"',
    '"9%"',
    '"9,5%"',
    '"AAM"',
    '"AM"',
    '"EU"',
    '"EUK"',
    '"F.AFA"',
    '"FAD"',
    '"K.AFA"',
    '"MAA"',
    '"TAM"',
    '"ÁKK"',
    '"ÁTHK"',
];
</script>
