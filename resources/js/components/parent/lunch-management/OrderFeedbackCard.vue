<template>
  <div
    :class="mainClassname"
    class="relative mt-4 block w-full rounded-lg border-2 p-12 text-center"
  >
    <slot></slot>
    <span :class="textClassname" class="mt-2 block text-sm font-medium">{{
      props.mainText
    }}</span>
    <span :class="textClassname" class="mt-2 block text-sm font-semibold"
      ><span class="underline">{{ props.subText }}</span> &rarr;</span
    >
  </div>
</template>

<script setup>
const props = defineProps({
  mainText: {
    required: true,
    type: String,
    default: "Waiting for proforma payment...",
  },
  subText: {
    required: false,
    type: String,
    default: "View details at Billingo",
  },
  mainClassname: {
    required: true,
    type: String,
    default: "border-green-300 bg-green-100 hover:border-green-400",
  },
  textClassname: {
    required: true,
    type: String,
    default: "text-green-700",
  },
});
</script>
