<template>
    <InvitesSchoolMultiselect name="school" label="Select school"></InvitesSchoolMultiselect>
    <div class="flex items-center text-center justify-center text-xl" v-if="this.showInviteError || this.showEmailError">
        <p class="absolute mt-5">{{errorShowing}}</p>
    </div>
   <ValidationForm id="form" @submit="onSubmit()">
       <div  class="grid grid-cols-2 md:grid-cols-3 place-items-center gap-x-2 gap-y-3 mb-5 mt-12">
               <div v-for="(element, index) in mainEmailsArray" :key="index">
                   <div @mouseover="this.showInviteError = true" @mouseleave="this.showInviteError = false" v-if="element.existsInInvites && !element.existsInUsers" class="flex border-dashed border-[2px] mr-3 border-gray-400 text-sm text-white rounded-md p-1 flex items-center">
                       <exclamation-triangle-icon  class="text-yellow-500 mr-1.5 w-5 h-5"></exclamation-triangle-icon>
                       <p class="text-yellow-500 max-w-[5rem] truncate ... hover:max-w-full">{{element.email}}</p>
                       <span class="ml-1.5 cursor-pointer text-gray-500" @click="removeTag(index); removeTagForMain(index); this.showInviteError = false">x</span>
                   </div>
                   <div @mouseover="this.showEmailError = true" @mouseleave="this.showEmailError = false" v-if="!element.existsInInvites && element.existsInUsers" class="flex mr-3 border-dashed border-[2px] border-gray-400 text-sm text-white rounded-md p-1 flex items-center">
                       <exclamation-triangle-icon  class="text-yellow-500 mr-1.5 w-5 h-5"></exclamation-triangle-icon>
                       <p class="text-yellow-500 max-w-[5rem] truncate ... hover:max-w-full">{{element.email}}</p>
                       <span class="ml-1.5 cursor-pointer text-gray-500" @click="removeTag(index); removeTagForMain(index); this.showEmailError = false">x</span>
                   </div>
                   <div v-if="!element.existsInInvites && !element.existsInUsers" class="flex bg-[#6C757D] mr-3 text-sm text-white rounded-md p-1 flex items-center">
                       <p class="max-w-[7rem] truncate ... hover:max-w-full">{{element.email}}</p>
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
       <p v-if="this.isSent" :class="this.isSuccessfullySent === 'no' ? 'text-red-500' : this.isSuccessfullySent === 'pending' ? 'text-yellow-500' : 'text-green-500'">{{this.axiosResponseGenerator}}</p>
      <div>
          <button :disabled="disabledCalculator" type="submit" :class="disabledCalculator ? 'bg-green-500 opacity-60 rounded-md text-white px-5 py-2 w-full mt-10' : 'bg-green-500 rounded-md text-white px-5 py-2 w-full mt-10'">

              <svg v-if="this.isSuccessfullySent === 'pending'" class="inline mr-2 w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                  <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
              </svg>
              <CheckIcon v-if="this.isSuccessfullySent === 'yes'" class="inline mr-2 w-6 h-6"></CheckIcon>
              {{buttonTextGenerator}}
          </button>
      </div>
   </ValidationForm>
</template>

<script>
import { Form as ValidationForm, Field, ErrorMessage } from "vee-validate";
import { useInviteStore } from "../../../stores/useInviteStore";
import { mapWritableState } from "pinia";
import { ExclamationTriangleIcon, CheckIcon } from "@heroicons/vue/24/outline";
import InvitesSchoolMultiselect from './InvitesSchoolMultiselect'
export default {
    components: {
        ValidationForm,
        Field,
        ErrorMessage,
        ExclamationTriangleIcon,
        CheckIcon,
        InvitesSchoolMultiselect
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
            existedUserEmails: [],
            mainEmailsArray: [],
            emailSender: [],
            currentPage: 1,
            lastPage: 2,
            showInviteError: false,
            showEmailError: false,
        }
    },
    computed: {
        buttonTextGenerator() {
            return this.isSuccessfullySent === 'pending' ? 'Sending...' : this.isSuccessfullySent === 'yes' ? 'Sent' : this.isSuccessfullySent === 'no' ? 'Failed' : 'Send';
        },
        errorShowing() {
            if(this.showInviteError)
            {
                return 'This email already has a pending invite'
            } else if(this.showEmailError)
            { return 'This email already signed up'}
            return ''
        },
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
              const checkIfExists = this.mainEmailsArray.find((element) => (element.existsInInvites === true || element.existsInUsers === true))
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
            const regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

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
                        const includesInviteEmail = this.existedInviteEmails.includes(current);
                        const includesUserEmail = this.existedUserEmails.includes(current);
                        const newValue = { email: current, existsInInvites: includesInviteEmail, existsInUsers: includesUserEmail };
                        return [...element, newValue];
                    }, []);
                    event.target.value = "";

                    console.log(this.mainEmailsArray, 'main')
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
                               const includesInviteEmail = this.existedInviteEmails.includes(current);
                               const includesUserEmail = this.existedUserEmails.includes(current);
                               const newValue = { email: current, existsInInvites: includesInviteEmail, existsInUsers: includesUserEmail };
                               return [...element, newValue];
                           }, []);

                           event.target.value = "";
                       },50)
            console.log(this.mainEmailsArray, 'mainEmailsArray');
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
                    this.handleGetInviteEmailsRequest();
                    this.handleGetUserEmailsRequest();
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
            axios.get(`/api/admin/invites?page=${this.currentPage}`)
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
        handleGetInviteEmailsRequest() {
            axios.get(`/api/admin/invite-emails`)
                .then((res) => {
                    this.existedInviteEmails = res.data;
                    console.log(this.existedInviteEmails);
                })
                .catch((err) => console.log(err))
        },
        handleGetUserEmailsRequest() {
            axios.get(`/api/admin/user-emails`)
                .then((res) => {
                    this.existedUserEmails = res.data;
                    console.log(this.existedUserEmails);
                })
                .catch((err) => console.log(err))
        }
     },
    created() {
        window.addEventListener("paste", this.resetOnPaste)
        this.handleGetInviteEmailsRequest();
        this.handleGetUserEmailsRequest();
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
