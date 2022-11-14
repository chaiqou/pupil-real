<template>
<!--    <div>-->
<!--        <label class="text-md flex font-bold text-gray-600 whitespace-normal"-->
<!--        >{{ label }}-->
<!--        </label>-->
<!--        <Multiselect-->
<!--            class="mt-8"-->
<!--            mode="tags"-->
<!--            :createOption="true"-->
<!--            :searchable="true"-->
<!--            v-model="this.value"-->
<!--            :addOptionOn="['enter', 'space', 'tab', ';', ',']"-->
<!--            :options="emails"-->
<!--            @paste="show(value)"-->
<!--        />-->
<!--        <span class="mt-2 text-sm text-red-500 whitespace-nowrap">{{-->
<!--                errorMessage-->
<!--            }}</span>-->

<!--        <button @click="send(value)" class="text-center m-10 text-white rounded-md bg-green-500 px-6 py-2">Send invites</button>-->
<!--    </div>-->
   <ValidationForm>
       <div
           class="my-2 flex items-center border-gray-600 border-2 rounded-md justify-between px-4"
       >
           <div
               v-for="(email, index) in emails"
               :key="email"
               class="flex"
           >
               <div class="flex bg-[#6C757D] mr-3 text-sm text-white rounded-md p-1">
                   <p>{{ email }}</p>
                   <button class="ml-1.5" @click="removeTag(index)">x</button>
               </div>
           </div>
           <Field v-slot="{ resetField, field }" name="genres">
               <input
                   class=" outline-0 w-full m-1.5 placeholder-white"
                   v-bind="field"
                   @keydown.enter="resetField()"
                   @keydown="addTag"
                   @keydown.delete="removeLastTag"
               />
           </Field>
       </div>
       <p class="text-gray-400 text-[10px]">
           Be careful !
       </p>
       <p class="text-red-500">{{ error }}</p>
   </ValidationForm>
</template>

<script>

import { Form as ValidationForm, Field, ErrorMessage } from "vee-validate";

export default {
    components: {
        ValidationForm,
        Field,
        ErrorMessage
    },
    data() {
        return {
            emails: [],
            error: "",
        }
    },
    props: {
        name: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            required: true,
        }
    },
    methods: {
        addTag(event) {
            const regexEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/gi;

            if (event.code === "Comma" || event.code === "Enter") {
                event.preventDefault();
                let emailTag = event.target.value.trim().toLowerCase();
                if (emailTag.length > 0) {
                    if (this.emails.includes(emailTag)) {
                        return;
                    }
                    if (!regexEmail.test(emailTag)) {
                        return;
                    }
                    else
                        this.emails.push(
                            emailTag[0] + emailTag.slice(1).split(" ")[0]
                        );
                    event.target.value = "";
                }
            }
        },
        removeTag(index) {
            this.emails.splice(index, 1);
        },
        removeLastTag(event) {
            if (event.target.value.length === 0) {
                this.removeTag(this.emails.length - 1);
            }
        },
    }
}

//
// const props = defineProps({
//     name: {
//         type: String,
//         required: true,
//     },
//     label: {
//         type: String,
//         required: true,
//     },
// });
//
// function updateSelectedMeal() {
//     console.log(value, '1');
// }
//
//
// function send(value) {
//     console.log(value, 'values');
// }
//
// const emails = [
//     'hi'
// ];
//
// function required(value) {
//     if (value) {
//         return true;
//     }
//     return "This field is required";
// }
//
// const nameRef = toRef(props, "name");
// const { errorMessage, value } = useField(nameRef, required);
//
// function addTags(value) {
//     value.split(',').map((item) => {
//         emails.push({
//             name: item.trim(),
//         });
//     });
// }
//
//
// function hello(value) {
//     let clipboard= window.event.clipboardData.getData('text');
//     emails.push(value)
// }
</script>

<style src="@vueform/multiselect/themes/default.css" />
<style>
body {
    --ms-bg: transparent;
    --ms-tag-bg: #6c757d;
    --ms-border-color: #6c757d;
}

.multiselect-tags-search {
    background-color: inherit;
}
</style>
