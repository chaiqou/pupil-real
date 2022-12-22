<template>
    <div class="flex justify-center flex-col items-center w-full py-10">
        <CommandLineIcon class="w-10 h-10"></CommandLineIcon>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No Terminals.</h3>
        <p class="mt-1 text-sm text-gray-500">No available terminals at the moment.</p>
    </div>
</template>


<script>
import { CommandLineIcon } from "@heroicons/vue/24/outline";
export default {
    components: {
        CommandLineIcon,
    },
}
</script>
