<template>
  <template v-if="store.toggleMenuManagementCard">
    <Suspense>
      <MenuManagementCard />
      <template #fallback>
        <MenuManagementSkeleton />
      </template>
    </Suspense>
  </template>
  <template v-if="store.toggleChoicesCard">
    <ChoicesCard />
  </template>
  <template v-if="store.toggleFixedCard">
    <FixedCard />
  </template>
</template>

<script setup>
import MenuManagementCard from "./lunch-cards/MenuManagementCard.vue";
import MenuManagementSkeleton from "./components/MenuManagementSkeleton.vue";
import FixedCard from "./lunch-cards/FixedCard.vue";
import ChoicesCard from "./lunch-cards/ChoicesCard.vue";

import { useMenuManagementStore } from "@/stores/useMenuManagementStore";

const store = useMenuManagementStore();
</script>
