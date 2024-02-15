<script >
import {RouterView } from 'vue-router'
import HeaderComponent from "@/components/HeaderComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue"
import headsidebar from "@/components/HeadSidebar.vue";


export default {
  components: {
    RouterView,
    HeaderComponent,
    FooterComponent,
    headsidebar
  },
}
</script>

<template>
  <header-component></header-component>
  <headsidebar></headsidebar>
  <RouterView />
  <FooterComponent></FooterComponent>
</template>

<style>
</style>

