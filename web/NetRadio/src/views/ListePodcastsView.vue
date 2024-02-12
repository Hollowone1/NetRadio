<script>
import EnDirect from '@/components/EnDirect.vue'
import SearchBar from "@/components/SearchBar.vue";

export default {
  components: {
    EnDirect,
    SearchBar
  },
}

</script>

<template>
  <en-direct></en-direct>

  <div class="podcasts">
    <search-bar placeholder="Rechercher un podcast ..."/>
    <div class="jour">
      <h2>Récemment</h2>
      <div class="podcasts-liste">
        <section class="podcast">
          <div class="podcast-info">
            <p>Nom de l'émission</p>
            <p>Titre du podcast</p>
          </div>
          <embed src="/icons/play.svg">
        </section>

        <section class="podcast">
          <div class="podcast-info">
            <p>Nom de l'émission</p>
            <p>Titre du podcast</p>
          </div>
          <embed src="/icons/play.svg">
        </section>
      </div>
    </div>

    <div class="jour">
      <h2>Aujourd'hui</h2>
      <div class="podcasts-liste">
        <section class="podcast">
          <div class="podcast-info">
            <p>Nom de l'émission</p>
            <p>Titre du podcast</p>
          </div>
          <embed src="/icons/play.svg">
        </section>

        <section class="podcast">
          <div class="podcast-info">
            <p>Nom de l'émission</p>
            <p>Titre du podcast</p>
          </div>
          <embed src="/icons/play.svg">
        </section>
      </div>
    </div>

    <div class="jour">
      <h2>Cette semaine</h2>
      <div class="podcasts-liste">
        <section class="podcast">
          <div class="podcast-info">
            <p>Nom de l'émission</p>
            <p>Titre du podcast</p>
          </div>
          <embed src="/icons/play.svg">
        </section>

        <section class="podcast">
          <div class="podcast-info">
            <p>Nom de l'émission</p>
            <p>Titre du podcast</p>
          </div>
          <embed src="/icons/play.svg">
        </section>
      </div>
    </div>
  </div>
  <a href="">Découvrir d'autres podcasts</a>
</template>

<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";
@import "@/assets/listeEmissionsPodcasts";


h2 {
  @include text-style(2em, inherit, bold);
}

.jour {
  margin-bottom: 3em;
}

@media screen and (min-width: 700px) {
  h2 {
    @include text-style(2em, inherit, bold);
  }
}

.podcasts {
  padding-top: 1em;
  padding-left: 3em;
  padding-right: 3em;
}

</style>