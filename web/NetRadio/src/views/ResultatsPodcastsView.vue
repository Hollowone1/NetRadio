<script>
<<<<<<< HEAD
export default {
  data() {
    return {
      podcasts: [
        { emission: "Nom de l'émission 1", title: "Titre du podcast 1" },
        { emission: "Nom de l'émission 2", title: "Titre du podcast 2" },
        { emission: "Nom de l'émission 3", title: "Titre du podcast 3" },
        { emission: "Nom de l'émission 4", title: "Titre du podcast 4" },
      ],
    };
  },
};
=======
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
>>>>>>> feat/front
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
<<<<<<< HEAD
                <section class="podcast" v-for="(podcast, index) in podcasts" :key="index">
                    <div class="podcast-info">
                        <p>{{ podcast.emission }}</p>
                        <p>{{ podcast.title }}</p>
=======
                <section
                v-for="(podcast, index) in podcasts"
                :key="index"
                class="podcast"
                >                    
                <div class="podcast-info">
                    <p>{{ podcast.emissionName }}</p>
                    <p>{{ podcast.podcastTitle }}</p>
>>>>>>> feat/front
                    </div>
                    <embed :src="podcast.playIcon" />
                </section>
            </div>
        </div>
    </main> 
</template>

<style scoped lang="scss">

</style>