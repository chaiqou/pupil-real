<template>
  <div class="sm:col-span-6">
    <label for="country" class="block text-sm font-medium text-gray-700"
      >Country</label
    >
    <div class="mt-1">
      <Field v-model="this.countrySelect" rules="required" name="country">
        <select
          v-model="this.countrySelect"
          id="country"
          name="country"
          autocomplete="country-name"
          class="block w-full rounded-md border-gray-300 px-4 py-1.5 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        >
        <CountryOptions></CountryOptions>
        </select>
      </Field>

      <ErrorMessage name="country" class="text-sm text-red-500">
        <p class="text-sm text-red-500">country field is required</p>
      </ErrorMessage>
    </div>
  </div>
</template>

<script>
import { Field, ErrorMessage } from "vee-validate";
import { mapWritableState } from "pinia";
import { useGlobalStore } from "@/stores/useGlobalStore";
import CountryOptions from "@/components/Ui/CountryOptions.vue";

export default {
  components: {
      CountryOptions,
    ErrorMessage,
    Field,
  },
  computed: {
    ...mapWritableState(useGlobalStore, ["countrySelect"]),
  },
};
</script>
