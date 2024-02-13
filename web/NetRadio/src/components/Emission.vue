
<script>

export default {
  props: {
    emission: {
      type: Object,
      required: true
    },
  },
  data() {
    return {

    }
  },
  directives : {
    image : {
      mounted(el, binding) {
        el.style.background =  `linear-gradient( transparent,black), url('${binding.value}')`;
        //el.style.background = `url('${binding.value}')`;
      }
    }
  }

};
</script>

<template>
  <section v-image="emission.photo" class="emission">
<!--
    <img :src="emission.photo" alt="emission">
-->
    <p>{{ emission.titre }}</p>
    <p>{{ emission.theme }}</p>
    <p>{{ emission.user_mail }}</p>
  </section>
</template>

<style scoped lang="scss">

@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";
@import "@/assets/listeEmissionsPodcasts";


</style>