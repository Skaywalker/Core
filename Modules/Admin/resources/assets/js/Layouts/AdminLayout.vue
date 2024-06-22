<script setup lang="ts">
import {Head} from "@inertiajs/vue3";
defineProps({
  title: String,
});

</script>

<template>
  <Head :title="title" />
  <v-layout class="">



    <v-main class="" style="min-height: 300px;">
      <slot></slot>
    </v-main>
  </v-layout>
</template>

<style lang="scss">

</style>