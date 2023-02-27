<template>
  <div
    class="fixed z-50 flex min-h-screen w-screen flex-col items-center justify-center bg-black/50"
  >
    <div
      class="absolute w-full max-w-lg rounded-lg bg-white px-6 py-10 shadow-2xl md:right-1/3 xl:right-[45%]"
    >
      <template class="flex flex-wrap justify-between border-b border-gray-200">
        <h1 class="mb-2 font-semibold text-gray-700">Lunch name</h1>
      </template>
      <fieldset>
        <legend class="sr-only">Pricing plans</legend>
        <div class="relative -space-y-px rounded-md bg-white">
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

          <!-- Checked: "bg-indigo-50 border-indigo-200 z-10", Not Checked: "border-gray-200" -->
          <label
            class="relative flex cursor-pointer flex-col border p-4 focus:outline-none md:grid md:grid-cols-3 md:pl-4 md:pr-6"
          >
            <span class="flex items-center text-sm">
              <input
                type="radio"
                name="pricing-plan"
                value="Business"
                class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                aria-labelledby="pricing-plans-1-label"
                aria-describedby="pricing-plans-1-description-0 pricing-plans-1-description-1"
              />
              <!-- Checked: "text-indigo-900", Not Checked: "text-gray-900" -->
              <span id="pricing-plans-1-label" class="ml-3 font-medium"
                >Soup</span
              >
            </span>
          </label>

          <!-- Checked: "bg-indigo-50 border-indigo-200 z-10", Not Checked: "border-gray-200" -->
          <label
            class="relative flex cursor-pointer flex-col rounded-bl-md rounded-br-md border p-4 focus:outline-none md:grid md:grid-cols-3 md:pl-4 md:pr-6"
          >
            <span class="flex items-center text-sm">
              <input
                type="radio"
                name="pricing-plan"
                value="Enterprise"
                class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                aria-labelledby="pricing-plans-2-label"
                aria-describedby="pricing-plans-2-description-0 pricing-plans-2-description-1"
              />
              <!-- Checked: "text-indigo-900", Not Checked: "text-gray-900" -->
              <span id="pricing-plans-2-label" class="ml-3 font-medium"
                >Pasta</span
              >
            </span>
          </label>
        </div>
      </fieldset>
    </div>
  </div>
</template>

<script setup></script>
