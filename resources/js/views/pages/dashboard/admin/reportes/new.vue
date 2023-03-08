<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="saveTicket">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('reporte de ticket') }}</h1>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <loading :status="loading.form"/>
                    <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('formulario de reporte de ticket') }}</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                {{ $t('detalles del reporte y pruebas') }}.
                            </p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="subject">{{ $t('nombre del agente') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <span>
                                            {{ ticketDetail.agent ? ticketDetail.agent.name : $t('No asignado   ') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="subject">{{ $t('usuario que levanto el ticket') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <span>
                                            {{ ticketDetail.user ? ticketDetail.user.name : $t('No asignado   ') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="subject">{{ $t('departamento') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                          <span>
                                            {{ ticketDetail.department ? ticketDetail.department.name : $t('No asignado   ') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="subject">{{ $t('asunto') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="subject"
                                            v-model="report.tituloReporte"
                                            :placeholder="$t('titulo del reporte')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="ticket_body">{{ $t('Cuerpo del ticket') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input-wysiwyg
                                            id="ticket_body"
                                            v-model="report.razonReporte"
                                            :cannedReplyList="cannedReplyList"
                                            :plugins="{images: true, cannedReply: true, attachment: true, shortCode: true}"
                                            @selectUploadFile="selectUploadFile"
                                        >
                                            <template v-slot:top>
                                                <div :class="{'bg-gray-200': uploadingFileProgress > 0}" class="h-1 w-full">
                                                    <div :style="{width: uploadingFileProgress + '%'}" class="bg-blue-500 py-0.5"></div>
                                                </div>
                                            </template>
                                        </input-wysiwyg>
                                    </div>
                                </div>
                                <div v-if="report.attachments.length > 0" class="col-span-3">
                                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-2">
                                        <template v-for="(attachment, index) in report.attachments">
                                            <attachment :details="attachment" v-on:remove="removeAttachment(index)"/>
                                        </template>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                        <div class="inline-flex">
                            <router-link
                                class="btn btn-secondary shadow-sm rounded-md mr-4"
                                to="/dashboard/tickets"
                            >
                                {{ $t('Cancelar') }}
                            </router-link>
                            <button
                                class="btn btn-green shadow-sm rounded-md"
                                type="submit"
                            >
                                {{ $t('Crear ticket') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <input ref="fileInput" hidden type="file" @change="uploadFile($event)">
    </main>
</template>

<script>
export default {
    name: "new",
    props:['UUIDSend'],
    metaInfo() {
        return {
            title: this.$i18n.t('Create ticket')
        }
    },
    data() {
        return {
            loading: {
                form: true,
                file: false,
            },
            uploadingFileProgress: 0,
            ticket: {
                user_id: null,
                subject: null,
                department_id: null,
                status_id: 1,
                priority_id: 1,
                body: '',
                attachments: [],
            },
            departmentList: [],
            userList: [],
            statusList: [],
            priorityList: [],
            cannedReplyList: [],
            ticketDetail:{},
            report:{
                user_id:null,
                agent_id:null,
                department_id:null,
                ticket_id:null,
                userReport_id:null,
                tituloReporte:'',
                razonReporte:'',
                attachments: [],
            }
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
          this.report.userReport_id = response.data.id;
          //console.log(this.userId);
        })
        .catch((error) => {
          console.log(error);
        });
    }
  },
    mounted() {
        
        this.getFilters();
        this.getCannedReplies();
        this.getTicketToSend();
    },
    methods: {
        getFilters() {
            const self = this;
            self.loading.form = true;
            axios.get('api/dashboard/tickets/filters').then(function (response) {
                self.userList = response.data.customers;
                self.departmentList = response.data.departments;
                self.statusList = response.data.statuses;
                self.priorityList = response.data.priorities;
                self.loading.form = false;
            }).catch(function () {
                self.loading.form = false;
            })
        },
        getTicketToSend(){
            const self=this;
            self.loading.form=true;
            axios.get('api/dashboard/tickets/' + self.UUIDSend).then(function (response) {
                //console.log(response.data)
                self.loading.form = false;
                self.ticketDetail = response.data;
                console.log("DATA RESPONSE",self.ticketDetail)
            }).catch(function () {
               
            });
        },
        getCannedReplies() {
            const self = this;
            axios.get('api/dashboard/tickets/canned-replies').then(function (response) {
                self.cannedReplyList = response.data;
            })
        },

        saveTicket() {
            const self=this;
            self.loading.form = true;

            self.report.agent_id=self.ticketDetail.agent_id;
            self.report.user_id=self.ticketDetail.user_id;
            self.report.department_id=self.ticketDetail.department_id;
            self.report.ticket_id=self.ticketDetail.id;

            axios.post('api/dashboard/admin/ReportTicket', self.report).then(function(response){
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data saved correctly').toString(),
                    type:'success'
                });
                self.$router.push('/dashboard/tickets/');
            }).catch(function(){
                self.loading.form =false;
            });
               
            console.log("console::: ",self.report);
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
                self.ticket.attachments.push(response.data);
            }).catch(function () {
                self.loading.file = false;
                self.uploadingFileProgress = 0;
                self.$refs.fileInput.value = null;
            });
        },
        removeAttachment(attachment) {
            this.ticket.attachments.splice(attachment, 1);
        }
    },
}
</script>
