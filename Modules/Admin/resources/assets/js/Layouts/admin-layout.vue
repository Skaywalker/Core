<script setup xmlns:Head="http://www.w3.org/1999/html">
import {Head, router, useForm} from "@inertiajs/vue3";
import { route } from '@AdminModule/Plugins/adminRouteIndex.js';
defineProps(['title'])
const logout=()=>{
  console.log('logout')
  router.post('/logout',{})
}
</script>

<template>
<v-app>
    <Head :title="title"/>
    <v-app-bar app>
        <v-toolbar-title>Admin</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn color="primary"  variant="tonal" to="/admin">Home</v-btn>
        <v-btn  to="/admin/users">Users</v-btn>
        <v-btn to="/admin/roles">Roles</v-btn>
        <v-btn to="/admin/permissions">Permissions</v-btn>
        <v-btn to="/admin/settings">Settings</v-btn>
        <v-btn  @click="logout">Logout</v-btn>
    </v-app-bar>
    <v-main>
        <v-container>
            <slot></slot>
        </v-container>
    </v-main>
    <v-footer app>
        <span>&copy; 2021</span>
    </v-footer>
</v-app>
</template>

<style scoped>

</style>