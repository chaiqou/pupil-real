<template>
    <div class="w-96 text-base h-12">
        <div
            v-for="(tag, index) in store.tags"
            :key="tag"
            class="flex justify-between px-4 h-8 mr-2 bg-[#eee] mt-2 leading-8"
        >
            {{ tag }}
            <span @click="removeTag(index)" class="cursor-pointer">x</span>
        </div>
        <Field
            type="text"
            placeholder="Enter a tag"
            name="tagInput"
            @keydown="addTag"
        />
    </div>
</template>

<script setup>
import { Field } from "vee-validate";
import { useMerchantFormStore } from "../../stores/useMerchantFormStore";

const store = useMerchantFormStore();

function addTag(event) {
    if (event.code === "Enter") {
        let value = event.target.value.trim();
        if (value.length > 0) {
            store.addTag(value);
            event.target.value = "";
        }
    }
}

function removeTag(index) {
    store.removeTag(index);
}
</script>
