<script>
import EnDirect from '@/components/EnDirect.vue'
import Emission from '@/components/Emission.vue'
import Podcast from '@/components/Podcast.vue'
import Creneaux from '@/components/creneaux.vue'
import {toast} from "vue3-toastify";
import ToastOptions from "../toasts/toastOptions.js";
export default {
  components: {
    EnDirect,
    Emission,
    Podcast,
    Creneaux,

  },
  data() {
    return {
      emissions: [],
      podcasts: [],
      selectedDate: null,
      showSlots: false,
    }
  },
  methods: {
    displaySlots(date) {
      this.selectedDate = date
      this.showSlots = true
    },
  },
  created() {
    this.$api.get("/emissions")
        .then((response) => {
          this.emissions = response.data.emission.slice(0, 6)
          this.emissions.forEach(emission => {
            this.$api.get(emission.links.users.href)
                .then((response2) => {
                  emission.user = `${response2.data.user[0].nom} ${response2.data.user[0].prenom}`
                })
                .catch((error) => {
                  toast.error('Erreur lors de la récupération des présentateurs', ToastOptions)
                });
          });
        })
        .catch((error) => {
          toast.error('Erreur lors de la récupération des émissions', ToastOptions)
        });

    this.$api.get("/podcasts?sort=date")
        .then((response) => {
          this.podcasts = response.data.podcasts.slice(0, 6)
        })
        .catch((error) => {
          toast.error('Erreur lors de la récupération des podcasts', ToastOptions)
        });
  },
}
</script>

<template>
  <en-direct></en-direct>
  <div class="emissions">
    <div class="top">
      <h2>Émissions</h2>
      <img src="/icons/fleche.svg" alt="arrow">
    </div>
    <div class="emissions-liste">
      <emission v-for="emission in emissions" :emission="emission" :key="emission.id"></emission>
    </div>
  </div>


  <div class="podcasts">
    <div class="top">
      <h2>Podcasts</h2>
      <img src="/icons/fleche.svg" alt="arrow">
    </div>
    <div class="podcasts-liste">
      <podcast v-for="podcast in podcasts" :podcast="podcast" :key="podcast.id"></podcast>
    </div>
  </div>

  <RouterView/>
</template>

<style scoped lang="scss">

@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";

.podcasts, .emissions {
  padding-top: 1em;
  padding-left: 3em;
  padding-right: 3em;
  margin-bottom: 1em;
  .top {
    h2{
      margin: 0
    }
    margin: 1em 0 1em;
    @include flex(row, nowrap, 1em, start, center);
    img {
      height: 1em;
    }
  }
}




</style>