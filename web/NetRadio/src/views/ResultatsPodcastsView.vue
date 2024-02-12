<script>
import {RouterView } from 'vue-router'
import EnDirect from '@/components/EnDirect.vue';

export default {
  components: {
    RouterView,
    EnDirect
  },
  data() {
    return {}
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
                <section class="podcast">
                    <div class="podcast-info">
                        <p>Nom de l'émission</p>
                        <p>Titre du podcast</p>
                    </div>
                    <embed src="../assets/play.svg">
                </section>

                <section class="podcast">
                    <div class="podcast-info">
                        <p>Nom de l'émission</p>
                        <p>Titre du podcast</p>
                    </div>
                    <embed src="../assets/play.svg">
                </section>

                <section class="podcast">
                    <div class="podcast-info">
                        <p>Nom de l'émission</p>
                        <p>Titre du podcast</p>
                    </div>
                    <embed src="../assets/play.svg">
                </section>

                <section class="podcast">
                    <div class="podcast-info">
                        <p>Nom de l'émission</p>
                        <p>Titre du podcast</p>
                    </div>
                    <embed src="../assets/play.svg">
                </section>
            </div>
        </div>
    </main> 
</template>

<style scoped lang="scss">

</style>