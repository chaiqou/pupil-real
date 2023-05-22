<template>
  <div class="flex w-full flex-col items-center justify-center py-10">
    <ListBulletIcon class="h-10 w-10"></ListBulletIcon>
    <h3
      class="mt-2 text-sm font-medium text-gray-900"
      v-if="invite === 'merchant'"
    >
      {{
        $t(
          "message.this_school_does_not_have_any_merchants_invited_invite_some_to_get_started",
        )
      }}
    </h3>
    <h3
      class="mt-2 text-sm font-medium text-gray-900"
      v-if="invite === 'parent'"
    >
      {{
        $t(
          "message.this_school_does_not_have_any_parents_invited_invite_some_to_get_started",
        )
      }}
    </h3>
  </div>
</template>

<script>
import { ListBulletIcon } from "@heroicons/vue/24/outline";

export default {
  components: {
    ListBulletIcon,
  },
  props: {
    invite: {
      type: String,
      required: true,
    },
  },
};
</script>
