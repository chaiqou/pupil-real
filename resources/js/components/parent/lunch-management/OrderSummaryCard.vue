<template>
    <div
        class="relative block w-full mt-4 rounded-lg border-2 border-green-300 bg-green-100 p-12 text-center hover:border-green-400"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="mx-auto h-12 w-12 text-green-400"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"
            />
        </svg>
        <span class="mt-2 block text-sm font-medium text-green-700"
            >Waiting for proforma payment...</span
        >
        <span class="mt-2 block text-sm font-semibold text-green-700"
            ><span class="underline">View details at Billingo</span>
            &rarr;</span
        >
    </div>
</template>

<script setup></script>
