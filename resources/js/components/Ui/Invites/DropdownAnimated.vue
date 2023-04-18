<template>
  <div @click="showHideDropdown()" href="#" class="block w-full flex-shrink-0">
    <slot></slot>
    <Transition name="fade">
      <ul
        @mouseleave="showHideDropdown()"
        v-if="isDropdownVisible"
        class="absolute top-1 z-10 mt-2 origin-top-right divide-y divide-gray-200 overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        tabindex="-1"
        role="listbox"
        aria-labelledby="listbox-label"
        aria-activedescendant="listbox-option-0"
      >
        <li
          class="cursor-pointer select-none p-2.5 py-1.5 text-sm text-gray-900 hover:bg-gray-200"
          id="listbox-option-0"
          role="option"
        >
          <button @click="handleDeleteInviteRequest" class="flex flex-col">
            <div class="flex justify-between">
              <h1 v-for="item in items" :key="item" class="font-normal">
                {{ $t('message.'+item) }}
              </h1>
              <span class="text-gray-900"> </span>
            </div>
          </button>
        </li>
        <!-- More items... -->
      </ul>
    </Transition>
  </div>
</template>

<script>
import { mapWritableState } from "pinia";
import { useInviteStore } from "@/stores/useInviteStore";

export default {
  data() {
    return {
      isDropdownVisible: false,
    };
  },
  computed: {
    ...mapWritableState(useInviteStore, ["invites"]),
  },
  methods: {
    showHideDropdown() {
      this.isDropdownVisible = !this.isDropdownVisible;
    },
    handleDeleteInviteRequest() {
      axios
        .delete(`/api/${this.role}/invite/${this.inviteId}`)
        .then((res) => {
          this.invites = res.data.data;
          this.invites.map((item) => {
            item.created_at = item.created_at
              .substring(0, 16)
              .replaceAll("T", " ");
            item.updated_at = item.updated_at
              .substring(0, 16)
              .replaceAll("T", " ");
          });
        })
        .catch((err) => console.log(err));
    },
  },
  props: {
    items: {
      type: Array,
      required: true,
    },
    inviteId: {
      type: Number,
      required: true,
    },
    role: {
      // admin, merchant or parent
      type: String,
      required: true,
    },
  },
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
