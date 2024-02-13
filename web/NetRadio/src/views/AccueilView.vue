<script>
import EnDirect from '@/components/EnDirect.vue'
import Emission from '@/components/Emission.vue'
import Podcast from '@/components/Podcast.vue'

export default {
  components: {
    EnDirect,
    Emission,
    Podcast
  },
  data() {
    return {
      emissions: [],
      podcasts: [],
      podcastsToday: [],
      recentPodcasts: []
    }
  },
  methods: {
    getPodcastsDate(date) {
      //const today = new Date().toISOString().split('T')[0];
      return this.podcasts.filter(podcast => podcast.date === date);
    }
  },
  created() {
    this.$api.get("emissions")
        .then((response) => {
          this.emissions = response.data.emission
        })
        .catch((error) => {
          console.log(error)
        });

    this.$api.get("podcasts")
        .then((response) => {
          this.podcasts = response.data.podcasts
          console.log(this.podcasts)
          this.podcastsToday = this.getPodcastsDate(new Date().toISOString().split('T')[0]);
          this.recentPodcasts = this.podcasts.slice(-5)
        })
        .catch((error) => {
          console.log(error)
        });
  },
}
</script>

<template>
  <en-direct></en-direct>

  <div class="emissions">
    <h2>Toutes les émissions</h2>
    <div class="theme">
      <h3>Thématique 1</h3>
      <div class="emissions-liste">
        <emission v-for="emission in emissions" :emission="emission" :key="emission.id"></emission>
      </div>
    </div>
  </div>

  <div class="podcasts">
    <div class="jour">
      <h2>Aujourd'hui</h2>
      <div class="podcasts-liste">
        <podcast v-for="podcast in podcastsToday" :podcast="podcast" :key="podcast.id"></podcast>
      </div>
    </div>
    <div class="jour">
      <h2>Récemment</h2>
      <div class="podcasts-liste">
        <podcast v-for="podcast in recentPodcasts" :podcast="podcast" :key="podcast.id"></podcast>
      </div>
    </div>
  </div>
  <RouterView/>
</template>

<style scoped lang="scss">

@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";

.header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1%;
}

.podcasts {
  padding-top: 1em;
  padding-left: 3em;
  padding-right: 3em;
}

.emissions {
  padding-top: 1em;
  padding-left: 3em;
  padding-right: 3em;
}

.header-logo {
  margin-left: 20px;
  border-radius: 5px;
  height: 80px;
  width: auto;
}

.header-boutons {
  display: flex;

  .header-user-co {
    height: 50px;
    width: auto;
    margin: .5em 0em .5em 0em;
  }

  .header-boutons-connecter {

    @include buttonStyle($purple, $purple, white, auto, 1em, .5em 0em .5em 0em, 0px);
    font-weight: 500;
    margin-right: 10px;
  }

  .search {

    border-color: transparent;
    border-bottom-color: #dcdcdc;
    border-right-color: #dcdcdc;
    border-radius: 5px;
    width: auto;
    font-size: 1em;
    margin: .5em 0em .5em 0em;

  }
}

.header-boutons-connecter {
  margin-right: 10px;
}

@media (max-width: 768px) {
  .header {
    flex-direction: column;
    padding: 20px;
  }

  .header-logo {
    width: 20%;
    height: auto;
    margin-bottom: 20px;
  }

  .header-boutons {
    flex-direction: row;
    align-items: center;
    margin-bottom: 20px;
  }

  .header-user-co {
    height: 40px;
    width: auto;
    margin-right: 10px;
  }

  .header-boutons-connecter {
    font-size: 0.8em;
    padding: 5px 10px;
  }

  .search {
    width: 100%;
    font-size: 0.8em;
    padding: 5px 10px;
  }
}


</style>