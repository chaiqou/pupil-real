<template>
  <!-- Checked: "bg-indigo-50 border-indigo-200 z-10", Not Checked: "border-gray-200" -->
  <label
    class="relative flex cursor-pointer flex-col rounded-tl-md rounded-tr-md border p-4 focus:outline-none md:grid md:grid-cols-3 md:pl-4 md:pr-6"
  >
    <span class="flex items-center text-sm">
      <input
        type="radio"
        name="pricing-plan"
        value="Startup"
        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
        aria-labelledby="pricing-plans-0-label"
        aria-describedby="pricing-plans-0-description-0 pricing-plans-0-description-1"
      />
      <!-- Checked: "text-indigo-900", Not Checked: "text-gray-900" -->
      <span id="pricing-plans-0-label" class="ml-3 font-medium"
        >Fried Chicken</span
      >
    </span>
  </label>
</template>

<script setup></script>
