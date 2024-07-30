<script setup>
const availableLang = import.meta.env.VITE_APP_AVAILABLE_LANGUAGES;
const currentLang = document.querySelector('html').getAttribute('lang');
</script>

<template>
  <div>
    <v-speed-dial
        location="bottom center"
        transition="fade-transition"
        location-strategy="connected"
    >
      <template v-slot:activator="{ props: activatorProps }">
        <v-fab
            v-bind="activatorProps"
            size="large"
            icon="
          $vuetify"
        >
          <img v-if="currentLang==='en'" class="current-flag"
               src="http://core.test/images/flags/united-kingdom-flag-icon.png" alt="eng-flag-img">
          <img v-if="currentLang==='hu'" class="current-flag" src="http://core.test/images/flags/hungary-flag-icon.png"
               alt="hu-flag-img">
        </v-fab>
      </template>
      <a href="/lang/en" key="1">
        <img class="flag"
             src="http://core.test/images/flags/united-kingdom-flag-icon.png"
             alt="eng-flag-img">
      </a>
      <a href="/lang/hu" key="2">
        <img class="flag"
             src="http://core.test/images/flags/hungary-flag-icon.png"
             alt="hu-flag-img"
        >
      </a>
    </v-speed-dial>
  </div>
</template>

<style scoped>

</style>