<script setup>
import AdminGuestLayout from "@AdminModule/Layouts/admin-guest-layout.vue";
import ChangeLangComponent from "@AdminModule/Components/ChangeLangComponent.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import ThemeChange from "@AdminModule/Components/ThemeChange.vue";
import {trans} from "@AdminModule/Plugins/Translations.js";
import { route } from '@AdminModule/Plugins/adminRouteIndex.js';

import AlertMessageBox from "@AdminModule/Components/AlertMessageBox.vue";
console.log(usePage().props)
const form = useForm({
  email: '',
    password: '',
    remember: false,
});
const submit=()=>{
  form.post('/login',
      {
        preserveScroll: true,
        onSuccess: (re) => {
          console.log(re);
          form.reset();}

      }
  )
}
</script>

<template >

  <admin-guest-layout title="Login" pageClass="login-page">
    <v-card>



      <div class="login-card-header">
        <div>
          <ThemeChange/>
        </div>
        <h1>{{trans('admin::pages.login-title')}}</h1>
        <ChangeLangComponent />
      </div>
      <div class="logo-img"> <img src="https://picsum.photos/id/237/300/300" alt="logo">
      </div>
      <alert-message-box></alert-message-box>
      <v-form @submit.prevent="submit"  class="login-form">
        <v-text-field type="email" v-model="form.email">
          <template #label>{{trans('admin::pages.login-input-email')}}</template>
        </v-text-field>
        <v-text-field type="password" v-model="form.password">
          <template #label>{{ trans('admin::pages.login-input-password') }}</template>
        </v-text-field>
        <div class="login-card-bottom">
          <v-btn color="primary"  type="submit">{{trans('admin::pages.login-button')}}</v-btn>
        </div>
      </v-form>

    </v-card>
  </admin-guest-layout>
</template>

<style lang="scss">
</style>