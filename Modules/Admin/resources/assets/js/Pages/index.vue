<script setup>
import AdminLayout from "@AdminModule/Layouts/admin-layout.vue";
import {inject,defineProps} from "vue";
const props=defineProps(['value','app','lang']);
const trans = inject('translate');
</script>

<template>
  <admin-layout title="Admin">
<h1>admin</h1>

  <a href="/lang/en">english</a> <br>
  <a href="/lang/hu">Hungary</a>
    <br>{{props.app +' '+ props.value+'/'+props.lang}}
    <br>
    {{trans('admin::module.welcome')}}
  </admin-layout>
</template>

<style scoped>

</style>