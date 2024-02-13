<script>
import EnDirect from '@/components/EnDirect.vue'
import Podcast from '@/components/Podcast.vue'
import SearchBar from "@/components/SearchBar.vue";

export default {
  components: {
    EnDirect,
    SearchBar,
    Podcast
  },
};
</script>

<template>
  <en-direct></en-direct>
  <podcast></podcast>


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