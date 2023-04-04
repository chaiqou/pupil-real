<template>
    <nav aria-label="Progress">
        <ol role="list" class="divide-y divide-gray-300 rounded-md border border-gray-300 md:flex md:divide-y-0 md:w-fit">
            <li class="relative md:flex md:flex-1">
                <div class="group flex w-full items-center">
                            <span class="flex items-center px-6 py-4 text-sm font-medium">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-indigo-600">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="ml-4 text-sm font-medium text-gray-900">Setup Account</span>
                            </span>
                </div>
            </li>

            <li class="relative md:flex md:flex-1">
                <div class="group flex w-full items-center">
                            <span class="flex items-center px-6 py-4 text-sm font-medium">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-indigo-600">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="ml-4 text-sm font-medium text-gray-900">Personal Form</span>
                            </span>
                </div>
            </li>

            <li class="relative md:flex md:flex-1">
                <div class="group flex w-full items-center">
                            <span class="flex items-center px-6 py-4 text-sm font-medium">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-indigo-600">
                                    <span class="text-indigo-600">03</span>
                                </span>
                                <span class="ml-4 text-sm font-medium text-indigo-600">Setup Cards</span>
                            </span>
                </div>
            </li>

            <li class="relative md:flex md:flex-1">
                <div class="group flex items-center">
                            <span class="flex items-center px-6 py-4 text-sm font-medium">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-gray-300">
                                    <span class="text-gray-500">04</span>
                                </span>
                                <span class="ml-4 text-sm font-medium text-gray-500">Verify Account</span>
                            </span>
                </div>
            </li>
        </ol>
    </nav>
    <div>
        <img class="mx-auto h-16 w-auto" src="@/components/images/pupilpay-black-color.png" alt="PupilPay" />
        <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Setup your cards</h2>
    </div>
    <div class="w-full">
<!--        <form id="form" method="POST" action="{{route('parent-setup.cards_submit',['uniqueID'=>$uniqueID])}}" class="space-y-6">-->
            <div class="flex w-full justify-between">
                <button @click="saveCard()" name="user_response" value="save_card" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save card for faster checkout</button>
                <button @click="dontSaveCard()" name="user_response" value="dont_save_card" class="inline-flex justify-center rounded-md border border-[1px] bg-white py-2 px-4 text-sm font-medium shadow-sm hover:bg-gray-100 focus:outline-none">Don't save card</button>
            </div>
    </div>
</template>
<script>
export default {
    props: {
        uniqueId: {
            type: String,
            required: true
        },
    },
    methods: {
        saveCard() {
            axios.post(`/api/parent-setup-cards/${this.uniqueId}`, {
                user_response: 'save_card'
            }).then((res) => {
                console.log(res.data);
                window.location.href = res.data.url;
            }).catch((err) => {
                console.log(err);
            })
        },
        dontSaveCard() {
            axios.post(`/api/parent-setup-cards/${this.uniqueId}`, {
                user_response: 'dont_save_card'
            }).then((res) => {
                window.location.href = res.data.url;
            }).catch((err) => {
                console.log(err);
            })
        },
    },
}
</script>
