<template>
    <div class="bg-white flex-1 relative" >
        <loading :status="loading.form"/>
        <div class="flex relative">
            <div :style="{height: 'calc(100vh - 70px)'}" class="flex-auto min-w-0">
                
                <div class="w-full h:auto sm:h-14 border-b sm:px-3">
                    <div class="sm:flex sm:justify-between">
                        <div class="flex">
                            <button class="btn p-4 rounded-none" type="button" @click="$router.push('/dashboard/tickets')">
                                <svg-vue class="h-5 w-5 text-gray-700" icon="font-awesome.chevron-left-regular"></svg-vue>
                            </button>
                             <button v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.DeleteTicketController']"
                            class="btn p-4 rounded-none" title="Eliminar ticket" type="button" @click="deleteTicketModal = true">
                                <svg-vue class="h-5 w-5 text-gray-700" icon="font-awesome.trash-alt-regular"></svg-vue>
                            </button> 
                            <!-- <button v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.DeleteTicketController']"
                            class="btn p-4 rounded-none" title="Eliminar ticket" type="button" @click="assignDepartmentModal = true">
                                <svg-vue class="h-5 w-5 text-gray-700" icon="font-awesome.trash-alt-regular"></svg-vue>
                            </button> -->
                        </div>
                        <div class="flex items-center justify-end m-3 sm:m-0">
                            <div class="text-2xl font-semibold">Id de ticket: {{ticket.id}}</div>
                            <div v-if="ticket.status" class="px-3">
                                <div class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-blue-100 text-blue-800">
                                    Estatus: {{ ticket.status.name }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ticket-conversation">
                    <div class="block">
                        <div class="sm:flex sm:items-center py-3 max-w-full border-b">
                            <div class="px-6 sm:pl-6 sm:pr-3 sm:flex-1 sm:w-3/4">
                                <div class="text-xl truncate">{{ ticket.subject }}</div>
                                <template v-for="(label, index) in ticket.labels">
                                    <div
                                        :style="{backgroundColor: label.color}"
                                        class="inline-flex items-center px-2 py-0.5 mr-1 rounded text-xs font-medium leading-4 text-gray-100"
                                    >
                                        {{ label.name }}
                                        <button class="flex-shrink-0 ml-1.5 inline-flex text-gray-100 focus:outline-none focus:text-gray-100 cursor-pointer" type="button" @click="removeLabel(index)">
                                            <svg-vue class="h-3 w-3" icon="font-awesome.times-solid"></svg-vue>
                                        </button>
                                    </div>
                                </template>
                            </div>
                          
                            <div class="px-6 sm:pl-3 sm:pr-6 sm:flex-1 sm:w-1/4">
                                <div class="flex items-center sm:float-right mt-3 sm:mt-0">
                                    <div class="text-sm sm:pr-2">{{ ticket.created_at | momentFormatDateTimeAgo }}</div>
                                    <button class="flex items-center btn btn-white p-2 ml-3 sm:ml-0" type="button" @click="replyForm = true">
                                        <svg-vue class="h-4 w-4 mr-2" icon="font-awesome.reply-regular"></svg-vue>
                                        {{ $t('Responder') }}
                                    </button>

                                    <router-link
                                    class="flex items-center btn btn-white p-2 ml-3 sm:ml-0" 
                                    to="/dashboard/tickets/new"
                                    >
                                    <svg-vue class="h-4 w-4 mr-2" icon="font-awesome.circle-exclamation-solid"></svg-vue>
                                    {{ $t('reportar') }}
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <div v-show="replyForm" class="px-6 py-3 border-b">
                            <loading :status="loading.reply"/>
                            <form @submit.prevent="addReply">
                                <input-wysiwyg
                                    id="ticket_body"
                                    v-model="ticketReply.body"
                                    :cannedReplyList="cannedReplyList"
                                    :plugins="{images: true, cannedReply: true, attachment: true, shortCode: true}"
                                    @selectUploadFile="selectUploadFile"
                                >
                                    <template v-slot:top>
                                        <div :class="{'bg-gray-200': uploadingFileProgress > 0}" class="h-1 w-full">
                                            <div :style="{width: uploadingFileProgress + '%'}" class="bg-blue-500 py-0.5"></div>
                                        </div>
                                    </template>
                                    <template v-slot:bottom>
                                        <div class="flex justify-between border border-t-0">
                                            <button
                                                class="btn btn-secondary rounded-none"
                                                type="button"
                                                @click="discardReply"
                                            >
                                                {{ $t('Descartar') }}
                                            </button>
                                            
                                            <div class="flex">
                                                <span
                                                    class="btn btn-gray rounded-none"
                                                >
                                                    {{ $t('Estatus:') }}
                                                </span>
                                                <select
                                                    id="status"
                                                    v-model="ticketReply.status_id"
                                                    aria-label="Sort by"
                                                    class="block form-select pl-3 pr-9 py-2 border-l border-r-0 border-t-0 border-b-0 border-gray-400 rounded-none bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                                >
                                                    <template v-for="status in statusList">
                                                        <option :value="status.id">{{ status.name }}</option>
                                                    </template>
                                                </select>
                                                <button
                                                    class="btn btn-green rounded-none"
                                                    type="submit"
                                                >
                                                    {{ $t('Enviar') }}
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </input-wysiwyg>
                            </form>
                            <input ref="fileInput" hidden type="file" @change="uploadFile($event)">
                            <template v-if="ticketReply.attachments.length > 0">
                                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2">
                                    <template v-for="(attachment, index) in ticketReply.attachments">
                                        <attachment :details="attachment" v-on:remove="removeAttachment(index)"/>
                                    </template>
                                </div>
                            </template>
                        </div>
                        <template v-if="ticket.ticketReplies.length > 0">
                            <div class="block">
                                <template v-for="(ticketReply, index) in ticket.ticketReplies">
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
                    <h2><b>Informacion del usuario</b></h2><br>
                    <div class="flex">
                        <img
                            :alt="$t('Avatar')"
                            :src="ticket.user.avatar !== 'gravatar' ? ticket.user.avatar : ticket.user.gravatar"
                            class="h-16 w-16"
                        />
                    </div>
                    <div class="mt-2">
                        <!-- <div class="text-gray-800 font-medium truncate">{{ ticket.department_id }}</div>
                        <div class="text-gray-800 font-medium truncate">{{ ticket.user.id }}</div> -->
                        <div class="text-gray-800 font-medium truncate">{{ ticket.user.name }}</div>
                        <div class="flex items-center text-sm leading-5 text-gray-600">
                            <svg-vue class="flex-shrink-0 mr-1.5 h-4 w-4" icon="font-awesome.envelope-solid"></svg-vue>
                            <span class="truncate">{{ ticket.user.email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-show="deleteTicketModal" class="fixed z-20 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <transition
                    duration="300"
                    enter-active-class="ease-out duration-300"
                    enter-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div v-show="deleteTicketModal" class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                </transition>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
                <transition
                    enter-active-class="ease-out duration-300"
                    enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        v-show="deleteTicketModal"
                        aria-labelledby="modal-headline"
                        aria-modal="true"
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                        role="dialog"
                    >
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg-vue class="h-6 w-6 pb-1 text-red-600" icon="font-awesome.exclamation-triangle-light"></svg-vue>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 id="modal-headline" class="text-lg leading-6 font-medium text-gray-900">
                                        {{ $t('Borrar ticket') }}
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm leading-5 text-gray-500">
                                            {{ $t('Estas seguro de eliminar este ticket?') }}
                                            {{ $t('Todos los datos seran eliminados permamentemente') }}.
                                            {{ $t('Todos los datos relacionados a este ticket (mensajes e informacion) sera eliminada ') }}.
                                            {{ $t('Esta accion no podra reevertirse') }}.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                class="btn btn-red mr-2 sm:mr-0"
                                type="button"
                                @click="deleteTicket"
                            >
                                {{ $t('Borrar ticket') }}
                            </button>
                            <button
                                class="btn btn-white mr-0 sm:mr-2"
                                type="button"
                                @click="deleteTicketModal = false"
                            >
                                {{ $t('Cancelar') }}
                            </button>
                        </div>
                    </div>
                </transition>
            </div>
        </div>


        <div v-show="assignDepartmentModal" class="fixed z-20 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <transition
                    duration="300"
                    enter-active-class="ease-out duration-300"
                    enter-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div v-show="assignDepartmentModal" class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                </transition>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
                <transition
                    enter-active-class="ease-out duration-300"
                    enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        v-show="assignDepartmentModal"
                        aria-labelledby="modal-headline"
                        aria-modal="true"
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                        role="dialog"
                    >

                    <form @submit.prevent="saveComent">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg-vue class="h-6 w-6 pb-1 text-red-600" icon="font-awesome.exclamation-triangle-light"></svg-vue>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 id="modal-headline" class="text-lg leading-6 font-medium text-gray-900">
                                        {{ $t('Asignar ticket a otro departamento') }}
                                    </h3>
                                    <div class="mt-2">
                                        <!-- <p class="text-sm leading-5 text-gray-500">porque se reasignara el ticket al departamento de {{ selectedDepartmentName }}?</p> -->
                                        <p class="text-sm leading-5 text-gray-500">porque se reasignara el ticket al departamento de {{ selectedDepartmentName }}?</p> 
                                        <input type="text" 
                                        v-model="reassingnationDeail.description"  
                                        required class="mt-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" placeholder="Ingrese una raz??n aqu??">

                                        <input type="hidden" 
                                        v-model="reassingnationDeail.reassigned_by_id"  
                                        required class="mt-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"  >

                                        <input type="hidden" 
                                        v-model="reassingnationDeail.currentDepartmentId"  
                                        
                                        class="mt-2 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"  >
                                        
                                        <!-- <p class="text-sm leading-5 text-gray-500">
                                            {{ $t('Porque vas a asignar este ticket al departamento de: ')}}
                                        </p > -->
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                class="btn btn-blue mr-2 sm:mr-0"
                                type="submit"
                                @click.prevent="action('department', selectedDepartmentId, reassingnationDeail.description); saveComent()"
                            > 
                            
                                {{ $t('Asignar ticket') }}
                            </button>
                            <button
                                class="btn btn-white mr-0 sm:mr-2"
                                type="button"
                                @click="assignDepartmentModal = false"
                            >
                                {{ $t('Cancelar') }}
                            </button>
                        </div>
                    </form>
                    </div>
                </transition>
            </div>
        </div>




    </div>
</template>

<script>
import {mixin as clickaway} from "vue-clickaway";
import { Auth } from 'laravel-jetstream';
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
        this.getTicket();
        this.getFilters();
        this.getCannedReplies();
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
            deleteTicketModal: false,
            assignDepartmentModal:false,
            replyForm: false,
            uploadingFileProgress: 0,

            selectedDepartmentId:null,
            selectedDepartmentName: '',
            

            
            reassingnationDeail: {
                reassigned_by_id: null,
                lifted_by_id:null,
                source_department_id: null,
                destination_department_id: null,
                ticket_id: null,
                description: null,
            },

            ticket: {
                subject: null,
                created_at: null,
                department_id:null,
                labels: [],
                ticketReplies: [],
            },
            ticketReply: {
                status_id: null,
                body: '',
                attachments: [],
            },
            actions: {
                agent: false,
                department: false,
                label: false,
                priority: false,
            },
            cannedReplyList: [],
            agentList: [],
            departmentList: [],
            labelList: [],
            statusList: [],
            priorityList: [],
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
          this.reassingnationDeail.reassigned_by_id = response.data.id;
          //console.log(this.userId);
        })
        .catch((error) => {
          console.log(error);
        });
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
        
        getTicket() {
            const self = this;
            self.loading.form = true;
            axios.get('api/dashboard/reportes/' + self.$route.params.uuid).then(function (response) {
                self.loading.form = false;
                self.ticket = response.data;
                self.ticketReply.status_id = response.data.status_id;
            }).catch(function () {
                self.$router.push('/dashboard/tickets');
            });
        },
        getCannedReplies() {
            const self = this;
            axios.get('api/dashboard/tickets/canned-replies').then(function (response) {
                self.cannedReplyList = response.data;
            })
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
        discardReply() {
            this.ticketReply.body = '';
            this.ticketReply.attachments = [];
            this.replyForm = false;
        },
        selectUploadFile() {
            if (!this.loading.file) {
                this.$refs.fileInput.click();
            } else {
                this.$notify({
                    title: this.$i18n.t('Error').toString(),
                    text: this.$i18n.t('A file is being uploaded').toString(),
                    type: 'warning'
                });
            }
        },
        uploadFile(e) {
            const self = this;
            const formData = new FormData();
            self.loading.file = true;
            formData.append('file', e.target.files[0]);
            axios.post(
                'api/dashboard/tickets/attachments',
                formData,
                {
                    headers: {'Content-Type': 'multipart/form-data'},
                    onUploadProgress: function (progressEvent) {
                        self.uploadingFileProgress = Math.round((progressEvent.loaded / progressEvent.total) * 100);
                    }.bind(this)
                }
            ).then(function (response) {
                self.loading.file = false;
                self.uploadingFileProgress = 0;
                self.$refs.fileInput.value = null;
                self.ticketReply.attachments.push(response.data);
            }).catch(function () {
                self.loading.file = false;
                self.uploadingFileProgress = 0;
                self.$refs.fileInput.value = null;
            });
        },
        removeAttachment(attachment) {
            this.ticketReply.attachments.splice(attachment, 1);
        },
        removeLabel(index) {
            const self = this;
            const label = self.ticket.labels[index];
            axios.post('api/dashboard/tickets/' + self.$route.params.uuid + '/remove-label', {
                label: label.id,
            }).then(function () {
                self.ticket.labels.splice(index, 1);
            });
        },
        addReply() {
            const self = this;
            self.loading.reply = true;
            axios.post('api/dashboard/tickets/' + self.$route.params.uuid + '/reply', self.ticketReply).then(function (response) {
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data saved correctly').toString(),
                    type: 'success'
                });
                self.ticket = response.data.ticket;
                self.ticketReply.status_id = response.data.ticket.status_id;
                self.discardReply();
                self.loading.reply = false;
            }).catch(function () {
                self.loading.reply = false;
            });
        },
        closeActionDropdown() {
            this.actions.agent = false;
            this.actions.department = false;
            this.actions.label = false;
            this.actions.priority = false;
        },
        toggleActionDropdown(action) {
            if (action === 'agent') {
                this.actions.agent = !this.actions.agent;
                this.actions.department = false;
                this.actions.label = false;
                this.actions.priority = false;
            }
            if (action === 'department') {
                this.actions.department = !this.actions.department;
                this.actions.agent = false;
                this.actions.label = false;
                this.actions.priority = false;
            }
            if (action === 'label') {
                this.actions.label = !this.actions.label;
                this.actions.agent = false;
                this.actions.department = false;
                this.actions.priority = false;
            }
            if (action === 'priority') {
                this.actions.priority = !this.actions.priority;
                this.actions.agent = false;
                this.actions.department = false;
                this.actions.label = false;
            }
        },
        action(param, value,reason) {
        
            if(param!='department'){
                const self = this;
                axios.post('api/dashboard/tickets/' + self.$route.params.uuid + '/quick-actions', {
                action: param,
                value: value,
                jsonData: this.jsonData,
            }).then(function (response) {
                self.closeActionDropdown();
                if (!response.data.access) {
                    self.$router.push('/dashboard/tickets');
                } else {
                    self.ticket = response.data.ticket;
                    self.ticketReply.status_id = response.data.ticket.status_id;
                    
                }
            }).catch(function () {
                self.closeActionDropdown();
                
            });
            }else{
                const self = this;
            axios.post('api/dashboard/tickets/' + self.$route.params.uuid + '/quick-actions', {
                action: param,
                value: value,
                jsonData: this.jsonData
            }).then(function (response) {
                self.closeActionDropdown();
                if (!response.data.access) {
                    self.$router.push('/dashboard/tickets');
                } else {
                    self.ticket = response.data.ticket;
                    self.ticketReply.status_id = response.data.ticket.status_id;
                    self.assignDepartmentModal = false;
                    
                }
            }).catch(function () {
                self.closeActionDropdown();
                
            });
            }

        },
        saveComent() {
            this.getTicket();
            this.reassingnationDeail.source_department_id = this.ticket.department_id;
            this.reassingnationDeail.ticket_id = this.ticket.id;
            
            const self = this; 
            console.log(self.reassingnationDeail);
            self.loading.form = true;
            axios.post('api/dashboard/RDtickets', self.reassingnationDeail)
            .then(response => {
                console.log(response.data);
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data saved correctly').toString(),
                    type: 'success'
                });
                self.$router.push('/dashboard/tickets/');
            })
            .catch(error => {
                console.log(error.response.data);
            });

            
        },
        openAssignDepartmentModal(id, departmentName) {
            this.selectedDepartmentId = id;
            this.assignDepartmentModal = true;
            
            this.selectedDepartmentName = departmentName;
            this.reassingnationDeail.destination_department_id=this.selectedDepartmentId;
            this.reassingnationDeail.lifted_by_id = this.ticket.user.id;
        },
        deleteTicket() {
            const self = this;
            axios.delete('api/dashboard/tickets/' + self.$route.params.uuid).then(function () {
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data deleted successfully').toString(),
                    type: 'success'
                });
                self.$router.push('/dashboard/tickets');
            }).catch(function () {
                self.deleteTicketModal = false;
            });
        }
    }
}
</script>
