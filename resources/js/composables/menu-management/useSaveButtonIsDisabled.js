import { computed } from "vue";

export default function useSaveButtonIsDisabled(menus) {
  const buttonIsDisabled = computed(() => {
    let disabledButtonState = false;

    for (const key in menus) {
      if (
        (Array.isArray(menus[key]) && menus[key].length === 0) ||
        menus[key] === ""
      ) {
        disabledButtonState = true;
      }
    }

    return disabledButtonState;
  });

  return { buttonIsDisabled };
}
