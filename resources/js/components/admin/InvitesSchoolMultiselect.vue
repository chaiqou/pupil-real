<template>
  <div>
    <label class="text-md mt-10 flex whitespace-normal font-bold text-gray-600"
      >{{ this.label }}
    </label>
    <Multiselect
      mode="tags"
      :options="this.schools"
      :max="1"
      :limit="-1"
      valueProp="id"
      placeholder="Select one"
      track-by="name"
      label="name"
      :searchable="true"
      @change="add"
    ></Multiselect>
  </div>
</template>

<script>
import Multiselect from '@vueform/multiselect';
import { mapWritableState } from 'pinia';
import { useInviteStore } from '@/stores/useInviteStore';

export default {
  components: {
    useInviteStore,
    Multiselect,
  },
  data() {
    return {
      value: [],
    };
  },
  props: {
    name: {
      type: String,
      required: true,
    },
    label: {
      type: String,
      required: true,
    },
  },
  computed: {
    ...mapWritableState(useInviteStore, ['schools', 'chosenSchool']),
  },
  methods: {
    handleGetSchoolsRequest() {
      axios
        .get('/api/admin/schools-for-invites')
        .then((res) => {
          this.schools = res.data;
        })
        .catch((err) => console.log(err));
    },

    add(value) {
      this.value = value;
      this.chosenSchool = this.value;
    },
  },
  created() {
    this.handleGetSchoolsRequest();
  },
};
</script>

<style src="../../../../node_modules/@vueform/multiselect/themes/default.css" />
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
