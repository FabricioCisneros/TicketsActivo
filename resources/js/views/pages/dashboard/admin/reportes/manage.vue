<template>
    <div class="bg-white flex-1 relative" >
        <loading :status="loading.form"/>
        <div class="flex relative">
            <div :style="{height: 'calc(100vh - 70px)'}" class="flex-auto min-w-0">
                
                <div class="w-full h:auto sm:h-14 border-b sm:px-3">
                    <div class="sm:flex sm:justify-between">
                        <div class="flex">
                            <button class="btn p-4 rounded-none" type="button" @click="$router.push('/dashboard/admin/reportes')">
                                <svg-vue class="h-5 w-5 text-gray-700" icon="font-awesome.chevron-left-regular"></svg-vue>
                            </button>
                             <button v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.DeleteTicketController']"
                            class="btn p-4 rounded-none" title="Eliminar ticket" type="button" @click="deleteTicketModal = true">
                                <svg-vue class="h-5 w-5 text-gray-700" icon="font-awesome.trash-alt-regular"></svg-vue>
                            </button> 
                        </div>
                        <div class="flex items-center justify-end m-3 sm:m-0">
                            <div class="text-2xl font-semibold">Id de reporte: {{ticket.id}}</div>
                            <div class="px-3">
                                <!-- <div class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-blue-100 text-blue-800">
                                    <router-link
                                    :to="'/dashboard/tickets/' + ticket.ticket.uuid + '/manage'"
                                    class="cursor-pointer hover:bg-gray-100"
                                >
                                Ir al ticket
                                </router-link>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-2xl font-semibold ml-4"> {{ticket.tituloReporte}}</div>
                <div class="ticket-conversation">
                    <div class="block">
                       <div class="text-xl ml-5">{{ticket.razonReporte}}</div>
                    </div>
                    <div class="block">
                        <template v-if="ticket.ticket.ticketReplies.length > 0">
                            <div class="block">
                                <template v-for="(ticketReply, index) in ticket.ticket.ticketReplies">
                                    <div :class="{'border-t' : index > 0}" class="flex p-6">
                                        <img
                                            :alt="$t('Avatar')"
                                            :src="ticketReply.user.avatar !== 'gravatar' ? ticketReply.user.avatar : ticketReply.user.gravatar"
                                            class="h-12 w-12 hidden sm:inline"
                                        />
                                        <div class="sm:pl-6 pb-2 w-full">
                                            <div class="md:flex md:items-center pb-1">
                                                <div class="md:flex-1 text-lg font-semibold text-gray-800">
                                                    {{ ticketReply.user.name }}
                                                </div>
                                                <div class="md:flex-1">
                                                    <div class="md:float-right text-sm">
                                                        {{ ticketReply.created_at | momentFormatDateTime }}
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-gray-700 ticket-reply-body" v-html="ticketReply.body"/>
                                            <template v-if="ticketReply.attachments.length > 0">
                                                <div class="mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2">
                                                    <template v-for="attachment in ticketReply.attachments">
                                                        <attachment :details="attachment" :remove-button="false"/>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                        <template v-else>
                            <div class="h-full flex border-t">
                                <div class="m-auto">
                                    <div class="grid grid-cols-1 justify-items-center h-full w-full py-24">
                                        <div class="flex justify-center items-center">
                                            <svg-vue class="h-full h-auto w-48 mb-6" icon="undraw.task-list"></svg-vue>
                                        </div>
                                        <div class="flex justify-center items-center">
                                            <div class="w-full font-semibold text-2xl">{{ $t('This ticket has no conversations') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div :style="{flex: '0 0 240px', width: '240px'}" class="bg-gray-100 hidden lg:block border-l">
                <div v-if="ticket.user" class="p-6">
                    <h2><b>usuario que levanto el reporte</b></h2><br>
                    <div class="flex">
                        <img
                            :alt="$t('Avatar')"
                            :src="ticket.user.avatar !== 'gravatar' ? ticket.user.avatar : ticket.user.gravatar"
                            class="h-16 w-16"
                        />
                    </div>
                    <div class="mt-2">

                        <div class="text-gray-800 font-medium truncate">{{ ticket.user.name }}</div>
                        <div class="flex items-center text-sm leading-5 text-gray-600">
                            <svg-vue class="flex-shrink-0 mr-1.5 h-4 w-4" icon="font-awesome.envelope-solid"></svg-vue>
                            <span class="truncate">{{ ticket.user.email }}</span>
                        </div>
                    </div>
                </div>
                <div class="border-b-2 border-gray-300"></div>
                <div v-if="ticket.reportedBy" class="p-6">
                    <h2><b>usuario que levanto el ticket</b></h2><br>
                    <div class="flex">
                        <img
                            :alt="$t('Avatar')"
                            :src="ticket.reportedBy.avatar !== 'gravatar' ? ticket.reportedBy.avatar : ticket.reportedBy.gravatar"
                            class="h-16 w-16"
                        />
                    </div>
                    <div class="mt-2">

                        <div class="text-gray-800 font-medium truncate">{{ ticket.reportedBy.name }}</div>
                        <div class="flex items-center text-sm leading-5 text-gray-600">
                            <svg-vue class="flex-shrink-0 mr-1.5 h-4 w-4" icon="font-awesome.envelope-solid"></svg-vue>
                            <span class="truncate">{{ ticket.reportedBy.email }}</span>
                        </div>
                    </div>
                </div>
                <div class="border-b-2 border-gray-300"></div>
                <div v-if="ticket.agent" class="p-6">
                    <h2><b>agente que atendio el ticket</b></h2><br>
                    <div class="flex">
                        <img
                            :alt="$t('Avatar')"
                            :src="ticket.agent.avatar !== 'gravatar' ? ticket.agent.avatar : ticket.agent.gravatar"
                            class="h-16 w-16"
                        />
                    </div>
                    <div class="mt-2">

                        <div class="text-gray-800 font-medium truncate">{{ ticket.agent.name }}</div>
                        <div class="flex items-center text-sm leading-5 text-gray-600">
                            <svg-vue class="flex-shrink-0 mr-1.5 h-4 w-4" icon="font-awesome.envelope-solid"></svg-vue>
                            <span class="truncate">{{ ticket.agent.email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
import {mixin as clickaway} from "vue-clickaway";
//const userId = window.Laravel.apiToken;

export default {
   
    name: "manage",
    mixins: [clickaway],
    metaInfo() {
        return {
            title: this.$i18n.t('Manage ticket')
        }
    },
    mounted() {
        this.getReport();
        //const userId = Auth.user.id;
        //console.log(Auth.user);
        
    },
    data() {
        return {
            loading: {
                form: true,
                reply: false,
                file: false,
                
            },
            replyForm: false,        
            ticket: {
            },
        }
    },
    filters: {
        momentFormatDateTime: function (value) {
            return moment(value).locale(window.app.app_date_locale).format(window.app.app_date_format + ' HH:mm');
        },
        momentFormatDateTimeAgo: function (value) {
            return moment(value).locale(window.app.app_date_locale).fromNow();
        },
    },
    methods: {
        
        // getTicket() {
        //     const self = this;
        //     self.loading.form = true;
        //     axios.get('api/dashboard/admin/reportes/' + self.$route.params.uuid).then(function (response) {
        //         self.loading.form = false;
        //         self.ticket = response.data;
        //         self.ticketReply.status_id = response.data.status_id;
        //     }).catch(function () {
        //         self.$router.push('/dashboard/admin/reportes');
        //     });
        // },
        getReport() {
            const self = this;
            self.loading.form = true;
            
            axios.get('api/dashboard/admin/ReportTicket/' + self.$route.params.uuid).then(function (response) {
                console.log(response.data)
                self.loading.form = false;
                self.ticket = response.data;
            }).catch(function () {
                console.log('datos',self.$route.params.uuid)
                self.$router.push('/dashboard/admin/reportes');
            });
        },

    }
}
</script>
