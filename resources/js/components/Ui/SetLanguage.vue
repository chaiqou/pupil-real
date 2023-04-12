<template>
    <label for="language" class="sr-only">Country</label>
    <select v-model="language" @change="storeLocaleInLocalStorage(language); setLocale()" required id="language" name="language" autocomplete="language" class="rounded-md relative block w-full appearance-none border border-gray-300 pr-8 pl-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" >
        <option value="en">{{$t('message.english')}}</option>
        <option value="hu">{{$t('message.hungary')}}</option>
    </select>
</template>
<script>
import {mapActions, mapWritableState} from "pinia";
import {useGlobalStore} from "@/stores/useGlobalStore";
import {setLocale as setVeeValidateLocale} from "@vee-validate/i18n";
export default {
    computed: {
      ...mapWritableState(useGlobalStore, ["language"])
    },
    props: {
        user: {
            type: Object,
            required: true
        }
    },
    methods: {
        ...mapActions(useGlobalStore, ["storeLocaleInLocalStorage"]),
        setLocale() {
            this.$i18n.locale = this.language;
            setVeeValidateLocale(this.language);
            this.handleChangeLanguageRequest();
        },
       handleChangeLanguageRequest() {
        axios.get(`/api/${this.user.id}/set-language/${this.language}`)
            .then((res) => {
                console.log(res.data);
            })
            .catch((err) => console.log(err))
       }
    },

    mounted() {
        setVeeValidateLocale(localStorage.getItem("i18n") || 'en');
    }
}
</script>
