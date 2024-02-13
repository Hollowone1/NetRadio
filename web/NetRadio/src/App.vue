App
<script >
import {RouterView } from 'vue-router'
import HeaderComponent from "@/components/HeaderComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";

export default {
  components: {
    RouterView,
    HeaderComponent,
    FooterComponent
  },
}
</script>

<template>
  <header-component></header-component>
  <RouterView />
  <FooterComponent></FooterComponent>
</template>

<style>
</style>

