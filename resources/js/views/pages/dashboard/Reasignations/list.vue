<template>
    <div class="relative flex-1">
        <div class="bg-white border-b border-gray-200 py-6 sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Historico de reasignaciones') }}</h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    
                    <div class="rounded-md shadow-sm mr-4">
                  
                        <div v-show="filtersSidebar" class="fixed inset-0 overflow-hidden z-30">
                            <div class="absolute inset-0 overflow-hidden">
                                <section v-on-clickaway="closeFiltersSidebar" :style="{top: '65px'}" class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                                    <transition
                                        duration="500"
                                        enter-active-class="transform transition ease-in-out duration-500"
                                        enter-class="translate-x-full"
                                        enter-to-class="translate-x-0"
                                        leave-active-class="transform transition ease-in-out duration-500"
                                        leave-class="translate-x-0"
                                        leave-to-class="translate-x-full"
                                    >
                                        <div v-show="filtersSidebar" class="w-screen max-w-xs">
                                            <div class="h-full flex flex-col space-y-4 bg-white shadow-xl">
                                                <header class="px-4 pt-4 sm:px-6">
                                                    <div class="flex items-start justify-between space-x-3">
                                                        <h2 class="text-lg leading-7 font-medium text-gray-900">
                                                            {{ $t('filtros') }}
                                                        </h2>
                                                        <div class="h-7 flex items-center">
                                                            <button aria-label="Close panel" class="text-gray-400 hover:text-gray-500 transition ease-in-out duration-150" type="button" @click="closeFiltersSidebar">
                                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </header>
                                                <div class="relative flex-1 px-4 sm:px-6 h-full border-t overflow-y-scroll">
                                                    <div class="absolute inset-0 px-4 sm:px-6">
                                                        <div class="grid grid-cols-3 py-3">
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('buscar') }}
                                                                </label>
                                                                <div class="relative flex-grow focus-within:z-10">
                                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                        <svg-vue class="h-4 w-4 text-gray-400" icon="font-awesome.search-regular"></svg-vue>
                                                                    </div>
                                                                    <!-- <input
                                                                        id="search"
                                                                        v-model.lazy="filters.search"
                                                                        :placeholder="$t('buscar')"
                                                                        aria-label="Search"
                                                                        class="form-input block w-full rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                                                        @change="getTickets"
                                                                    > -->
                                                                </div>
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Usuario que reasigno el ticket') }}
                                                                </label>
                                                                <div class="relative flex-grow focus-within:z-10">
                                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                        <svg-vue class="h-5 w-5 text-gray-400" icon="font-awesome.users-regular"></svg-vue>
                                                                    </div>
                                                                    <!-- <input
                                                                        id="user"
                                                                        v-model.lazy="filters.user"
                                                                        :placeholder="$t('ticket reasignado por')"
                                                                        aria-label="User"
                                                                        class="form-input block w-full rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                                                        @change="getTickets"
                                                                    > -->
                                                                </div>
                                                                
                                                            </div>

                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Usuario que levanto el ticket') }}
                                                                </label>
                                                                <div class="relative flex-grow focus-within:z-10">
                                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                        <svg-vue class="h-5 w-5 text-gray-400" icon="font-awesome.users-regular"></svg-vue>
                                                                    </div>
                                                                    <!-- <input
                                                                        id="user"
                                                                        v-model.lazy="filters.user"
                                                                        :placeholder="$t('ticket levantado por:')"
                                                                        aria-label="User"
                                                                        class="form-input block w-full rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                                                        @change="getTickets"
                                                                    > -->
                                                                </div>
                                                                
                                                            </div>

                                                            <div v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.FilterController']"
                                                            class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('departamento de procedencia') }}
                                                                </label>
                                                            </div>
                                                            
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('departamento actual') }}
                                                                </label>
                                                            
                                                            </div>
                                                            
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Ordenar') }}
                                                                </label>
                                                                <div class="relative inline-flex w-full">
                                                                    <button
                                                                        class="relative -ml-px inline-flex items-center px-4 py-2 rounded-l-md border border-gray-400 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700"
                                                                        type="button"
                                                                        @click="changeSort"
                                                                    >
                                                                        <svg-vue
                                                                            v-show="sort.order === 'asc'"
                                                                            class="h-5 w-5 text-gray-400"
                                                                            icon="font-awesome.sort-amount-down-alt-regular"
                                                                        />
                                                                        <svg-vue
                                                                            v-show="sort.order === 'desc'"
                                                                            class="h-5 w-5 text-gray-400"
                                                                            icon="font-awesome.sort-amount-up-alt-regular"
                                                                        />
                                                                        <span class="ml-2">{{ $t('Ordenar') }}</span>
                                                                    </button>
                                                                    <select
                                                                        id="sort.column"
                                                                        v-model="sort.column"
                                                                        aria-label="Sort by"
                                                                        class="-ml-px block form-select w-full pl-3 pr-9 py-2 rounded-l-none rounded-r-md border border-gray-400 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                                                        @change="changeSort"
                                                                    >
                                                                        <option value="user_reassign">{{ $t('Usuario que reasigno') }}</option>
                                                                        <option value="user_lift">{{ $t('Usuario que levanto el ticket') }}</option>
                                                                        <option value="source_dp">{{ $t('departamento de procedencia') }}</option>
                                                                        <option value="current_dp">{{ $t('Departamento actual') }}</option>
                                                                        <option value="reason">{{ $t('Razon') }}</option>
                                                                        <option value="created_at">{{ $t('Fecha de creacion') }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Items por pagina') }}
                                                                </label>
                                                                <!-- <input-select
                                                                    id="per_page"
                                                                    v-model="perPage"
                                                                    :options="[{id: 5, name: 5}, {id: 10, name: 10}, {id: 25, name: 25}, {id: 50, name: 50}]"
                                                                    option-label="name"
                                                                    required
                                                                    @change="getTickets"
                                                                /> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </transition>
                                </section>
                            </div>
                        </div>
                    </div>
                    <!-- <button
                        type="button"
                        class="rounded-md border border-gray-400 px-3 py-2 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150"
                        @click="getTickets"
                    >
                        <svg-vue class="w-4 h-4" icon="font-awesome.sync-regular"></svg-vue>
                    </button> -->
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
                                    {{ $t('Ticket reasignador por') }}
                                </th>
                                <th class="hidden lg:table-cell px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                                    {{ $t('Ticket levantador por') }}
                                </th>
                                <th class="hidden lg:table-cell px-5 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                                    {{ $t('razon') }}
                                </th>
                                <th class="hidden md:table-cell px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                                    {{ $t('departamento de procedencia') }}
                                </th>
                                <th class="hidden md:table-cell px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                                    {{ $t('departamento actual') }}
                                </th>
                                <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                    {{ $t('fecha de reasignacion') }}
                                </th>
                            </tr>
                            </thead> 
                            <tbody>
                                <template v-for="ticket in ticketList">
                                    <router-link
                                    to="/dashboard/Reasignations"
                                    class="cursor-pointer hover:bg-gray-100"
                                    tag="tr"
                                     >
                                          <td class="hidden lg:table-cell px-3 py-4 whitespace-no-wrap leading-5">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm leading-5 font-medium text-gray-900">
                                                    {{ ticket.reassignedBy.name }}
                                                </div>
                                                <div class="text-sm leading-5 text-gray-500">
                                                    {{ ticket.reassignedBy.email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                        <td class="hidden lg:table-cell px-3 py-4 whitespace-no-wrap leading-5">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm leading-5 font-medium text-gray-900">
                                                    {{ ticket.liftedBy.name }}
                                                </div>
                                                <div class="text-sm leading-5 text-gray-500">
                                                    {{ ticket.liftedBy.email }}
                                                </div>
                                            </div>
                                        </div>
                                        </td>
                                        <td class="px-3 py-4 max-w-0 w-full whitespace-no-wrap">
                                            <div class="flex text-sm leading-5 text-gray-900">
                                                        {{ ticket.description }}
                                                    
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                            {{ticket.sourceDepartmen.name}}
                                        </td>
                                        <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                            {{ticket.destinationDepartment.name}}
                                        </td>
                                        <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                            {{ticket.created_at.substring(0,10)}}
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
                            <template v-if="anyFilter">
                                <div class="flex justify-center items-center">
                                    <div>{{ $t('Try changing the filters, or rephrasing your search') }}.</div>
                                </div>
                            </template>
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

            filters:{
                search: '',
                ReassignedBy:'',
                liftedBy:'',
                sourceDepartment: '',
                destinationDepartment:'',
                ticket:'',
                
            },
            sort: {
                order: 'desc',
                column: 'created_at',
            },
            page: 1,
            perPage: 10,
            pagination: {
                currentPage: 0,
                perPage: 0,
                total: 0,
                totalPages: 0
            },
            ticketList:[],
            tickets: []
        }
    },
    computed: {
    },
    filters: {
        momentFormatDateTimeAgo: function (value) {
            return moment(value).locale(window.app.app_date_locale).fromNow();
        },
    },
    mounted() {
        this.getTickets();
        //this.getFilters();

 
    },
    methods: {
        openFiltersSidebar() {
            const self = this;
            
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
            axios.get('api/dashboard/RDtickets/list', {
                params: {
                    page: self.page,
                    sort: self.sort,
                    perPage: self.perPage,
                    search: self.filters.search,
                    sourceDepartment: self.sourceDepartment,
                    destinationDepartment:self.destinationDepartment,
                    ReassignedBy:self.ReassignedBy,
                }
            }).then(function (response) {
                
                self.ticketList = response.data.items;
                self.pagination = response.data.pagination;
                //console.log(self.ticketList);
                
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
        getFilters() {
            const self = this;
            axios.get('api/dashboard/tickets/filters').then(function (response) {
                self.agentList = response.data.agents;
                self.departmentList = response.data.departments;
                self.labelList = response.data.labels;
                self.statusList = response.data.statuses;
                self.priorityList = response.data.priorities;
            });
        },
        },

    
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
 