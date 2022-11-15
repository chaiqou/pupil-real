<template>
    <div
        class="flex max-h-screen flex-col justify-center overflow-hidden bg-inherit"
    >
        <div class="rounded-md bg-inherit p-8">
            <div class="mt-6 flow-root">
                <ul role="list" class="-my-5 divide-y divide-gray-200">
                    <Extras :name="props.extras" />
                    <Holds :name="props.holds" />
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import Extras from "./Extras.vue";
import Holds from "./Holds.vue";

const props = defineProps({
    extras: {
        type: String,
        required: true,
    },
    holds: {
        type: String,
        required: true,
    },
});
</script>
