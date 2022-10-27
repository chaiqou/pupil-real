<template>
    <div @click="showHideSwitchAccount()" href="#" class="block w-full flex-shrink-0">
        <ul  @mouseleave="showHideSwitchAccount()" v-if="isSwitchAccountVisible" class="absolute bottom-4 z-10 mt-2 w-72 origin-top-right divide-y divide-gray-200 overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-option-0">
            <!--
      Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.
      Highlighted: "text-white bg-indigo-500", Not Highlighted: "text-gray-900"
    -->
            <div v-if="role === 'parent'">
                <li v-for="item in students" :key="item.id"  :class="item.id === student.id ?  ' select-none bg-indigo-500   text-sm text-white' : 'select-none text-sm text-black'" id="listbox-option-0" role="option">
                    <a :href="item.id" class="flex flex-col p-4 cursor-pointer">
                        <div class="flex justify-between">
                            <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                            <p class="font-normal">{{item.first_name + ' ' + item.last_name}}</p>

                            <span class="text-white">
                      <!-- Heroicon name: mini/check -->
                      <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                      </svg>
                    </span>
                        </div>
                    </a>
                </li>
            </div>
            <li class="cursor-default select-none p-4 py-3 text-sm text-gray-900" id="listbox-option-0" role="option">
                <a href="/logout" class="flex flex-col">
                    <div class="flex justify-between">
                        <!-- Selected: "font-semibold", Not Selected: "font-normal" -->

                        <h1 class="font-normal cursor-pointer">Log out</h1>


                        <span class="text-gray-900">
                      <!-- Heroicon name: mini/arrow-right-on-rectangle -->
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 015.25 2h5.5A2.25 2.25 0 0113 4.25v2a.75.75 0 01-1.5 0v-2a.75.75 0 00-.75-.75h-5.5a.75.75 0 00-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 00.75-.75v-2a.75.75 0 011.5 0v2A2.25 2.25 0 0110.75 18h-5.5A2.25 2.25 0 013 15.75V4.25z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M6 10a.75.75 0 01.75-.75h9.546l-1.048-.943a.75.75 0 111.004-1.114l2.5 2.25a.75.75 0 010 1.114l-2.5 2.25a.75.75 0 11-1.004-1.114l1.048-.943H6.75A.75.75 0 016 10z" clip-rule="evenodd" />
                      </svg>
                    </span>
                    </div>
                    <!-- Highlighted: "text-indigo-200", Not Highlighted: "text-gray-500" -->
                </a>
            </li>
            <!-- More items... -->
        </ul>

        <div class="flex items-center cursor-pointer">
            <div>
                <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">{{student.first_name + ' ' + student.last_name}} </p>
                <p class="text-xs font-medium text-gray-500 group-hover:text-gray-700">Switch student</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isSwitchAccountVisible: false,
        };
    },
    methods: {
        showHideSwitchAccount() {
            this.isSwitchAccountVisible = !this.isSwitchAccountVisible
        }
    },
    props: {
        role: {
            type: String,
        },
        students: {
            type: Array,
            required: true
        },
        student: {
            type: Object,
            required: true,
        }
    },
}
</script>
