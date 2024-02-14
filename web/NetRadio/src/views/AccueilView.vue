<script>
import EnDirect from '@/components/EnDirect.vue'
import Emission from '@/components/Emission.vue'
import Podcast from '@/components/Podcast.vue'
import Calendar from '@/components/Calendar.vue'
export default {
  components: {
    EnDirect,
    Emission,
    Podcast,
    Calendar
  },
  data() {
    return {
      emissions: [],
      podcasts: [],
    }
  },
  methods: {},
  created() {
    this.$api.get("emissions")
        .then((response) => {
          this.emissions = response.data.emission.slice(0, 6)
        })
        .catch((error) => {
          console.log(error)
        });

    this.$api.get("podcasts")
        .then((response) => {
          this.podcasts = response.data.podcasts.slice(0, 6)
        })
        .catch((error) => {
          console.log(error)
        });
  },
}
</script>

<template>
  <en-direct></en-direct>
  <Calendar></Calendar>
  <div class="emissions">
    <div class="top">
      <h2>Émissions</h2>
      <img src="/icons/fleche.svg" alt="arrow">
    </div>
    <div class="emissions-liste">
      <emission v-for="emission in emissions" :emission="emission" :key="emission.id"></emission>
    </div>
  </div>


  <div class="podcasts">
    <div class="top">
      <div><h2>Podcasts</h2></div>
      <div><img src="/icons/fleche.svg" alt="arrow"></div>
    </div>
    <div class="podcasts-liste">
      <podcast v-for="podcast in podcasts" :podcast="podcast" :key="podcast.id"></podcast>
    </div>
  </div>

  <RouterView/>
</template>

<style scoped lang="scss">

@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";

.podcasts, .emissions {
  padding-top: 1em;
  padding-left: 3em;
  padding-right: 3em;
  .top {
    h2{
      margin: 0;
      margin-bottom: .5em;
      margin-top: 1em;

    }

    @include flex(row, nowrap, 1em, start);
    img {
      height: 1em;
    }

  display: grid;
  grid-template-columns: auto auto;
  padding: 10px;
  }
}


</style>