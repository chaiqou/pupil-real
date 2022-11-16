<template>
   <ValidationForm id="form" @submit="onSubmit()">
       <div  class="grid grid-cols-2 md:grid-cols-3 place-items-center gap-x-2 gap-y-3 mb-5">
               <div v-for="(element, index) in mainEmailsArray" :key="index">
                   <div class="flex bg-[#6C757D] mr-3 text-sm text-white rounded-md p-1">
                       <p :class="element.exists === true ?  'text-red-900 max-w-[7rem] truncate ... hover:max-w-full' : 'max-w-[7rem]'">{{element.email}}</p>
                       <span class="ml-1.5 cursor-pointer" @click="removeTag(index)">x</span>
                   </div>
               </div>
           </div>
       <label for="emails">Invite users by their email address.</label>
       <div
           class="my-2 flex items-center border-gray-600 border-2 rounded-md justify-between px-4"
       >
           <Field v-slot="{ resetField, field }" name="emails">
               <input
                   class="outline-0 w-full m-1.5 placeholder-white"
                   v-bind="field"
                   @keydown.enter="resetField(); this.calculate;"
                   @keydown="addTag"
                   @keydown.delete="removeLastTag"
                   @paste="pasteTags"
                   v-model="this.inputValue"
               />
           </Field>
       </div>
       <p class="text-gray-400 text-[10px]">
           Be careful, dont send invite on wrong email.
       </p>
       <p v-if="this.isSent" class="text-green-500">All emails send successfully!</p>
      <div>
          <button type="submit" class="bg-green-500 rounded-md text-white px-5 py-2 w-full mt-10">Send</button>
      </div>
   </ValidationForm>
</template>

<script>

import { Form as ValidationForm, Field, ErrorMessage } from "vee-validate";
import { useInviteStore } from "../../../stores/useInviteStore";
import { mapWritableState } from "pinia";

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
            inputValue: "",
            emailsPaste: [],
            isSent: false,
            existedInviteEmails: [],
            mainEmailsArray: [],
        }
    },
    computed: {
        emailData() {
            const formData = new FormData();
            for (var i = 0; i < this.emails.length; i++) {
                formData.append("emails[" + i + "]", this.emails[i]);
            }
            return formData;
        },
        ...mapWritableState(useInviteStore, ["invite_from"]),
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
                    this.newEmailsArray = this.emails.reduce((element, current) => {
                        const includesEmail = this.existedInviteEmails.includes(current);
                        const newValue = { email: current, exists: includesEmail };
                        return [...element, newValue];
                    }, []);
                    event.target.value = "";
                }
            }
        },
        pasteTags(event) {
                       setTimeout(() => {
                               this.emailsPaste =
                                   this.inputValue.replaceAll(",", "").split(" ");
                               if(this.mainEmailsArray.includes(this.emailsPaste)) {return}
                           this.emails = this.emails.concat(this.emailsPaste);

                           this.mainEmailsArray = this.emails.reduce((element, current) => {
                               const includesEmail = this.existedInviteEmails.includes(current);
                               const newValue = { email: current, exists: includesEmail };
                               return [...element, newValue];
                           }, []);

                           event.target.value = "";
                       },50)
            },
        removeTag(index) {
            this.mainEmailsArray.splice(index, 1);
        },
        removeLastTag(event) {
            if (event.target.value.length === 0) {
                this.removeTag(this.mainEmailsArray.length - 1);
            }
        },
        resetOnPaste() {
            setTimeout(() => {
                document.getElementById("form").reset();
            },5)
        },
        onSubmit() {
            axios
                .post("/api/send-invite", this.emailData, {
                    headers: {
                        "Content-Type": "multipart/form-formData",
                    },
                })
                .then(() => {
                    this.emails = [];
                    this.isSent = true;
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => setTimeout(() => {
                    this.isSent = false;
                }, 5000));
        },
        handleGetInvitesRequest() {
            axios.get(`/api/${this.invite_from}/invites`)
                .then((res) => {
                    this.existedInviteEmails = res.data;
                    console.log(this.existedInviteEmails);
                })
                .catch((err) => console.log(err))
        }
     },
    created() {
        window.addEventListener("paste", this.resetOnPaste)
        this.handleGetInvitesRequest();
    },
}

</script>

<style src="@vueform/multiselect/themes/default.css" />
<style>
body {
    --ms-bg: transparent;
    --ms-tag-bg: #6c757d;
    --ms-border-color: #6c757d;
}
</style>
