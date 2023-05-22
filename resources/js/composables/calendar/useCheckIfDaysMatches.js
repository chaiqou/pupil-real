import { isSameDay, parseISO } from "date-fns";
import { useLunchFormStore } from "@/stores/useLunchFormStore";

export default function useCheckIfDaysMatches() {
  const store = useLunchFormStore();

  const ifDaysMatch = (day) => {
    return store.marked_days.some((data) => isSameDay(parseISO(data), day));
  };

  return { ifDaysMatch };
}
