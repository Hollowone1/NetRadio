<script>
import EnDirect from '@/components/EnDirect.vue'

export default {
  components: {
    EnDirect
  },
}

</script>

<template>
    <en-direct></en-direct>

    <div class="podcasts">
      <h2>Tous les podcasts</h2>
      <div class="jour">
        <h3>Récemment</h3>
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
        <h3>Aujourd'hui</h3>
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
        <h3>Cette semaine</h3>
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

.resultats {
  padding: 1em;
  .recherche {
    margin-bottom: 2em;
  }
  .barre-recherche {
    padding: .5em .5em .5em 1em;
    background-color: $lightLightGrey;
    border-bottom: 1px solid $lightGrey;
    @include flex(row, nowrap, .5em, space-between, center);
    margin-bottom: 1em;
  }
  input {
    background-color: $lightLightGrey;
    border: none;
    padding: 1em;
    width: 85%;
    @include text-style(1em, inherit, 400);
  }
  .genres {
    margin-top: 1em;
    button {
      display: inline-block !important;
      padding: .5em 1em .5em 1em;
      @include buttonStyle($transparent, $purple, $purple, auto, 1em, .2em);
      flex-grow: 2;
      &:hover {
        background-color: $purple;
        color: white;
        transition: background-color 0.3s;
      }
    }
  }
}

.theme {
  margin-bottom: 3em;
  h3 {
    @include text-style(1.5em, $purple, 500);
  }
}

.jour {
  margin-bottom: 3em;
  h3 {
    @include text-style(1.5em, $purple, 500);
  }
}

@media screen and (min-width: 700px) {
  h2 {
    @include text-style(2em, inherit, bold);
  }
  .resultats {
    padding: 1.5em;
    input {
      width: 95%
    }

  }
}

.podcasts {
  padding-top: 1em;
  padding-left: 3em;
  padding-right: 3em;
}

</style>