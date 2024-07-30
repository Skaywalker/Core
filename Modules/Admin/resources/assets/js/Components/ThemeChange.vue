<script setup>
import { useTheme } from 'vuetify'

const theme = useTheme()
const toggleTheme= ()=> {
  theme.global.name.value = theme.global.current.value.dark ? 'light' : 'dark'
}
</script>

<template>
  <v-fab
      @click="toggleTheme"
      v-if="theme.global.name.value==='light'"
      size="large"
      icon="mdi-weather-night"
  />
  <v-fab
      @click="toggleTheme"
      v-if="theme.global.name.value==='dark'"
      size="large"
      icon="mdi-white-balance-sunny"
  />
</template>

<style scoped>

</style>