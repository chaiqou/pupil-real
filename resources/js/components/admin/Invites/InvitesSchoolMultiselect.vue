<template>
    <div>
        <label class="text-md flex font-bold text-gray-600 whitespace-normal"
            >{{ this.label }}
        </label>
        <Multiselect
            mode="tags"
            :options="this.schools"
            :max="1"
            :limit="-1"
            valueProp="id"
            placeholder="Select one"
            track-by="id"
            label="name"
            @change="addTag"
        ></Multiselect>
<!--        <span class="mt-2 text-sm text-red-500 whitespace-nowrap">{{-->
<!--          errorMessage-->
<!--        }}</span>-->
    </div>
</template>

<script>
import Multiselect from "@vueform/multiselect";
import { useInviteStore } from '../../../stores/useInviteStore'
import {mapWritableState} from "pinia";

export default {
    components: {
        useInviteStore,
        Multiselect,
    },
    data() {
        return {
            value: [{id: '0', name:'barbara'}]
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
    computed: {
      ...mapWritableState(useInviteStore, ["schools", "chosenSchool"])
    },
    methods: {
        handleGetSchoolsRequest()
        {
               axios
       .get('/api/admin/schools')
       .then((res) => {
           console.log(res.data)
           this.schools = res.data
       })
       .catch((err) => console.log(err))
        },

        addTag (value) {
           this.value = value

            console.log(this.value)
        }
     },
    mounted() {
        this.handleGetSchoolsRequest();
    }
}



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

// function updateSelectedMeal(value) {
//     store.chosenSchool = this.value;
//     console.log(store.chosenSchool);
// }
//
// onBeforeMount(() => {
//    axios
//        .get('/api/admin/schools')
//        .then((res) => {
//            console.log(res.data)
//            store.schools = res.data
//        })
//        .catch((err) => console.log(err))
// });
//
// function required(value) {
//     if (value) {
//         return true;
//     }
//     return "This field is required";
// }
// function nameWithLang ({ name, username }) {
//     return `${name} — [${username}]`
// }
// const nameRef = toRef(props, "name");
// const { errorMessage, value } = useField(nameRef, required);
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
