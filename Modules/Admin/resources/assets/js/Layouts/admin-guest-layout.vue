<script setup>

import {Head} from "@inertiajs/vue3";
const props=defineProps(['title','pageClass']);

</script>

<template>
  <Head :title="title"/>
  <v-app >
    <v-main :class="pageClass">
    <slot/>
    </v-main>
  </v-app>
</template>

<style >

</style>