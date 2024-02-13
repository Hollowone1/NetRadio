<script>
import {RouterView } from 'vue-router'
import EnDirect from '@/components/EnDirect.vue';

export default {
  components: {
    RouterView,
    EnDirect
  },
  data() {
    return {
        podcasts: [
        { emissionName: "Nom de l'émission", podcastTitle: "Titre du podcast", playIcon: "../assets/play.svg" },
        { emissionName: "Nom de l'émission", podcastTitle: "Titre du podcast", playIcon: "../assets/play.svg" },
        { emissionName: "Nom de l'émission", podcastTitle: "Titre du podcast", playIcon: "../assets/play.svg" },
        { emissionName: "Nom de l'émission", podcastTitle: "Titre du podcast", playIcon: "../assets/play.svg" },
      ],
    }
  }
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
                    <p>{{ podcast.emissionName }}</p>
                    <p>{{ podcast.podcastTitle }}</p>
                    </div>
                    <embed :src="podcast.playIcon" />
                </section>
            </div>
        </div>
    </main> 
</template>

<style scoped lang="scss">

</style>