<template>
  <ParentCardLayout>
    <div v-for="menu in menus" :key="menu.name">
      <ParentMenuOptions :menu="menu" ref="childFormRef" />
    </div>
    <div v-if="buttonShouldRenderComputed === 'choices'">
      <Button
        text="Submit"
        class="ml-auto w-1/2"
        type="submit"
        @click="submitChildForm"
      />
    </div>
  </ParentCardLayout>
</template>

<script setup>
import ParentCardLayout from "@/components/parent/Menus/ParentCardLayout.vue";
import ParentMenuOptions from "@/components/parent/Menus/ParentMenuOptions.vue";
import Button from "@/components/Ui/Button.vue";
import { ref, computed } from "vue";

const props = defineProps({
  menus: {
    type: Object,
    required: true,
  },
});

const childFormRef = ref([]);

const submitChildForm = () => {
  childFormRef.value.forEach((singleForm) => {
    singleForm.onSubmitForm();
  });
};

const buttonShouldRenderComputed = computed(() => {
  let condition = null;

  props.menus.map((menu) => {
    if (menu.menu_type === "choices") {
      condition = menu.menu_type;
    } else {
      condition = null;
    }
  });

  return condition;
});
</script>
