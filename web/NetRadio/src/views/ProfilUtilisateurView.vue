<script>
export default {
  data() {
    return {
      podcasts: [
        { title: "Titre du podcast 1", emission: "Nom Emission 1" },
        { title: "Titre du podcast 2", emission: "Nom Emission 2" },
        { title: "Titre du podcast 3", emission: "Nom Emission 3" },
      ],
      emissions: [
        { title: "Titre du podcast 1", nom: "Nom Emission 1" },
        { title: "Titre du podcast 2", nom: "Nom Emission 2" },
        { title: "Titre du podcast 3", nom: "Nom Emission 3" },
      ],
    };
  },
};
</script>

<template>
    <section>
        <div class="podcasts-list">
                <h2>Podcasts Enregistrés</h2>
            <div class="order">
                <div class="podcasts" v-for="(podcast, index) in podcasts" :key="index">
                    <h4>{{ podcast.title }}</h4>
                    <span>{{ podcast.emission }}</span>
                    <img src="" alt="play">
                </div>
            </div>>
        </div>
        <div class="userEmission">
                <h2>Emissions Enregistrés</h2>
            <div class="order">
                <div class="podcasts" v-for="(emission, index) in emissions" :key="index">
                    <h4>{{ emission.title }}</h4>
                    <span>{{ emission.nom }}</span>
                    <img src="" alt="play">
                </div>
            </div>        
        </div>
        </section>
</template>

<style scoped lang="scss">

</style>