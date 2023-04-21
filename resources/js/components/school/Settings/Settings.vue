<template>
  <h1 class="mt-10 ml-10 text-2xl font-bold">{{ $t("message.settings") }}</h1>

  <div class="m-10">
    <h1>{{ $t("message.change_language") }}</h1>
    <div class="mt-2 w-32">
      <SetLanguage :userId="userId"></SetLanguage>
    </div>
  </div>
</template>

<script>
import SetLanguage from "@/components/Ui/SetLanguage.vue";
export default {
  components: {
    SetLanguage,
  },
  props: {
    userId: {
      type: Number,
      required: true,
    },
  },
};
</script>
