<script>
import {toast} from "vue3-toastify";
import ToastOptions from "../toasts/toastOptions.js";
export default {
  props: {
    podcast: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      emission: []
    }
  },
  created() {
    this.$api.get(`${this.podcast.links.emission.href}`)
        .then((response) => {
          this.emission = response.data.emission
        })
        .catch((error) => {
          toast.error(`Erreur lors de la récupération de l'émission associée au podcast ${this.podcast.titre}`, ToastOptions)
        });
  }
};
</script>

<template>
  <section class="podcast">
    <div class="podcast-info">
      <p>{{ emission.titre }}</p>
      <p>{{ podcast.titre }}</p>
    </div>
    <img src="/icons/play.svg" alt="play icon">
  </section>
</template>

<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";
@import "@/assets/listeEmissionsPodcasts";

.podcast-info{
  text-align: start;
  padding: 1em;
  padding-left: 0.5em;
}


</style>

