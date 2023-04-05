<template>
            <nav aria-label="Progress">
                <ol role="list" class="divide-y divide-gray-300 rounded-md border border-gray-300 md:flex md:divide-y-0 md:w-fit">
                    <li class="relative md:flex md:flex-1">
                        <div class="group flex w-full items-center">
                            <span class="flex items-center px-6 py-4 text-sm font-medium">
                                <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-indigo-600">
                                    <span class="text-indigo-600">01</span>
                                </span>
                                <span class="ml-4 text-sm font-medium text-indigo-600">Setup Account</span>
                            </span>
                        </div>
                    </li>

                    <li class="relative md:flex md:flex-1">
                        <div class="flex items-center px-6 py-4 text-sm font-medium" aria-current="step">
                            <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-gray-300">
                                <span class="text-gray-500">02</span>
                            </span>
                            <span class="ml-4 text-sm font-medium text-gray-500">Personal Form</span>
                        </div>
                    </li>

                    <li class="relative md:flex md:flex-1">
                        <div class="flex items-center px-6 py-4 text-sm font-medium" aria-current="step">
                            <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border-2 border-gray-300">
                                <span class="text-gray-500">03</span>
                            </span>
                            <span class="ml-4 text-sm font-medium text-gray-500">Setup Card</span>
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
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Setup your account</h2>
            </div>

            <div class="w-full">
                <ValidationForm @submit="onSubmit" class="mt-8 space-y-6">
                    <input type="hidden" name="remember" value="true" />
                    <div class="-space-y-px rounded-md shadow-sm">
                        <div>
                            <label for="email" class="sr-only">Email address</label>
                            <Field v-model="email" rules="required|email" id="email-address" name="email" type="email" autocomplete="email" class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" placeholder="Email address" />
                            <ErrorMessage class="mt-2 text-red-500 text-sm" name="email"></ErrorMessage>
                        </div>
                        <div class="flex">
                            <div class="w-full">
                                <label for="password" class="sr-only">Password</label>
                                <Field v-model="password" rules="required|min:8|upperAndLower" id="password" name="password" type="password" autocomplete="new-password" class="relative block w-full appearance-none rounded-none border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" placeholder="Password" />
                            </div>
                            <button onmouseover="document.getElementById('password').type='text'" onmouseleave="document.getElementById('password').type='password'" type="button" class="relative -ml-px inline-flex items-center space-x-2 border border-gray-300 bg-gray-50 px-4 py-2 focus:z-10 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:border-indigo-500  focus:ring-1 focus:ring-indigo-500">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <ErrorMessage class="text-red-500 text-sm" name="password"></ErrorMessage>
                        <div class="w-full">
                            <label for="language" class="sr-only">Country</label>
                            <select v-model="language" required id="language" name="language" autocomplete="language" class="rounded-b-md relative block w-full appearance-none rounded-none border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" >
                                <option selected value="en">English</option>
                                <option value="hu">Hungary</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <ButtonForAxios classOngoing="group relative opacity-30 flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                        classDefault="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                              <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z" clip-rule="evenodd" />
                            </svg>
                        </span>
                            Sign up
                        </ButtonForAxios>
                    </div>
                </ValidationForm>
            </div>
</template>

<script>
import { Form as ValidationForm, Field, ErrorMessage } from "vee-validate";
import ButtonForAxios from "@/components/Ui/ButtonForAxios.vue";
import { useGlobalStore } from "@/stores/useGlobalStore";
import {mapActions} from "pinia";
export default {
    components: {
        ButtonForAxios,
        ValidationForm,
        Field,
        ErrorMessage
    },
    data() {
        return {
         email: "",
         password: "",
         language: "en",
        }
    },
    props: {
        uniqueId: {
            type: String,
            required: true
        },
        inviteEmail: {
            type: String,
            required: true
        }
    },
    methods: {
        ...mapActions(useGlobalStore, ["setAxiosStatus"]),
      onSubmit() {
        this.setAxiosStatus('ongoing');
        axios.post(`/api/parent-setup-account/${this.uniqueId}`, {
            email: this.email,
            password: this.password,
            language: this.language
        }).then((res) => {
            this.setAxiosStatus('updated');
            window.location.href = res.data.url;
        }).catch((err) => {
            this.setAxiosStatus('error');
            console.log(err);
        })
      },
    },
    mounted(){
        this.email = this.inviteEmail;
    }
}
</script>
