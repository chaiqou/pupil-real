<template>
  <ParentCardLayout>
    <div v-for="menu in menus" :key="menu.name">
      <ParentMenuOptions :menu="menu" ref="childRef" />
    </div>
    <Button
      text="Submit"
      class="ml-auto w-1/2"
      type="submit"
      @click="submitFromParent"
    />
  </ParentCardLayout>
</template>

<script setup>
import ParentCardLayout from "@/components/parent/Menus/ParentCardLayout.vue";
import ParentMenuOptions from "@/components/parent/Menus/ParentMenuOptions.vue";
import Button from "@/components/Ui/Button.vue";
import { ref } from "vue";

const childRef = ref([]);

const submitFromParent = () => {
  childRef.value.forEach((child) => {
    child.onSubmitForm();
  });
};

defineProps({
  menus: {
    type: Object,
    required: true,
  },
});
</script>
