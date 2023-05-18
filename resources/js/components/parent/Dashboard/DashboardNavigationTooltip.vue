<template>
  <div class="mx-auto max-w-lg">
    <h2 class="text-base font-semibold leading-6 text-gray-900">
     {{$t('message.welcome_to_pupilpay')}}
    </h2>
    <p class="mt-1 text-sm text-gray-500">{{$t('message.whats_next')}}?</p>
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
                {{ $t("message."+item.name) }}
              </a>
            </div>
            <p class="text-sm text-gray-500">{{ $t("message."+item.description) }}</p>
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
          <p>{{$t('message.or_add_a_new_student')}}</p>
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
    name: "order_lunch",
    description: "order_your_first_lunch_pupilpay",
    href: `/parent/available-lunches/${props.studentId}`,
    iconColor: "bg-pink-500",
    icon: CakeIcon,
  },
  {
    name: "choose_a_menu",
    description:
      "after_ordering_lunch_dont_forget_to_check_whats_for_lunch_head_over_to_menus",
    href: `/parent/menus/${props.studentId}`,
    iconColor: "bg-purple-500",
    icon: ClipboardDocumentListIcon,
  },
  {
    name: "check_your_transactions",
    description: "see_all_your_past_transactions_in_the_transactions_tab",
    href: `/parent/transactions/${props.studentId}`,
    iconColor: "bg-yellow-500",
    icon: ListBulletIcon,
  },
];
</script>
