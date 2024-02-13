<script>
<<<<<<< HEAD
export default {
  data() {
    return {
      emissions: [
        { title: "Titre de l'émission 1", presenter: "Présentateur 1" },
        { title: "Titre de l'émission 2", presenter: "Présentateur 2" },
        { title: "Titre de l'émission 3", presenter: "Présentateur 3" },
        { title: "Titre de l'émission 4", presenter: "Présentateur 4" },
        { title: "Titre de l'émission 5", presenter: "Présentateur 5" },
        { title: "Titre de l'émission 6", presenter: "Présentateur 6" },
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
>>>>>>> feat/front
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
<<<<<<< HEAD
                <section class="emission" v-for="(emission, index) in emissions" :key="index">
=======
                <section
                    v-for="(emission, index) in emissions"
                    :key="index"
                    class="emission"
                    >
>>>>>>> feat/front
                    <p>{{ emission.title }}</p>
                    <p>{{ emission.presenter }}</p>
                </section>
            </div>
        </div>
    </main>
</template>

<style scoped lang="scss">

</style>