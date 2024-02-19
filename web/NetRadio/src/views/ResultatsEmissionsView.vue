<script>
import {RouterView } from 'vue-router'
import EnDirect from '@/components/EnDirect.vue';

export default {
  components: {
    EnDirect
  },
  data() {
    return {
        emissions: [
        { title: "Le titre de l'émission", presenter: "PRÉSENTATEUR" },
        { title: "Le titre de l'émission", presenter: "PRÉSENTATEUR" },
        { title: "Le titre de l'émission", presenter: "PRÉSENTATEUR" },
        { title: "Le titre de l'émission", presenter: "PRÉSENTATEUR" },
        { title: "Le titre de l'émission", presenter: "PRÉSENTATEUR" },
      ],
    }
  }
}
</script>

<template>
    <div>
        <en-direct></en-direct>
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
                <section
                    v-for="(emission, index) in emissions"
                    :key="index"
                    class="emission"
                    >
                    <p>{{ emission.title }}</p>
                    <p>{{ emission.presenter }}</p>
                </section>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">

</style>