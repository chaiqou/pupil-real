<template>
  <div class="flex w-full flex-col items-center justify-center py-10">
    <ListBulletIcon class="h-10 w-10"></ListBulletIcon>
    <h3 class="mt-2 text-sm font-medium text-gray-900">{{$t('message.no_transactions')}}.</h3>
    <p class="mt-1 text-sm text-gray-500" v-if="this.role === 'parent'">
        {{$t('message.get_started_by_making_a_new_transactions')}}.
    </p>
    <p class="mt-1 text-sm text-gray-500" v-if="this.role === 'school'">
        {{$t('message.none_available_transactions_at_the_moment')}}.
    </p>
  </div>
</template>

<script>
import { ListBulletIcon } from "@heroicons/vue/24/outline";

export default {
  components: {
    ListBulletIcon,
  },
  props: {
    role: {
      type: String,
      required: true,
    },
  },
};
</script>
