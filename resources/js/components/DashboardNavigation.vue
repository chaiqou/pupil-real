<template>
    <nav class="mt-5 flex-1 space-y-1 bg-white px-2">
    <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
    <a :href="item.href" v-for="item in navigation" :key="item" :class="item.current ? 'group flex items-center rounded-md hover:bg-gray-300 bg-gray-200 px-2 py-2 text-sm font-medium text-gray-900' : 'group flex items-center rounded-md hover:bg-gray-100 px-2 py-2 text-sm font-medium text-gray-900'">
        <!--
        Heroicon name: outline/home

        Current: "text-gray-500", Default: "text-gray-400 group-hover:text-gray-500"
      -->
        <div class="w-5 mr-3">
            <component :is="item.icon"></component>
        </div>
        {{item.name}}
    </a>

    </nav>
</template>

<script>
import { CalendarIcon, ChartBarIcon, FolderIcon, HomeIcon, InboxIcon, UsersIcon } from '@heroicons/vue/24/outline';

export default {
    components: {
        CalendarIcon,
        ChartBarIcon,
        FolderIcon,
        HomeIcon,
        InboxIcon,
        UsersIcon,
    },
    props: {
        navigation: {
            type: Array,
            required: true,
        },
        current: {
            type: String,
        }
    },
    methods: {
      findCurrent() {
          let navigation = this.navigation.find((col => col.name.toLowerCase() === this.current));
          navigation.current = true;
          console.log(this.navigation);
          console.log(this.current);
          console.log(navigation, 'current');
      }
    },
    created() {
           this.findCurrent();
    }
}
</script>
