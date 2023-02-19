<template>
  <label class="text-md flex whitespace-normal font-bold text-gray-600"
    >Vat %
  </label>
  <Multiselect
    v-model="store.vat"
    v-bind="$attrs"
    name="vat"
    mode="single"
    :limit="50"
    required
    searchable
    :close-on-select="false"
    :options="vatOptions"
  />
</template>

<script setup>
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import Multiselect from "@vueform/multiselect";

const store = useLunchFormStore();

const vatOptions = [
  "17%",
  "0%",
  "1%",
  "10%",
  "11%",
  "12%",
  "13%",
  "14%",
  "15%",
  "16%",
  "18%",
  "19%",
  "2%",
  "20%",
  "21%",
  "22%",
  "23%",
  "24%",
  "25%",
  "26%",
  "27%",
  "3%",
  "4%",
  "5%",
  "5,5%",
  "6%",
  "7%",
  "7,7%",
  "8%",
  "9%",
  "9,5%",
  "AAM",
  "AM",
  "EU",
  "EUK",
  "F.AFA",
  "FAD",
  "K.AFA",
  "MAA",
  "TAM",
  "ÁKK",
  "ÁTHK",
];
</script>
