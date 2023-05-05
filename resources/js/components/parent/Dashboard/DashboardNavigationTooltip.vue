<template>
  <div class="mx-auto max-w-lg">
    <h2 class="text-base font-semibold leading-6 text-gray-900">
      Welcome to PupilPay
    </h2>
    <p class="mt-1 text-sm text-gray-500">What’s next?</p>
    <ul
      role="list"
      class="mt-6 divide-y divide-gray-200 border-b border-t border-gray-200"
    >
      <li v-for="(item, itemIdx) in items" :key="itemIdx">
        <div class="group relative flex items-start space-x-3 py-4">
          <div class="flex-shrink-0">
            <span
              :class="[
                item.iconColor,
                'inline-flex h-10 w-10 items-center justify-center rounded-lg',
              ]"
            >
              <component
                :is="item.icon"
                class="h-6 w-6 text-white"
                aria-hidden="true"
              />
            </span>
          </div>
          <div class="min-w-0 flex-1">
            <div class="text-sm font-medium text-gray-900">
              <a :href="item.href">
                <span class="absolute inset-0" aria-hidden="true" />
                {{ item.name }}
              </a>
            </div>
            <p class="text-sm text-gray-500">{{ item.description }}</p>
          </div>
          <div class="flex-shrink-0 self-center">
            <ChevronRightIcon
              class="h-5 w-5 text-gray-400 group-hover:text-gray-500"
              aria-hidden="true"
            />
          </div>
        </div>
      </li>
    </ul>
    <div class="mt-6 flex">
      <a
        :href="'/parent/create-student/' + props.studentId"
        class="text-sm font-medium text-indigo-600 hover:text-indigo-500"
      >
        <div class="flex w-64">
          <p>Or add a new Student</p>
          <ArrowLongRightIcon class="ml-1 w-5"></ArrowLongRightIcon>
        </div>
      </a>
    </div>
  </div>
</template>

<script setup>
import { ChevronRightIcon } from "@heroicons/vue/20/solid";
import {
  ListBulletIcon,
  ClipboardDocumentListIcon,
  CakeIcon,
  ArrowLongRightIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
  studentId: {
    type: Number,
    required: true,
  },
});

const items = [
  {
    name: "Order lunch",
    description: "Order your first lunch PupilPay.",
    href: `/parent/available-lunches/${props.studentId}`,
    iconColor: "bg-pink-500",
    icon: CakeIcon,
  },
  {
    name: "Choose a menu",
    description:
      "After ordering lunch, don’t forget to check what’s for lunch! Head over to menus.",
    href: `/parent/menus/${props.studentId}`,
    iconColor: "bg-purple-500",
    icon: ClipboardDocumentListIcon,
  },
  {
    name: "Check your transactions",
    description: "See all your past transactions in the Transactions tab.",
    href: `/parent/transactions/${props.studentId}`,
    iconColor: "bg-yellow-500",
    icon: ListBulletIcon,
  },
];
</script>
