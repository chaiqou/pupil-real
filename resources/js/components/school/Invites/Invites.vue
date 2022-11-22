<template>
    <div
        @scroll="onScroll"
        :class="
            this.isInvitesLoaded && this.invites
                ? 'overflow-hidden max-h-[19rem] overflow-y-scroll shadow ring-1 ring-black ring-opacity-5 md:rounded-lg'
                : 'overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg'
        "
    >
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th
                        scope="col"
                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                    >
                        Email
                    </th>
                    <th
                        scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                    >
                        State
                    </th>
                    <th
                        scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                    >
                        Send date
                    </th>
                    <th
                        scope="col"
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                    >
                        Update date
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-if="this.isInvitesLoaded && !this.invites.length">
                    <td class="bg-white" colspan="4">
                        <InvitesNotFound role="school"></InvitesNotFound>
                    </td>
                </tr>
                <tr
                    v-if="this.isInvitesLoaded && this.invites.length"
                    v-for="invite in invites"
                    :key="invite.id"
                >
                    <td
                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                    >
                        {{ invite.email }}
                    </td>
                    <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                    >
                        {{ invite.state }}
                    </td>
                    <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                    >
                        {{ invite.created_at }}
                    </td>
                    <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                    >
                        {{ invite.updated_at }}
                    </td>
                </tr>
                <tr v-if="!this.isInvitesLoaded" v-for="n in 7">
                    <td
                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                    >
                        <div
                            class="h-2 bg-slate-300 rounded animate-pulse"
                        ></div>
                    </td>
                    <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                    >
                        <div
                            class="h-2 bg-slate-300 rounded animate-pulse"
                        ></div>
                    </td>
                    <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                    >
                        <div
                            class="h-2 bg-slate-300 rounded animate-pulse"
                        ></div>
                    </td>
                    <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                    >
                        <div
                            class="h-2 bg-slate-300 rounded animate-pulse"
                        ></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { mapWritableState } from "pinia";
import { useInviteStore } from "../../../stores/useInviteStore";
import InvitesNotFound from "@/components/not-found/InvitesNotFound.vue";
export default {
    components: {
        InvitesNotFound,
    },
    data() {
        return {
            currentPage: 1,
            lastPage: 2,
        };
    },
    props: {
        schoolId: {
            type: Number,
            required: true,
        },
    },
    computed: {
        ...mapWritableState(useInviteStore, [
            "isInvitesLoaded",
            "invites",
            "invite_from",
        ]),
    },
    methods: {
        handleGetInvitesRequest() {
            axios
                .get(
                    `/api/school/${this.schoolId}/invites?page=${this.currentPage}`
                )
                .then((res) => {
                    this.currentPage++;
                    this.lastPage = res.data.meta.last_page;
                    this.invites.push(...res.data.data);
                    this.invites.map((item) => {
                        item.created_at = item.created_at
                            .substring(0, 16)
                            .replaceAll("T", " ");
                        item.updated_at = item.updated_at
                            .substring(0, 16)
                            .replaceAll("T", " ");
                    });
                })
                .finally(() => {
                    this.isInvitesLoaded = true;
                });
        },
        onScroll({ target: { scrollTop, clientHeight, scrollHeight } }) {
            if (scrollTop + clientHeight >= scrollHeight) {
                if (this.currentPage > this.lastPage) {
                    return;
                }
                this.handleGetInvitesRequest();
            }
        },
    },
    created() {
        this.invite_from = this.schoolId;
        this.handleGetInvitesRequest();
    },
};
</script>
