<script setup >
import {usePage} from "@inertiajs/vue3";
const alert=usePage().props.flash?.alertMessage;
</script>

<template>
  <v-alert v-if="alert"  :type="alert.type"  :icon="alert.icon"   :closable="alert.closable"  :text="alert.message" :title="alert.title"  class="v-alert">
  </v-alert>
</template>

<style scoped lang="scss">
.v-alert{
  margin:5px;
}
</style>