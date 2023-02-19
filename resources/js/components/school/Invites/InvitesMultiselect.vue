<template>
  <div
    class="flex items-center justify-center text-center text-sm text-red-500"
    v-if="this.showInviteError || this.showEmailError"
  >
    <p class="absolute mt-16">{{ errorShowing }}</p>
  </div>
  <ValidationForm id="form" @submit="onSubmit()">
    <div
      :class="
        this.mainEmailsArray.length
          ? 'my-5 block flex flex-col justify-center rounded-md border-[1px] border-gray-400 py-5'
          : 'mb-5 hidden'
      "
    >
      <p class="ml-7 text-sm">Sending invites to:</p>
      <div class="flex flex-wrap pl-5">
        <div v-for="(element, index) in mainEmailsArray" :key="index">
          <div
            @mouseover="this.showInviteError = true"
            @mouseleave="this.showInviteError = false"
            v-if="element.existsInInvites && !element.existsInUsers"
            class="m-1.5 mr-3 flex flex items-center rounded-md border-[2px] border-dashed border-gray-400 p-1 text-sm text-white"
          >
            <exclamation-triangle-icon
              class="mr-1.5 h-5 w-5 text-yellow-500"
            ></exclamation-triangle-icon>
            <p class="text-yellow-500">
              {{ element.email }}
            </p>
            <span
              class="ml-1.5 cursor-pointer text-gray-500"
              @click="
                removeTag(index);
                removeTagForMain(index);
                this.showInviteError = false;
              "
              >x</span
            >
          </div>
          <div
            @mouseover="this.showEmailError = true"
            @mouseleave="this.showEmailError = false"
            v-if="!element.existsInInvites && element.existsInUsers"
            class="m-1.5 mr-3 flex flex items-center rounded-md border-[2px] border-dashed border-gray-400 p-1 text-sm text-white"
          >
            <exclamation-triangle-icon
              class="mr-1.5 h-5 w-5 text-yellow-500"
            ></exclamation-triangle-icon>
            <p class="text-yellow-500">
              {{ element.email }}
            </p>
            <span
              class="ml-1.5 cursor-pointer text-gray-500"
              @click="
                removeTag(index);
                removeTagForMain(index);
                this.showEmailError = false;
              "
              >x</span
            >
          </div>
          <div
            @mouseover="this.showEmailError = true"
            @mouseleave="this.showEmailError = false"
            v-if="element.existsInInvites && element.existsInUsers"
            class="m-1.5 mr-3 flex flex items-center rounded-md border-[2px] border-dashed border-gray-400 p-1 text-sm text-white"
          >
            <exclamation-triangle-icon
              class="mr-1.5 h-5 w-5 text-yellow-500"
            ></exclamation-triangle-icon>
            <p class="text-yellow-500">
              {{ element.email }}
            </p>
            <span
              class="ml-1.5 cursor-pointer text-gray-500"
              @click="
                removeTag(index);
                removeTagForMain(index);
                this.showEmailError = false;
              "
              >x</span
            >
          </div>

          <div
            v-if="!element.existsInInvites && !element.existsInUsers"
            class="m-1.5 mr-3 flex flex items-center rounded-md bg-[#6C757D] p-1 text-sm text-white"
          >
            <p class="max-w-fit">
              {{ element.email }}
            </p>
            <span
              class="ml-1.5 cursor-pointer"
              @click="
                removeTag(index);
                removeTagForMain(index);
              "
              >x</span
            >
          </div>
        </div>
      </div>
    </div>
    <div :class="this.mainEmailsArray.length ? 'text-sm' : 'mt-10'">
      <label for="emails">Email addresses</label>
    </div>
    <div
      class="my-2 flex items-center justify-between rounded-md border-2 border-gray-600 px-1.5"
    >
      <Field v-slot="{ resetField, field }" name="emails">
        <input
          class="my-1.5 w-full placeholder-white outline-0"
          v-bind="field"
          @keydown.enter="resetField()"
          @keydown="addTag"
          @keydown.delete="removeLastTag"
          @paste="pasteTags"
          v-model="this.inputValue"
        />
      </Field>
    </div>
    <p class="text-[10px] text-gray-400">
      Be careful, dont send invite to wrong email.
    </p>
    <p
      v-if="this.isSent"
      :class="
        this.isSuccessfullySent === 'no'
          ? 'text-red-500'
          : this.isSuccessfullySent === 'pending'
          ? 'text-yellow-500'
          : 'text-green-500'
      "
    >
      {{ this.axiosResponseGenerator }}
    </p>
    <div>
      <button
        :disabled="disabledCalculator"
        type="submit"
        :class="
          disabledCalculator
            ? 'mt-10 w-full rounded-md bg-indigo-600 px-5 py-2 text-white opacity-60 hover:bg-indigo-700'
            : 'mt-10 w-full rounded-md bg-indigo-600 px-5 py-2 text-white hover:bg-indigo-700'
        "
      >
        <svg
          v-if="this.isSuccessfullySent === 'pending'"
          class="mr-2 inline h-6 w-6 animate-spin fill-blue-600 text-gray-200 dark:text-gray-600"
          viewBox="0 0 100 101"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
            fill="currentColor"
          />
          <path
            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
            fill="currentFill"
          />
        </svg>
        <CheckIcon
          v-if="this.isSuccessfullySent === 'yes'"
          class="mr-2 inline h-6 w-6"
        ></CheckIcon>
        {{ buttonTextGenerator }}
      </button>
    </div>
  </ValidationForm>
</template>

<script>
import { Form as ValidationForm, Field, ErrorMessage } from 'vee-validate';
import { mapWritableState } from 'pinia';
import { ExclamationTriangleIcon, CheckIcon } from '@heroicons/vue/24/outline';
import { useInviteStore } from '@/stores/useInviteStore';

export default {
  components: {
    ValidationForm,
    Field,
    ErrorMessage,
    ExclamationTriangleIcon,
    CheckIcon,
  },
  data() {
    return {
      emails: [],
      error: '',
      inputValue: '',
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
    };
  },
  computed: {
    buttonTextGenerator() {
      return this.isSuccessfullySent === 'pending'
        ? 'Sending...'
        : this.isSuccessfullySent === 'yes'
          ? 'Sent'
          : this.isSuccessfullySent === 'no'
            ? 'Failed'
            : 'Send';
    },
    errorShowing() {
      if (this.showInviteError) {
        return 'This email is already has a pending invite';
      } if (this.showEmailError) {
        return 'This email is already signed up';
      }
      return '';
    },
    emailData() {
      const formData = new FormData();
      for (let i = 0; i < this.emails.length; i++) {
        formData.append(`emails[${i}]`, this.emails[i]);
      }
      return formData;
    },
    ...mapWritableState(useInviteStore, ['invite_from', 'invites']),
    disabledCalculator() {
      if (this.isSent) {
        return true;
      } if (this.emails.length === 0) {
        return true;
      }
      const checkIfExists = this.mainEmailsArray.find(
        (element) => element.existsInInvites === true || element.existsInUsers === true,
      );
      return !!checkIfExists;
    },
    axiosResponseGenerator() {
      const text = this.isSuccessfullySent;
      if (text === 'pending') {
        return 'Please wait, we are sending invites.';
      } if (text === 'yes') {
        return 'Invites send successfully!';
      } if (text === 'no') {
        return 'Could not send invites at the moment, please try again later, or text to support.';
      }
    },
  },
  methods: {
    addTag(event) {
      const regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

      if (event.code === 'Comma' || event.code === 'Enter') {
        event.preventDefault();
        const emailTag = event.target.value.trim().toLowerCase();
        if (emailTag.length > 0) {
          if (this.emails.includes(emailTag)) {
            return;
          }
          if (!regexEmail.test(emailTag)) {
            return;
          } this.emails.push(emailTag[0] + emailTag.slice(1).split(' ')[0]);
          this.mainEmailsArray = this.emails.reduce((element, current) => {
            const includesInviteEmail = this.existedInviteEmails.includes(current);
            const includesUserEmail = this.existedUserEmails.includes(current);
            const newValue = {
              email: current,
              existsInInvites: includesInviteEmail,
              existsInUsers: includesUserEmail,
            };
            return [...element, newValue];
          }, []);
          event.target.value = '';
        }
      }
    },
    pasteTags(event) {
      setTimeout(() => {
        this.emailsPaste = this.inputValue.replaceAll(',', '').split(' ');
        if (this.mainEmailsArray.includes(this.emailsPaste)) {
          return;
        }
        this.emails = this.emails.concat(this.emailsPaste);

        this.mainEmailsArray = this.emails.reduce((element, current) => {
          const includesInviteEmail = this.existedInviteEmails.includes(current);
          const includesUserEmail = this.existedUserEmails.includes(current);
          const newValue = {
            email: current,
            existsInInvites: includesInviteEmail,
            existsInUsers: includesUserEmail,
          };
          return [...element, newValue];
        }, []);

        event.target.value = '';
      }, 50);
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
        document.getElementById('form').reset();
      }, 5);
    },
    onSubmit() {
      this.isSent = true;
      this.mainEmailsArray = [];
      this.isSuccessfullySent = 'pending';
      axios
        .post('/api/school/send-invite', this.emailData, {
          headers: {
            'Content-Type': 'multipart/form-formData',
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
          this.isSuccessfullySent = 'no';
          this.emails = [];
        })
        .finally(() => setTimeout(() => {
          this.isSent = false;
          this.isSuccessfullySent = null;
        }, 5000));
    },
    handleUpdateInvitesTableRequest() {
      axios
        .get(`/api/school/${this.invite_from}/invites?page=${this.currentPage}`)
        .then((res) => {
          this.currentPage++;
          this.lastPage = res.data.meta.last_page;
          this.invites = res.data.data;
          this.invites.map((item) => {
            item.created_at = item.created_at
              .substring(0, 16)
              .replaceAll('T', ' ');
            item.updated_at = item.updated_at
              .substring(0, 16)
              .replaceAll('T', ' ');
          });
        })
        .finally(() => {
          this.invite_from = this.schoolId;
        });
    },
    handleGetInviteEmailsRequest() {
      axios
        .get(`/api/school/${this.invite_from}/invite-emails`)
        .then((res) => {
          this.existedInviteEmails = res.data;
        })
        .catch((err) => console.log(err));
    },
    handleGetUserEmailsRequest() {
      axios
        .get(`/api/school/${this.invite_from}/user-emails`)
        .then((res) => {
          this.existedUserEmails = res.data;
        })
        .catch((err) => console.log(err));
    },
  },
  created() {
    window.addEventListener('paste', this.resetOnPaste);
    this.handleGetInviteEmailsRequest();
    this.handleGetUserEmailsRequest();
  },
};
</script>

<style src="@vueform/multiselect/themes/default.css" />
<style>
body {
  --ms-bg: transparent;
  --ms-tag-bg: #6c757d;
  --ms-border-color: #6c757d;
}
</style>
