<template>
   <ValidationForm id="form" @submit="onSubmit()">
       <div  class="grid grid-cols-2 md:grid-cols-3 place-items-center gap-x-2 gap-y-3 mb-5">
               <div v-for="(element, index) in mainEmailsArray" :key="index">
                   <div :class="element.exists ? 'flex bg-[#6C757D] mr-3 text-sm text-white rounded-md p-1 flex items-center animate-bounce' : 'flex bg-[#6C757D] mr-3 text-sm text-white rounded-md p-1 flex items-center'">
                       <exclamation-triangle-icon v-if="element.exists" class="text-yellow-500 mr-1.5 w-5 h-5"></exclamation-triangle-icon>
                       <p :class="element.exists ? 'text-red-500 font-bold max-w-[7rem] truncate ... hover:max-w-full' : 'max-w-[7rem] truncate ... hover:max-w-full'">{{element.email}}</p>
                       <span class="ml-1.5 cursor-pointer" @click="removeTag(index); removeTagForMain(index)">x</span>
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
                   @keydown.enter="resetField();"
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
       <p v-if="this.isSent" :class="this.isSuccessfullySent === 'no' ? 'text-red-500' : 'text-green-500'">{{this.axiosResponseGenerator}}</p>
      <div>
          <button :disabled="disabledCalculator" type="submit" class="bg-green-500 rounded-md text-white px-5 py-2 w-full mt-10">Send</button>
      </div>
   </ValidationForm>
</template>

<script>

import { Form as ValidationForm, Field, ErrorMessage } from "vee-validate";
import { useInviteStore } from "../../../stores/useInviteStore";
import { mapWritableState } from "pinia";
import { ExclamationTriangleIcon } from "@heroicons/vue/24/outline";

export default {
    components: {
        ValidationForm,
        Field,
        ErrorMessage,
        ExclamationTriangleIcon,
    },
    data() {
        return {
            emails: [],
            error: "",
            inputValue: "",
            emailsPaste: [],
            isSent: false,
            isSuccessfullySent: null,
            existedInviteEmails: [],
            mainEmailsArray: [],
            emailSender: [],
            currentPage: 1,
            lastPage: 2,
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
        ...mapWritableState(useInviteStore, ["invite_from", "invites"]),
        disabledCalculator() {
            if(this.isSent) {
                return true;
            } else if(this.emails.length === 0) {
                return true;
            } else {
              const checkIfExists = this.mainEmailsArray.find((element) => element.exists === true)
                return !!checkIfExists;
            }
        },
          axiosResponseGenerator() {
            const text = this.isSuccessfullySent;
            if(text === 'pending') {
                return 'Please wait, we are sending invites.'
            } else if(text === 'yes') {
                return 'Invites send successfully!'
            } else if(text === 'no') {
                return 'Could not send invites at the moment, please try again later, or text to support.'
            }
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
                    this.mainEmailsArray = this.emails.reduce((element, current) => {
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
            this.emails.splice(index, 1);
        },
        removeTagForMain(index) {
            this.mainEmailsArray.splice(index, 1);
        },
        removeLastTag(event) {
            if (event.target.value.length === 0) {
                this.removeTagForMain(this.mainEmailsArray.length - 1);
                this.removeTag(this.emails.length - 1);
            }
        },
        resetOnPaste() {
            setTimeout(() => {
                document.getElementById("form").reset();
            },5)
        },
        onSubmit() {
            this.isSent = true;
            this.mainEmailsArray = [];
            this.isSuccessfullySent = 'pending';
            axios
                .post("/api/send-invite", this.emailData, {
                    headers: {
                        "Content-Type": "multipart/form-formData",
                    },
                })
                .then(() => {
                    this.emails = [];
                    this.isSuccessfullySent = 'yes';
                    this.handleGetInvitesRequest();
                    this.handleUpdateInvitesTableRequest();
                })
                .catch((error) => {
                    this.isSuccessfullySent = 'no'
                    console.log(error);
                })
                .finally(() => setTimeout(() => {
                    this.isSent = false;
                    this.isSuccessfullySent = null;
                }, 5000));
        },
        handleUpdateInvitesTableRequest() {
            axios.get(`/api/school/${this.invite_from}/invites?page=${this.currentPage}`)
                .then(res => {
                    this.currentPage++;
                    this.lastPage = res.data.meta.last_page;
                    this.invites = res.data.data;
                    this.invites.map((item) => {
                        item.created_at = item.created_at.substring(0,16).replaceAll('T', ' ');
                        item.updated_at = item.updated_at.substring(0,16).replaceAll('T', ' ');
                    })
                })
                .finally(() => {
                    this.invite_from = this.schoolId;
                })
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
