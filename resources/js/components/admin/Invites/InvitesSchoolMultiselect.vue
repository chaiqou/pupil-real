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
            @change="add"
        ></Multiselect>
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
            value: []
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
           this.schools = res.data
       })
       .catch((err) => console.log(err))
        },

        add(value) {
           this.value = value
            this.chosenSchool = this.value;
           console.log(this.chosenSchool);
        },
     },
    created() {
        this.handleGetSchoolsRequest();
    }
}


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
