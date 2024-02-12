<script>
export default {
  data() {
    return {
      podcasts: [
        { emission: "Nom de l'émission 1", title: "Titre du podcast 1" },
        { emission: "Nom de l'émission 2", title: "Titre du podcast 2" },
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

        <div class="podcasts">
            <h2>Tous les podcasts</h2>
            <div class="jour">
                <h3>Récemment</h3>
                <div class="podcasts-liste">
                    <section v-for="(podcast, index) in podcasts"
                        :key="index"
                        class="podcast">
                        <div class="podcast-info">
                            <p>{{ podcast.emission }}</p>
                            <p>{{ podcast.title }}</p>
                        </div>
                        <embed src="../assets/play.svg">
                    </section>
                </div>
            </div>
        </div>
        <a href="">Découvrir d'autres podcasts</a>
    </main>
</template>

<style scoped lang="scss">

</style>