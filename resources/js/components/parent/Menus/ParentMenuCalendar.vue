<template>
  <template v-if="toggleFixedCard">
    <ParentFixedMenuCard :menu="fixedMenu" />
  </template>

  <div class="w-full">
    <div
      class="mx-auto grid max-w-3xl grid-cols-1 gap-x-8 gap-y-16 px-4 py-16 sm:grid-cols-1 sm:px-6 xl:max-w-none xl:grid-cols-2 xl:px-8 2xl:grid-cols-3"
    >
      <section
        v-for="month in monthsDays"
        :key="month.name"
        class="text-center"
      >
        <h2 class="font-semibold text-gray-900">
          {{ month.name }} {{ month.year }}
        </h2>
        <div class="mt-6 grid grid-cols-7 text-xs leading-6 text-gray-500">
          <div>M</div>
          <div>T</div>
          <div>W</div>
          <div>T</div>
          <div>F</div>
          <div>S</div>
          <div>S</div>
        </div>
        <div
          class="isolate mt-2 grid grid-cols-7 gap-px rounded-lg bg-gray-200 text-sm shadow ring-1 ring-gray-200"
        >
          <button
            v-for="(day, dayIdx) in month.days"
            @click="onClickCalendar(day)"
            :key="dayIdx"
            :class="[
              month.name !== getMonthByIndex(day.getMonth())
                ? 'bg-white text-gray-900'
                : 'bg-gray-50 text-gray-400',
              dayIdx === 0 && 'rounded-tl-lg',
              dayIdx === 6 && 'rounded-tr-lg',
              dayIdx === month.days.length - 7 && 'rounded-bl-lg',
              dayIdx === month.days.length - 1 && 'rounded-br-lg',
              determineIfMenuExists(day, 'fixed')
                ? 'bg-purple-700 text-white hover:bg-purple-600'
                : '',
              'py-1.5 hover:bg-gray-100',
            ]"
          >
            <time
              :datetime="format(day, 'yyyy-MM-dd')"
              class="mx-auto flex h-6 w-6 items-center justify-center rounded-md p-4"
            >
              <div class="flex-col">
                <h2>
                  {{ format(day, "d") }}
                </h2>
                <div
                  v-if="determineIfMenuExists(day, 'choices')"
                  class="mx-auto h-0.5 w-4 rounded-full bg-indigo-600"
                ></div>
              </div>
            </time>
          </button>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import useFindMonthDays from "@/composables/calendar/useFindMonthDays";
import useFindMonthByIndex from "@/composables/calendar/useFindMonthByIndex";
import { format, parseISO } from "date-fns";
import { onMounted, ref, computed, watch } from "vue";
import ParentFixedMenuCard from "@/components/parent/Menus/ParentFixedMenuCard.vue";

const { monthsDays } = useFindMonthDays(11);
const { getMonthByIndex } = useFindMonthByIndex();

const props = defineProps({
  studentId: {
    type: Number,
    required: true,
  },
});

const menus = ref([]);
const availableOrders = ref();
const availableOrderDays = ref([]);

onMounted(async () => {
  try {
    const response = await axios.get(
      `/api/parent/menu-retrieve/${props.studentId}`,
    );
    menus.value = response.data.data;

    // Fetch existing all orders and save to availableOrders
    const availableOrdersResponse = await axios.get(
      `/api/parent/available-orders/${props.studentId}`,
    );
    availableOrders.value = availableOrdersResponse.data.orders;
  } catch (error) {
    console.log(error);
  }
});

watch(availableOrders, () => {
  availableOrders.value.forEach((order) => {
    // claims is a JSON we need parse it to get it as a javascript object
    const parsedClaims = JSON.parse(order.claims);
    const claimsKeys = Object.keys(parsedClaims);

    claimsKeys.map((claim) =>
      availableOrderDays.value.push(format(parseISO(claim), "yyyy-MM-dd")),
    );
  });
});

const loopOverMenusArray = computed(() => {
  if (!menus.value) {
    return [];
  }

  let menusArray = [];
  for (let obj of menus.value) {
    menusArray.push(obj.menus[0]);
  }

  return menusArray;
});

// determine which type of menu we have based on menu type and style it differently returns boolean

const determineIfMenuExists = (day, menuType) => {
  if (!availableOrderDays.value) {
    return [];
  }

  return loopOverMenusArray.value.some((menu) =>
    format(parseISO(menu.date), "yyyy-MM-dd") === format(day, "yyyy-MM-dd") &&
    menu.menu_type === menuType &&
    // MARK MENU ONLY IF MATCHES ORDER DAY
    availableOrderDays.value.includes(format(day, "yyyy-MM-dd"))
      ? true
      : false,
  );
};

// Fixed menu card
const toggleFixedCard = ref(false);
const toggleChoicesCard = ref(false);
const fixedMenu = ref();
const choicesMenu = ref();

const onClickCalendar = (day) => {
  const formatedDay = format(day, "yyyy-MM-dd");

  return loopOverMenusArray.value.filter((menu) => {
    if (formatedDay === menu.date && menu.menu_type === "fixed") {
      toggleFixedCard.value = true;
      fixedMenu.value = menu;
    } else if (formatedDay === menu.date && menu.menu_type === "choices") {
      toggleChoicesCard.value = true;
      choicesMenu.value = menu;
    }
  });
};
</script>
