<script>
export default {
  props: {
    podcast: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      emission: []
    }
  },
  created() {
    //console.log(this.podcast.links.emission)
    this.$api.get(`${this.podcast.links.emission.href}`)
        .then((response) => {
          this.emission = response.data.emission
          //console.log(this.emission)
        })
        .catch((error) => {
          console.log(error)
        });
  }
};
</script>

<template>
  <section class="podcast">
    <div class="podcast-info">
      <p>{{ emission.titre }}</p>
      <p>{{ podcast.titre }}</p>
    </div>
    <embed src="/icons/play.svg">
  </section>
</template>

<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";
@import "@/assets/listeEmissionsPodcasts";


</style>

