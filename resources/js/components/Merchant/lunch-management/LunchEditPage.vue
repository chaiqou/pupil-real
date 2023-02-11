<template>
    <main class="flex">
        <div class="py-6">
            <div class="mx-auto max-w-7xl px-12 sm:px-8 md:px-6">
                <div class="py-4 flex space-x-5 2xl:space-x-10">
                    <Calendar class="hidden sm:flex" :months="11" />
                    <LunchFormEdit />
                </div>
            </div>
        </div>
    </main>
</template>

<script setup>
import LunchFormEdit from "./LunchFormEdit.vue";
import Calendar from "@/components/Merchant/lunch-management/Calendar.vue";
</script>
