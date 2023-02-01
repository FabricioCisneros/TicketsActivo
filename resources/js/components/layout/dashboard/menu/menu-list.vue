<template>
    <div>
        <div class="my-3 mx-4 uppercase text-gray-300 text-xs">
            {{ $t('General') }}
        </div>
        <menu-item
            :label="$t('Dashboard')"
            :mobile="mobile"
            icon="font-awesome.tachometer-alt-regular"
            to="/dashboard/home"
        ></menu-item>
        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.TicketController']"
            :label="$t('Tickets')"
            :mobile="mobile"
            icon="font-awesome.inbox-regular"
            to="/dashboard/tickets"
        ></menu-item>
        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.CannedReplyController']"
            :label="$t('Respuestas Rapidas')"
            :mobile="mobile"
            icon="font-awesome.comments-alt-regular"
            to="/dashboard/canned-replies"
        ></menu-item>
        <div
            v-if="$store.state.permissions && (
                $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.UserController'] ||
                $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.UserRoleController'] ||
                $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.SettingController'] ||
                $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.LanguageController']
            )"
            class="my-3 mx-4 uppercase text-gray-300 text-xs"
        >
            {{ $t('Administracion') }}
        </div>
        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.DepartmentController']"
            :label="$t('Departamentos')"
            :mobile="mobile"
            icon="font-awesome.users-class-regular"
            to="/dashboard/admin/departments"
        ></menu-item>
        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.LabelController']"
            :label="$t('Etiquetas')"
            :mobile="mobile"
            icon="font-awesome.tags-regular"
            to="/dashboard/admin/labels"
        ></menu-item>
        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.StatusController']"
            :label="$t('Estatus')"
            :mobile="mobile"
            icon="font-awesome.tasks-regular"
            to="/dashboard/admin/statuses"
        ></menu-item>
        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.PriorityController']"
            :label="$t('Prioridades')"
            :mobile="mobile"
            icon="font-awesome.pennant-regular"
            to="/dashboard/admin/priorities"
        ></menu-item>
        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.UserController']"
            :label="$t('Usuarios')"
            :mobile="mobile"
            icon="font-awesome.users-regular"
            to="/dashboard/admin/users"
        ></menu-item>
        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.UserRoleController']"
            :label="$t('Roles de usuarios')"
            :mobile="mobile"
            icon="font-awesome.id-card-regular"
            to="/dashboard/admin/user-roles"
        ></menu-item>
        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.SettingController']"
            :label="$t('Configuraciones')"
            :mobile="mobile"
            icon="font-awesome.cog-regular"
            to="/dashboard/admin/settings"
        ></menu-item>
        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.LanguageController']"
            :label="$t('Traducciones')"
            :mobile="mobile"
            icon="font-awesome.language-regular"
            to="/dashboard/admin/languages"
        ></menu-item>
        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.LanguageController']"
            :label="$t('Inventario')"
            :mobile="mobile"
            icon="font-awesome.device-regular"
            to="/dashboard/admin/languages"
        ></menu-item>
    </div>
</template>

<script>
import MenuItem from "@/components/layout/dashboard/menu/menu-item";

export default {
    name: "menu-list",
    components: {MenuItem},
    props: {
        mobile: {
            type: Boolean,
            required: false
        }
    }
}
</script>
