<script>
import EnDirect from '@/components/EnDirect.vue'
import Podcast from '@/components/Podcast.vue'
import SearchBar from "@/components/SearchBar.vue";

export default {
  components: {
    EnDirect,
    SearchBar,
    Podcast
  },
  data() {
    return {
      podcasts: [],
      podcastsToday: [],
      recentPodcasts: []
    }
  },
  created() {
    this.$api.get("podcasts")
        .then((response) => {
          this.podcasts = response.data.podcasts
          this.podcastsToday = this.getPodcastsDate(new Date().toISOString().split('T')[0]);
          this.recentPodcasts = this.podcasts.slice(-6)
        })
        .catch((error) => {
          console.log(error)
        });
  },
  methods: {
    getPodcastsDate(date) {
      return this.podcasts.filter(podcast => podcast.date === date);
    },
  },
};
</script>

<template>
  <en-direct></en-direct>
  <div class="podcasts">
    <div class="jour">
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
  padding-left: 3em;
  padding-right: 3em;
}

</style>