<template>
  <template v-if="store.toggleFixedCard">
    <ParentMenuCard :menus="store.fixedMenus" />
  </template>

  <template v-if="store.toggleChoicesCard">
    <ParentMenuCard :menus="store.choicesMenus" />
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
          <div>{{ $t("message.m") }}</div>
          <div>{{ $t("message.tue") }}</div>
          <div>{{ $t("message.w") }}</div>
          <div>{{ $t("message.th") }}</div>
          <div>{{ $t("message.f") }}</div>
          <div>{{ $t("message.sat") }}</div>
          <div>{{ $t("message.sun") }}</div>
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
              menuIsSaved(day)
                ? '!bg-purple-700 text-white hover:!bg-purple-600'
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
                  v-if="
                    determineIfMenuIsChoices(day, 'choices') &&
                    !menuIsSaved(day)
                  "
                  class="mx-auto h-0.5 w-4 rounded-full bg-purple-600"
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
import ParentMenuCard from "@/components/parent/Menus/ParentMenuCard.vue";
import { useMenuManagementStore } from "@/stores/useMenuManagementStore";

const props = defineProps({
  studentId: {
    type: Number,
    required: true,
  },
});

const { monthsDays } = useFindMonthDays(11);
const { getMonthByIndex } = useFindMonthByIndex();

const menus = ref([]);
const availableOrders = ref();
const availableOrderDays = ref([]);

onMounted(async () => {
  try {
    const availableMenusResponse = await axios.get(
      `/api/parent/menu-retrieve/${props.studentId}`,
    );
    menus.value = availableMenusResponse.data.data;

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

// determine which type of menu we have based on menu type and style it differently returns boolean

const loopOverMenusArray = computed(() => {
  let menusArray = [];
  for (let obj of menus.value) {
    menusArray.push(obj.menus);
  }

  return menusArray;
});

const determineIfMenuIsChoices = (day, menuType) => {
  if (!availableOrderDays.value) {
    return [];
  }

  return loopOverMenusArray.value.some((menusArray) =>
    menusArray.some(
      (menu) =>
        format(parseISO(menu.date), "yyyy-MM-dd") ===
          format(day, "yyyy-MM-dd") &&
        menu.menu_type === menuType &&
        availableOrderDays.value.includes(format(day, "yyyy-MM-dd")),
    ),
  );
};

// Determine if menu is already saved or not

const menuIsSaved = function (calendarDay) {
  if (!availableOrderDays.value && !availableOrders.value) {
    return [];
  }

  let menuIsSavedBoolean = false;

  if (availableOrders.value) {
    availableOrders.value.map((order) => {
      let objectClaims = JSON.parse(order.claims);

      for (const day in objectClaims) {
        // eslint-disable-next-line no-prototype-builtins
        if (objectClaims.hasOwnProperty(day)) {
          if (format(calendarDay, "yyyy-MM-dd") === day) {
            objectClaims[day].map((ord) => {
              if (ord.menu_code !== null) {
                menuIsSavedBoolean = true;
              }
            });
          }
        }
      }
    });

    return menuIsSavedBoolean;
  }
};

// Fixed menu card

const store = useMenuManagementStore();

const onClickCalendar = (day) => {
  const formatedDay = format(day, "yyyy-MM-dd");

  return loopOverMenusArray.value.filter((menusArray) => {
    menusArray.filter((menu) => {
      if (formatedDay === menu.date && menu.menu_type === "fixed") {
        store.toggleFixedCard = true;
        store.fixedMenus.push(menu);
      } else if (formatedDay === menu.date && menu.menu_type === "choices") {
        store.toggleChoicesCard = true;
        store.choicesMenus.push(menu);
      }
    });
  });
};
</script>
