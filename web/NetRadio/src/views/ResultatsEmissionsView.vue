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
            <div class="recherche">
                <div class="barre-recherche">
                    <img src="../assets/loupe.svg" alt="icone recherche">
                    <input type="text" placeholder="Rechercher">
                </div>
                <div class="genres">
                    <button class="genre">Genre</button>
                    <button class="genre">Autre genre</button>
                    <button class="genre">Encore genre</button>
                    <button class="genre">Dernier genre</button>
                    <button class="genre">Genre</button>
                    <button class="genre">Genre</button>
                </div>
            </div>
            <div class="emissions-liste">
                <section class="emission">
                    <p>Le titre de l'émission</p>
                    <p>PRÉSENTATEUR</p>
                </section>
                <section class="emission">
                    <p>Le titre de l'émission</p>
                    <p>PRÉSENTATEUR</p>
                </section>
                <section class="emission">
                    <p>Le titre de l'émission</p>
                    <p>PRÉSENTATEUR</p>
                </section>
                <section class="emission">
                    <p>Le titre de l'émission</p>
                    <p>PRÉSENTATEUR</p>
                </section>
                <section class="emission">
                    <p>Le titre de l'émission</p>
                    <p>PRÉSENTATEUR</p>
                </section>
                <section class="emission">
                    <p>Le titre de l'émission</p>
                    <p>PRÉSENTATEUR</p>
                </section>
            </div>
        </div>
    </main>
</template>

<style scoped lang="scss">

</style>