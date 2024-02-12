<script>
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
</script>

<template>
    <main>
        <section class="direct">
            <div class="direct-infos">
                <div class="direct-infos-titre">
                    <embed src="../assets/direct.svg"/>
                    <h1>Nom émission</h1>
                </div>
                <p class="direct-infos-sous-titre">EN DIRECT</p>
                <p class="direct-infos-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <button class="direct-infos-ecouter">Écouter</button>
            </div>
            <img class="direct-image" src="../assets/Desktop.png" alt="image de l'émission en direct">
        </section>

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
                <section class="emission" v-for="(emission, index) in emissions" :key="index">
                    <p>{{ emission.title }}</p>
                    <p>{{ emission.presenter }}</p>
                </section>
            </div>
        </div>
    </main>
</template>

<style scoped lang="scss">

</style>