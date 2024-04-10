<script>
import EnDirect from '@/components/EnDirect.vue'
import Podcast from '@/components/Podcast.vue'
import SearchBar from "@/components/SearchBar.vue";
import {toast} from "vue3-toastify";
import ToastOptions from "../toasts/toastOptions.js";
export default {
  components: {
    EnDirect,
    SearchBar,
    Podcast
  },
  data() {
    return {
      allPodcasts: [],
      displayPodcasts: [],
      podcastsToday: [],
      recentPodcasts: [],
      remainingPodcasts: [],
      searching: false,
      research: "",
    }
  },
  created() {
    this.$api.get("/podcasts?sort=date")
        .then((response) => {
          this.allPodcasts = response.data.podcasts
          this.displayPodcasts = response.data.podcasts

          this.podcastsToday = this.getPodcastsDate(new Date().toISOString().split('T')[0]);
          this.recentPodcasts = this.allPodcasts.slice(-6)
          this.remainingPodcasts = this.allPodcasts.slice(0, -6)
        })
        .catch((error) => {
          toast.error('Erreur lors de la récupération des podcasts', ToastOptions)
        });
  },
  methods: {
    getPodcastsDate(date) {
      return this.allPodcasts.filter(podcast => podcast.date === date);
    },
    search() {
      this.searching = true;
      this.displayPodcasts = this.allPodcasts.filter(podcast =>
          podcast.titre.toLowerCase().includes(this.research.toLowerCase())
      );
    },
    endSearch() {
      this.searching = false;
      this.research = "";
      this.displayPodcasts = this.allPodcasts;
    },
  },
  watch: {
    research() {
      if (this.research === "") {
        this.endSearch();
      }
    }
  }
};
</script>

<template>
  <en-direct></en-direct>
  <div class="resultats">
    <h1>Tous nos podcasts</h1>
    <div class="recherche">
      <div class="barre-recherche">
        <img src="/icons/loupe.svg" alt="icone recherche">
        <input @keyup.enter="search()" v-model="research" type="text" placeholder="Rechercher">
        <img @click="endSearch()" v-if="research" src="/icons/croix.svg" alt="icone croix">
      </div>
    </div>
    <div v-if="searching" class="podcasts-liste">
      <podcast v-for="podcast in displayPodcasts" :podcast="podcast" :key="podcast.id"></podcast>
    </div>
    <div v-else class="podcasts">
      <div v-if="podcastsToday[0]" class="jour">
        <h2>Aujourd'hui</h2>
        <div class="podcasts-liste">
          <podcast v-for="podcast in podcastsToday" :podcast="podcast" :key="podcast.id"></podcast>
        </div>
      </div>
      <div class="jour">
        <h2>Récemment</h2>
        <div class="podcasts-liste">
          <podcast v-for="podcast in recentPodcasts" :podcast="podcast" :key="podcast.id"></podcast>
        </div>
      </div>
      <div class="jour">
        <h2>Précédemment</h2>
        <div class="podcasts-liste">
          <podcast v-for="podcast in remainingPodcasts" :podcast="podcast" :key="podcast.id"></podcast>
        </div>
      </div>
    </div>
  </div>


  <a href="">Découvrir d'autres podcasts</a>
</template>

<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";
@import "@/assets/listeEmissionsPodcasts";


h2 {
  @include text-style(2em, inherit, bold);
}

.jour {
  margin-bottom: 3em;
}

@media screen and (min-width: 700px) {
  h2 {
    @include text-style(2em, inherit, bold);
  }
}

.podcasts {
  padding-top: 1em;
}

</style>