<script setup>
import {usePage} from '@inertiajs/vue3';
import AdminLayout from "@AdminModule/Layouts/admin-layout.vue";
import {inject} from "vue";
defineProps(['value','app','lang']);

</script>

<template>
  <admin-layout title="Admin">
<h1>admin</h1>

  <a href="/lang/en">english</a> <br>
  <a href="/lang/hu">Hungary</a>
    <br>{{app+' '+ value+'/'+lang}}
    <br>
    {{trans('admin::module.welcome')}}
  </admin-layout>
</template>

<style scoped>

</style>