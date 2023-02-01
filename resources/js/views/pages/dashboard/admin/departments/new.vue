<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="saveDepartment">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Creacion de departamento') }}</h1>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <loading :status="loading"/>
                    <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Informacion del departamento') }}</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                {{ $t('Configuracion y detalle del departamento') }}.
                            </p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="name">{{ $t('Nombre') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="name"
                                            v-model="department.name"
                                            :placeholder="$t('Nombre')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="all_agents">{{ $t('¿Se pueden unir todos los usuarios?') }}</label>
                                    <input-switch
                                        id="all_agents"
                                        v-model="department.all_agents"
                                        :disabled-label="$t('Solo usuarios seleccionados')"
                                        :enabled-label="$t('Todos los usuarios')"
                                    ></input-switch>
                                    <div class="mt-2 relative text-xs text-gray-500">
                                        {{ $t('permite el acceso al departamento a todos los usuario o solamente a los usuarios seleccionados') }}.
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="public">{{ $t('visibilidad del departamento') }}</label>
                                    <input-switch
                                        id="public"
                                        v-model="department.public"
                                        :disabled-label="$t('El departamento es privado')"
                                        :enabled-label="$t('El departamento es publico')"
                                    ></input-switch>
                                    <div class="mt-2 relative text-xs text-gray-500">
                                        {{ $t('Si el departamento es público, permite a los usuarios seleccionar este departamento al crear el ticket, de lo contrario, solo los agentes pueden reasignarse tickets a este departamento.') }}.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <template v-if="!department.all_agents">
                            <div class="md:col-span-3">
                                <div class="py-3">
                                    <div class="border-t border-gray-200"></div>
                                </div>
                            </div>
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Usuarios vinculados al departamento') }}</h3>
                                <p class="mt-1 text-sm leading-5 text-gray-500">
                                    {{ $t('lista de usuarios asignados al departamento') }}.
                                </p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-3">
                                        <div :style="{maxHeight: '200px'}" class="flex flex-col overflow-y-auto">
                                            <template v-for="user in users">
                                                <div class="flex items-center px-6 py-3 hover:bg-gray-100 cursor-pointer rounded" @click="selectAgent(user.id)">
                                                    <div>
                                                        <div class="flex items-center justify-center">
                                                            <svg-vue v-if="department.agents.includes(user.id)" class="w-5 h-5 text-green-400" icon="font-awesome.check-circle-solid"></svg-vue>
                                                            <div v-else class="w-5 h-5 p-1 overflow-hidden rounded-full border"></div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col ml-6">
                                                        <p class="text-sm leading-5 text-gray-700 group-hover:text-gray-900">{{ user.name }}</p>
                                                        <p class="text-xs leading-4 text-gray-500 group-hover:text-gray-700 group-focus:underline transition ease-in-out duration-150">{{ user.username }}</p>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <img
                                                            :src="user.avatar === 'gravatar' ? user.gravatar : user.avatar"
                                                            alt="User avatar"
                                                            class="inline-block rounded-full h-8 w-8"
                                                        />
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                        <span class="inline-flex">
                            <router-link
                                class="btn btn-secondary shadow-sm rounded-md mr-4"
                                to="/dashboard/admin/departments"
                            >
                                {{ $t('Cancelar') }}
                            </router-link>
                            <button
                                class="btn btn-green shadow-sm rounded-md"
                                type="submit"
                            >
                                {{ $t('crear departamento') }}
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </main>
</template>

<script>
export default {
    name: "new",
    metaInfo() {
        return {
            title: this.$i18n.t('Creacion de departamentos')
        }
    },
    data() {
        return {
            loading: true,
            users: [],
            department: {
                name: null,
                all_agents: false,
                public: true,
                agents: [],
            },
        }
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        saveDepartment() {
            const self = this;
            self.loading = true;
            axios.post('api/dashboard/admin/departments', self.department).then(function (response) {
                self.loading = false;
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data saved correctly').toString(),
                    type: 'success'
                });
                self.$router.push('/dashboard/admin/departments/' + response.data.department.id + '/edit');
            }).catch(function () {
                self.loading = false;
            });
        },
        getUsers() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/admin/departments/users').then(function (response) {
                self.users = response.data;
                self.loading = false;
            }).catch(function () {
                self.loading = false;
            });
        },
        selectAgent(user) {
            if (this.department.agents.includes(user)) {
                for (let i = 0; i < this.department.agents.length; i++) {
                    if (this.department.agents[i] === user) {
                        this.department.agents.splice(i, 1);
                    }
                }
            } else {
                this.department.agents.push(user);
            }
        }
    }
}
</script>
