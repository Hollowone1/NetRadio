<script>
import {RouterView } from 'vue-router'
import EnDirect from '@/components/EnDirect.vue';

export default {
  components: {
    RouterView,
    EnDirect
  },
  created() {
    this.$api.get("/podcasts")
        .then((response) => {
          this.podcasts = response.data.podcasts
          this.podcastsToday = this.getPodcastsDate(new Date().toISOString().split('T')[0]);
          this.recentPodcasts = this.podcasts.slice(-6)
        })
        .catch((error) => {
          console.log(error)
        });
  },
}
</script>

<template>
  <main>
    <en-direct></en-direct>
    <RouterView />

    <div class="resultats">
      <h2>Résultats de votre recherche</h2>
      <div class="barre-recherche">
        <img src="../assets/loupe.svg" alt="icone recherche">
        <input type="text" placeholder="Rechercher">
      </div>
      <div class="podcasts-liste">
        <section
          v-for="(podcast, index) in podcasts"
          :key="index"
          class="podcast"
        >
          <div class="podcast-info">
            <p>{{ podcast.titre }}</p>
            <p>{{ podcast.description }}</p>
          </div>
          <embed :src="podcast.playIcon" />
        </section>
      </div>
    </div>
  </main> 
</template>

<style scoped lang="scss">

</style>