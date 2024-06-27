

<template>
  <Head :title="title" />
  <v-layout class="">



    <v-main class="" style="min-height: 300px;">
      <slot></slot>
    </v-main>
  </v-layout>
</template>
<script lang="ts">
export default {
  props: {
    title: String
  }
}
</script>


<style lang="scss">

</style>