<template>
  <nav class="mt-5 flex-1 space-y-1 bg-white px-2">
    <span v-for="item in navigation" :key="item">
      <a
        v-if="!item.hidden"
        :href="item.href && item.name !== 'payouts' ? item.href : null"
        @click="item.name === 'payouts' ? onClickPayoutsDashboard() : null"
        :class="
          item.current
            ? 'group flex cursor-pointer items-center rounded-md bg-gray-200 px-2 py-2 text-sm font-medium text-gray-900 hover:bg-gray-300'
            : 'group flex cursor-pointer items-center rounded-md px-2 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100'
        "
      >
        <div class="mr-3 w-5">
          <component :is="item.icon"></component>
        </div>
        {{ $t("message." + item.name) }}
      </a>
    </span>
  </nav>
</template>

<script>
import {
  HomeIcon,
  ListBulletIcon,
  BuildingOffice2Icon,
  UsersIcon,
  BookOpenIcon,
  Cog8ToothIcon,
  CakeIcon,
  CommandLineIcon,
  ClipboardDocumentListIcon,
  BanknotesIcon,
} from "@heroicons/vue/24/outline";

export default {
  components: {
    HomeIcon,
    ListBulletIcon,
    BuildingOffice2Icon,
    UsersIcon,
    BookOpenIcon,
    Cog8ToothIcon,
    CakeIcon,
    CommandLineIcon,
    ClipboardDocumentListIcon,
    BanknotesIcon,
  },
  props: {
    navigation: {
      type: Array,
      required: true,
    },
    current: {
      type: String,
    },
  },
  methods: {
    findCurrent() {
      let cleanedCurrent = this.current;
      cleanedCurrent = cleanedCurrent.split(".").splice(1).join(".");
      const navigation = this.navigation.find(
        (col) =>
          col.name
            .toLowerCase()
            .replaceAll(" ", ".")
            .replaceAll("-", ".")
            .replaceAll("_", ".") ===
          cleanedCurrent
            .toLowerCase()
            .replaceAll(" ", ".")
            .replaceAll("-", ".")
            .replaceAll("_", "."),
      );
      navigation.current = true;

      if (navigation.parentPage) {
        const parentNavigation = this.navigation.find(
          (col) => col.name === navigation.parentPage,
        );
        parentNavigation.current = true;
      }
    },
    onClickPayoutsDashboard() {
      axios.get("/api/school/payouts-dashboard").then((response) => {
        window.open(response.data, "_blank");
      });
    },
  },
  created() {
    this.findCurrent();
  },
};
</script>
