<template>
    <div v-if="isNavbarVisible">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>

        <div class="fixed inset-0 z-40 flex">
            <!--
            Off-canvas menu, show/hide based on off-canvas menu state.

            Entering: "transition ease-in-out duration-300 transform"
              From: "-translate-x-full"
              To: "translate-x-0"
            Leaving: "transition ease-in-out duration-300 transform"
              From: "translate-x-0"
              To: "-translate-x-full"
          -->
            <div class="relative flex w-full max-w-xs flex-1 flex-col bg-white">
                <!--
                Close button, show/hide based on off-canvas menu state.

                Entering: "ease-in-out duration-300"
                  From: "opacity-0"
                  To: "opacity-100"
                Leaving: "ease-in-out duration-300"
                  From: "opacity-100"
                  To: "opacity-0"
              -->
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
                        <!-- Current: "bg-gray-100 text-gray-900", Default: "text-gray-600 hover:bg-gray-50 hover:text-gray-900" -->
                        <a href="#" class="group flex items-center rounded-md bg-gray-100 px-2 py-2 text-base font-medium text-gray-900">
                            <!--
                            Heroicon name: outline/home

                            Current: "text-gray-500", Default: "text-gray-400 group-hover:text-gray-500"
                          -->
                            <svg class="mr-4 h-6 w-6 flex-shrink-0 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Dashboard
                        </a>

                        <a href="#" class="group flex items-center rounded-md px-2 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <!-- Heroicon name: outline/building-office-2 -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-4 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                            </svg>
                            Lunch order
                        </a>

                        <a href="#" class="group flex items-center rounded-md px-2 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <!-- Heroicon name: outline/list-bullet -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-4 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            Transactions
                        </a>

                        <a href="#" class="group flex items-center rounded-md px-2 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <!-- Heroicon name: outline/calendar -->
                            <svg class="mr-4 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            Calendar
                        </a>

                        <a href="#" class="group flex items-center rounded-md px-2 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <!-- Heroicon name: outline/book-open -->
                            <svg class="mr-4 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                            Knowledgebase
                        </a>

                        <a href="#" class="group flex items-center rounded-md px-2 py-2 text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <!-- Heroicon name: outline/cog-8-tooth -->
                            <svg class="mr-4 h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Settings
                        </a>
                    </nav>
                </div>
                <div class="flex flex-shrink-0 border-t border-gray-200 p-4">
                    <a href="#" class="group block flex-shrink-0">

                        <OnClickOutside v-if="isMobileSwitchAccountVisible" @trigger="showHideMobileSwitchAccount">
                            <ul  class="absolute bottom-4 z-10 mt-2 w-72 origin-top-right divide-y divide-gray-200 overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-option-0">
                                <!--
                          Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.

                          Highlighted: "text-white bg-indigo-500", Not Highlighted: "text-gray-900"
                        -->
                                <li class="cursor-default select-none bg-indigo-500 p-4 text-sm text-white" id="listbox-option-0" role="option">
                                    <div class="flex flex-col">
                                        <div class="flex justify-between">
                                            <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                                            <p class="font-normal">John Doe</p>

                                            <span class="text-white">
                      <!-- Heroicon name: mini/check -->
                      <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                      </svg>
                    </span>
                                        </div>
                                    </div>
                                </li>
                                <li class="cursor-default select-none p-4 text-sm text-gray-900" id="listbox-option-0" role="option">
                                    <div class="flex flex-col">
                                        <div class="flex justify-between">
                                            <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                                            <p class="font-normal">Jane Doe</p>

                                            <span class="hidden text-indigo-500">
                      <!-- Heroicon name: mini/check -->
                      <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                      </svg>
                    </span>
                                        </div>
                                        <!-- Highlighted: "text-indigo-200", Not Highlighted: "text-gray-500" -->
                                    </div>
                                </li>
                                <li class="cursor-default select-none p-4 py-3 text-sm text-gray-900" id="listbox-option-0" role="option">
                                    <div class="flex flex-col">
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
                                        <!-- Highlighted: "text-indigo-200", Not Highlighted: "text-gray-500" -->
                                    </div>
                                </li>

                                <!-- More items... -->
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
export default {
    components: {
        OnClickOutside
    },
    computed: {
      ...mapWritableState(useModalStore, ["isNavbarVisible", "isMobileSwitchAccountVisible"])
    },
    methods: {
      ...mapActions(useModalStore, ["showHideNavbar", "showHideMobileSwitchAccount"])
    },
};
</script>
