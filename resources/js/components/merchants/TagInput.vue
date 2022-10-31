<template>
    <div class="w-96 text-base h-12">
        <div
            v-for="tag in store.tags"
            :key="tag"
            class="flex justify-between px-4 h-8 mr-2 bg-[#eee] mt-2 leading-8"
        >
            {{ tag }}
            <span class="cursor-pointer">x</span>
        </div>
        <Field type="text" placeholder="Enter a tag" name="tagInput" />
    </div>
</template>

<script setup>
import { Field } from "vee-validate";
import { useMerchantFormStore } from "../../stores/useMerchantFormStore";

const store = useMerchantFormStore();
</script>
