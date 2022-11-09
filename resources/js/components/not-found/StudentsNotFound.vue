<template>
    <div class="flex justify-center flex-col items-center w-full py-10">
        <UsersIcon class="w-10 h-10"></UsersIcon>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No students available for this school.</h3>
    </div>
</template>


<script>
import { UsersIcon } from "@heroicons/vue/24/outline";
export default {
    components: {
       UsersIcon
    }
}
</script>
