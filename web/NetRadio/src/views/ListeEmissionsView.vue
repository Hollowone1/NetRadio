<script>
export default {
  data() {
    return {
      emissions: [
        { title: "Le titre de l'émission 1", presenter: "PRÉSENTATEUR 1" },
        { title: "Le titre de l'émission 2", presenter: "PRÉSENTATEUR 2" },
        { title: "Le titre de l'émission 3", presenter: "PRÉSENTATEUR 3" },
        { title: "Le titre de l'émission 4", presenter: "PRÉSENTATEUR 4" },
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

        <div class="emissions">
            <h2>Toutes les émissions</h2>
            <div class="theme">
                <h3>Thématique 1</h3>
                <div class="emissions-liste">
                    <section v-for="(emission, index) in emissions"
                    :key="index"
                    class="emission">
                        <p>{{ emission.titre }}</p>
                        <p>{{ emission.presenter }}</p>
                    </section>
                </div>
            </div>
        </div>
    </main>
</template>

<style scoped lang="scss">

</style>