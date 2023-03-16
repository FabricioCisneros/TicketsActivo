<template>
    <div class="relative flex-1">
        <div class="bg-white border-b border-gray-200 py-6 sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Tickets con reportes') }}</h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <button
                        type="button"
                        class="rounded-md border border-gray-400 px-3 py-2 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150"
                        @click="getTickets"
                    >
                        <svg-vue class="w-4 h-4" icon="font-awesome.sync-regular"></svg-vue>
                    </button>
                </div>
            </div>
        </div>
        <loading :status="loading"/>
        <div class="tickets-list">
            <template v-if="ticketList.length > 0"> 
                <div class="hidden sm:block">
                    <div class="align-middle inline-block min-w-full border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                            <tr>
                                <th class="hidden lg:table-cell px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                                    {{ $t('Usuario que reporto') }}
                                </th>
                                <th class="hidden lg:table-cell px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                                    {{ $t('Usuario que levanto el ticket') }}
                                </th>
                                <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto" >
                                    {{ $t('Informacion del ticket') }}
                                </th>
                                <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                    {{ $t('titulo del reporte') }}
                                </th>
                                <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                    {{ $t('Ultima Actualizacion') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                            <template v-for="ticket in ticketList">
                                <router-link
                                    :to="'/dashboard/admin/reportes/' + ticket.uuid + '/manage'"
                                    class="cursor-pointer hover:bg-gray-100"
                                    tag="tr"
                                >
                                <td class="hidden lg:table-cell px-3 py-4 whitespace-no-wrap leading-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img
                                                :alt="$t('Avatar')"
                                                :src="ticket.reportedBy.avatar !== 'gravatar' ? ticket.reportedBy.avatar : ticket.reportedBy.gravatar"
                                                class="h-10 w-10 rounded-full"
                                            >
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm leading-5 font-medium text-gray-900">
                                                {{ ticket.reportedBy.name }}
                                            </div>
                                            <div class="text-sm leading-5 text-gray-500">
                                                {{ ticket.reportedBy.email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden lg:table-cell px-3 py-4 whitespace-no-wrap leading-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img
                                            :alt="$t('Avatar')"
                                            v-if="ticket.user && ticket.user.avatar !== 'gravatar'"
                                            :src="ticket.user.avatar"
                                            class="h-10 w-10 rounded-full"
                                        >
                                        <img
                                            :alt="$t('Avatar')"
                                            v-else-if="ticket.user && ticket.user.avatar === 'gravatar'"
                                            :src="ticket.user.gravatar"
                                            class="h-10 w-10 rounded-full"
                                        >
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm leading-5 font-medium text-gray-900">
                                                {{ ticket.user ? ticket.user.name : 'No hay agente al que se asigno' }}
                                            </div>
                                            <div class="text-sm leading-5 text-gray-500">
                                                {{ ticket.user ? ticket.user.email : '' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                    <td class="hidden lg:table-cell px-3 py-4 whitespace-no-wrap leading-5">
                                        <div class="flex items-center">
                                            <div class="w-full truncate">
                                                {{ ticket.ticket.subject }}
                                            </div>
                                        </div>
                                        <div class="text-sm leading-5 text-gray-500 w-full truncate">
                                            {{ ticket.ticket.ticketReplies ? ticket.ticket.ticketReplies.body : null }}
                                        </div>
                                    </td>
                                    <td class="hidden lg:table-cell px-3 py-4 whitespace-no-wrap leading-5">
                                        <div class="flex items-center">
                                            <div class="w-full truncate">
                                                {{ ticket.tituloReporte }}
                                            </div>
                                        </div>
                                        <div class="text-sm leading-5 text-gray-500 w-full truncate">
                                            {{ ticket.razonReporte}}
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                        <div class="text-sm text-gray-500">
                                            {{ ticket.updated_at | momentFormatDateTimeAgo }}
                                        </div>
                                    </td>
                                </router-link>
                            </template>
                            </tbody> 
                        </table> 
                    </div>
                </div>
            </template>
             <template v-else-if="!loading">
                <div class="h-full flex">
                    <div class="m-auto">
                        <div class="grid grid-cols-1 justify-items-center h-full w-full p-4">
                            <div class="flex justify-center items-center">
                                <svg-vue class="h-full h-auto w-48 mb-6" icon="undraw.task-list"></svg-vue>
                            </div>
                            <div class="flex justify-center items-center">
                                <div class="w-full font-semibold text-2xl">{{ $t('No records found') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </template> 
        </div>
         <nav class="bg-white absolute bottom-0 left-0 w-full px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="hidden sm:block">
                <p class="text-sm leading-5 text-gray-700">
                    {{ $t('Showing') }}
                    <span class="font-medium">{{ (pagination.perPage * pagination.currentPage) - pagination.perPage + 1 }}</span>
                    {{ $t('to') }}
                    <span class="font-medium">{{ pagination.perPage * pagination.currentPage <= pagination.total ? pagination.perPage * pagination.currentPage : pagination.total }}</span>
                    {{ $t('of') }}
                    <span class="font-medium">{{ pagination.total }}</span>
                    {{ $t('results') }}
                </p>
            </div>
            <div class="flex-1 flex justify-between sm:justify-end">
                <button
                    :class="pagination.currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : ''"
                    :disabled="pagination.currentPage <= 1"
                    class="pagination-link"
                    type="button"
                    @click="changePage(pagination.currentPage - 1)"
                >
                    {{ $t('Previous') }}
                </button>
                <button
                    :class="pagination.currentPage >= pagination.totalPages ? 'opacity-50 cursor-not-allowed' : ''"
                    :disabled="pagination.currentPage >= pagination.totalPages"
                    class="ml-3 pagination-link"
                    type="button"
                    @click="changePage(pagination.currentPage + 1)"
                >
                    {{ $t('Next') }}
                </button>
            </div>
        </nav> 
    </div>
</template>

<script>
import {mixin as clickaway} from "vue-clickaway";

export default {
    name: "list",
    metaInfo() {
        return {
            title: this.$i18n.t('Tickets')
        }
    },
    mixins: [clickaway],
    data() {
        return {
            loading: true,
            filtersSidebar: false,
            userId:'',
            filters: {
                search: '',
                user: '',
                userReport:'',
                agents: [],
                departments: [],
                ticket:'',

            },
            sort: {
                order: 'desc',
                column: 'updated_at',
            },
            page: 1,
            perPage: 10,
            pagination: {
                currentPage: 0,
                perPage: 0,
                total: 0,
                totalPages: 0
            },
            agentList: [],
            departmentList: [],
            labelList: [],
            statusList: [],
            priorityList: [],
            ticketList: [],
        }
    },
    created() {
    
    const token = localStorage.getItem('token');

    if (token) {
      axios.get('/api/auth/user', {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      })
        .then((response) => {
          this.userId = response.data.role_id;
          //console.log(this.userId);
        })
        .catch((error) => {
          console.log(error);
        });
    }
  },
    filters: {
        momentFormatDateTimeAgo: function (value) {
            return moment(value).locale(window.app.app_date_locale).fromNow();
        },
    },
    mounted() {
        this.getTickets();
        // this.getFilters();
        
    },
    methods: {
        openFiltersSidebar() {
            const self = this;
            self.selectedRows = [];
            self.selectTicket();
            setTimeout(function () {
                self.filtersSidebar = true;
            }, 100);
        },
        closeFiltersSidebar() {
            this.filtersSidebar = false;
        },
        changePage(page) {
            const self = this;
            if ((page > 0) && (page <= self.pagination.totalPages) && (page !== self.page)) {
                self.page = page;
                self.getTickets();
            }
        },
        changeSort() {
            const self = this;
            if (self.sort.order === 'asc') {
                self.sort.order = 'desc';
            } else if (self.sort.order === 'desc') {
                self.sort.order = 'asc';
            }
            self.getTickets();
        },
        getTickets() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/admin/ReportTicket', {
                 params: {
                     page: self.page,
                     sort: self.sort,
                     perPage: self.perPage,
                     search: self.filters.search,
                     userReported: self.filters.user,
                     agents: self.filters.agents,
                     departments: self.filters.departments,
                     tickets:self.filters.tickets
                 }
            }).then(function (response) {
                 //console.log(response.data.items);
                self.ticketList = response.data.items;
                console.log(self.ticketList);
                self.pagination = response.data.pagination;
                if (self.pagination.totalPages < self.pagination.currentPage) {
                    self.page = self.pagination.totalPages;
                    self.getTickets();
                } else {
                    self.loading = false;
                    
                 }
                
            }).catch(function () {
                self.loading = false;
            });
        },
    }
}
</script>

<style lang="scss">
.tickets-list {
    @apply bg-white w-full z-0 overflow-y-auto;
    height: calc(100vh - 270px);
}

@media (min-width: theme('screens.md')) {
    .tickets-list {
        height: calc(100vh - 216px);
    }
}

.filters-options {
    @apply rounded-md bg-white shadow-xs p-3 overflow-y-auto;
    height: calc(100vh - 270px);
    max-height: 360px;
}

@media (min-width: theme('screens.md')) {
    .filters-options {
        height: calc(100vh - 140px)
    }
}

.tickets-list-toolbar {
    @apply bg-white fixed flex rounded-md shadow-lg;
    left: 50px;
}

@media (min-width: theme('screens.md')) {
    .tickets-list-toolbar {
        left: 50%;
    }
}
</style>
