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
            name="tagInput"
            @keydown="addTag"
            @keydown.delete="removeTagWithBackspace"
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

function removeTagWithBackspace(event) {
    if (event.target.value.length === 0) {
        store.removeTag(store.tags.length - 1);
    }
}
</script>
