<script setup>

import {defineComponent} from "vue";
import AdminLayout from "@AdminModule/Layouts/admin-layout.vue";
import AdminGuestLayout from "@AdminModule/Layouts/admin-guest-layout.vue";
import ChangeLangComponent from "@AdminModule/Components/ChangeLangComponent.vue";
import {inject} from "vue";
import {useForm} from "@inertiajs/vue3";
import ThemeChange from "@AdminModule/Components/ThemeChange.vue";
const trans = inject('translate');
import { route } from 'ziggy-js';
import AlertMessageBox from "@AdminModule/Components/AlertMessageBox.vue";

const form = useForm({
    email: '',
    password: '',
    remember: false,
});
console.log(route())
const submit=()=>{
  form.post(route('adminWeb.login-post'),
      {
        onFinish:()=>form.reset('password'),
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