<template>
            <div>
                <button v-if="globalStoreSolution" :disabled="axiosStatus === 'ongoing'" :class="axiosStatus === 'ongoing' ? classOngoing : classDefault">
             <span class="flex items-center">
                   <slot></slot>
            <SpinnerAnimation v-if="axiosStatus === 'ongoing'" class="h-5 w-5 ml-2"></SpinnerAnimation>
            <CheckIcon v-if="axiosStatus === 'updated'" class="h-5 w-5 text-green-500 ml-2"></CheckIcon>
            <XMarkIcon v-if="axiosStatus === 'error'" class="h-5 w-5 text-red-500 ml-2"></XMarkIcon>
          </span>
                </button>

                <button v-if="!globalStoreSolution" :disabled="status === 'ongoing'" :class="status === 'ongoing' ? classOngoing : classDefault">
             <span class="flex items-center">
                   <slot></slot>
                <SpinnerAnimation v-if="status === 'ongoing'" class="h-5 w-5 ml-2"></SpinnerAnimation>
            <CheckIcon v-if="status === 'updated'" class="h-5 w-5 text-green-500 ml-2"></CheckIcon>
            <XMarkIcon v-if="status === 'error'" class="h-5 w-5 text-red-500 ml-2"></XMarkIcon>
          </span>
                </button>
            </div>
</template>
<script>
import SpinnerAnimation from "@/components/Ui/SpinnerAnimation.vue";
import { CheckIcon, XMarkIcon } from "@heroicons/vue/24/outline";
import {useGlobalStore} from "@/stores/useGlobalStore";
import {mapWritableState} from "pinia";
export default {
    components: {
        SpinnerAnimation,
        CheckIcon,
        XMarkIcon
    },
    props: {
        classOngoing: {
            type: String,
            required: false,
            default: "inline-flex opacity-40 mt-7 justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm min-w-full"
        },
        classDefault: {
            type: String,
            required: false,
            default: "inline-flex mt-7 justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm min-w-full"
        },
        status: {
            type: String,
            required: false,
            default: ""
        },
        globalStoreSolution: {
            type: Boolean,
            required: false,
            default: true
        }
    },
    computed: {
        ...mapWritableState(useGlobalStore, ["axiosStatus"])
    }
}
</script>
