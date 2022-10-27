<template>
    <div v-if="isNavbarVisible">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>

        <div class="fixed inset-0 z-40 flex">

            <div class="relative flex w-full max-w-xs flex-1 flex-col bg-white">

                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="showHideNavbar" type="button" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <!-- Heroicon name: outline/x-mark -->
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="h-0 flex-1 overflow-y-auto pt-5 pb-4">
                    <div class="flex flex-shrink-0 items-center px-4">
                        <img class="h-8 w-auto" src="https://pupilpay.hu/resc/img/pupilpay-black-color.svg" alt="Your Company" />
                    </div>
                    <nav class="mt-5 space-y-1 px-2">
                        <a v-for="item in navigation" :key="item" :href="item.href" :class="item.current ? 'group flex items-center rounded-md bg-gray-300 px-2 py-2 text-base font-medium text-gray-900' : 'group flex items-center rounded-md px-2 py-2 text-base font-medium text-gray-900'">
                          <div class="w-5 mr-3">
                                <component :is="item.icon"/>
                            </div>
                            {{item.name}}
                        </a>

                    </nav>
                </div>
                <div class="flex flex-shrink-0 border-t border-gray-200 p-4">
                    <a href="#" class="group block flex-shrink-0">

                        <OnClickOutside v-if="isMobileSwitchAccountVisible" @trigger="showHideMobileSwitchAccount">
                            <ul  class="absolute bottom-4 z-10 mt-2 w-72 origin-top-right divide-y divide-gray-200 overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-option-0">
         <div v-if="role === 'parent'" >
             <li v-for="item in students" :key="item.id" :class="item.id === student.id ? 'cursor-default select-none bg-indigo-500 hover:bg-indigo-600 p-4 text-sm text-white' : 'cursor-default hover:bg-gray-200 select-none p-4 text-sm text-black'" id="listbox-option-0" role="option">
                 <a :href="item.id" class="flex flex-col">
                     <div class="flex justify-between">
                         <p class="font-normal">{{item.first_name + ' ' + item.last_name}}</p>

                         <span class="text-white">
                      <svg :class="item.id === student.id ? 'h-5 w-5' : 'hidden'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                      </svg>
                    </span>
                     </div>
                 </a>
             </li>
         </div>
                                <li class="cursor-default hover:bg-gray-200 select-none p-4 py-3 text-sm text-gray-900" id="listbox-option-0" role="option">
                                    <a href="/logout" class="flex flex-col">
                                        <div class="flex justify-between">
                                            <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                                            <p class="font-normal">Log out</p>

                                            <span class="text-gray-900">
                      <!-- Heroicon name: mini/arrow-right-on-rectangle -->
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 015.25 2h5.5A2.25 2.25 0 0113 4.25v2a.75.75 0 01-1.5 0v-2a.75.75 0 00-.75-.75h-5.5a.75.75 0 00-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 00.75-.75v-2a.75.75 0 011.5 0v2A2.25 2.25 0 0110.75 18h-5.5A2.25 2.25 0 013 15.75V4.25z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M6 10a.75.75 0 01.75-.75h9.546l-1.048-.943a.75.75 0 111.004-1.114l2.5 2.25a.75.75 0 010 1.114l-2.5 2.25a.75.75 0 11-1.004-1.114l1.048-.943H6.75A.75.75 0 016 10z" clip-rule="evenodd" />
                      </svg>
                    </span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </OnClickOutside>

                        <div class="flex items-center" @click="showHideMobileSwitchAccount">
                            <div>
                                <p class="text-base font-medium text-gray-700 group-hover:text-gray-900">Student name 1</p>
                                <p class="text-sm font-medium text-gray-500 group-hover:text-gray-700">Switch student</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="w-14 flex-shrink-0">
                <!-- Force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>
</template>

<script>
import { mapWritableState, mapActions } from 'pinia'
import { useModalStore } from "../stores/useModalStore";
import { OnClickOutside } from '@vueuse/components'
import { HomeIcon, ListBulletIcon, BuildingOffice2Icon, UsersIcon, BookOpenIcon, Cog8ToothIcon, } from "@heroicons/vue/24/outline";
export default {
    components: {
        OnClickOutside,
        HomeIcon,
        ListBulletIcon,
        BuildingOffice2Icon,
        UsersIcon,
        BookOpenIcon,
        Cog8ToothIcon
    },
    computed: {
      ...mapWritableState(useModalStore, ["isNavbarVisible", "isMobileSwitchAccountVisible"])
    },
    props: {
        navigation: {
            type: Array,
            required: true,
        },
        role: {
            type: String,
        },
        current: {
            type: String,
        },
        students: {
            type: Array,
        },
        student: {
            type: Object
        }
    },
    methods: {
        ...mapActions(useModalStore, ["showHideNavbar", "showHideMobileSwitchAccount"]),

        findCurrent() {
            let cleanedCurrent = this.current;
            cleanedCurrent =  cleanedCurrent.split('.').splice(1).join('.');
            let navigation = this.navigation.find((col => col.name.toLowerCase().replaceAll(' ', '.') === cleanedCurrent));
            navigation.current = true;
        },
    },
    created() {
        this.findCurrent();
    },
};
</script>



