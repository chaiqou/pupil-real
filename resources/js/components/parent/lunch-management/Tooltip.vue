<template>
    <div
        class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500"
        @mouseenter="showTooltip"
        @mouseleave="hideTooltip"
        ref="referenceRef"
    >
        <slot></slot>
        <div
            ref="floatingRef"
            :class="[
                'absolute top-0 left-0 z-50 bg-gray-700 text-sm text-white px-3 py-1.5 rounded-md cursor-default',
                !isHidden && 'hidden',
            ]"
        >
            {{ props.content }}
            <div
                class="absolute bg-gray-700 h-[8px] w-[8px] rotate-45"
                ref="arrowRef"
            ></div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { computePosition, flip, shift, offset, arrow } from "@floating-ui/dom";

const props = defineProps({
    content: {
        type: String,
        required: true,
    },
    placement: {
        type: String,
        required: true,
    },
    floatingName: {
        type: String,
        required: true,
    },
});

const referenceRef = ref();
const floatingRef = ref();
const arrowRef = ref();
const isHidden = ref(false);

const calculatePosition = async () => {
    const { x, y, middlewareData, placement } = await computePosition(
        referenceRef.value,
        floatingRef.value,
        {
            placement: "top",
            middleware: [
                offset(8),
                flip(),
                shift(),
                arrow({ element: arrowRef.value }),
            ],
        }
    );

    if (props.floatingName == "first") {
        Object.assign(floatingRef.value.style, {
            left: `${x + 5}px`,
            top: `${x}px`,
        });
    } else if (props.floatingName == "second") {
        Object.assign(floatingRef.value.style, {
            left: `${x + 5}px`,
            top: `${x + 85}px`,
        });
    }

    const { x: arrowX, y: arrowY } = middlewareData.arrow;

    const opposedSide = {
        left: "right",
        right: "left",
        top: "bottom",
        bottom: "top",
    }[placement];

    Object.assign(arrowRef.value.style, {
        left: arrowX ? `${arrowX}px` : "",
        top: arrowY ? `${arrowY + 30}px` : "",
        bottom: "",
        right: "",
        [opposedSide]: "-4px",
    });
};

const showTooltip = () => {
    isHidden.value = true;
    calculatePosition();
};
const hideTooltip = () => {
    isHidden.value = false;
};
</script>
