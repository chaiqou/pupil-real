<template>
    <nav class="mt-5 flex-1 space-y-1 bg-white px-2">
        <span v-for="item in navigation" :key="item">
            <a
                v-if="!item.hidden"
                :href="item.href"
                :class="
                    item.current
                        ? 'group flex items-center rounded-md hover:bg-gray-300 bg-gray-200 px-2 py-2 text-sm font-medium text-gray-900'
                        : 'group flex items-center rounded-md hover:bg-gray-100 px-2 py-2 text-sm font-medium text-gray-900'
                "
            >
                <div class="w-5 mr-3">
                    <component :is="item.icon"></component>
                </div>
                {{ item.name }}
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
            let navigation = this.navigation.find(
                (col) =>
                    col.name
                        .toLowerCase()
                        .replaceAll(" ", ".")
                        .replaceAll("-", ".") ===
                    cleanedCurrent
                        .toLowerCase()
                        .replaceAll(" ", ".")
                        .replaceAll("-", ".")
            );
            navigation.current = true;

            if (navigation.parentPage) {
                let parentNavigation = this.navigation.find(
                    (col) => col.name === navigation.parentPage
                );
                parentNavigation.current = true;
            }
        },
    },
    created() {
        this.findCurrent();
    },
};
</script>
