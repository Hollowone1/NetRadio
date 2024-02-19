<script>
import EnDirect from "@/components/EnDirect.vue";

export default {
  data() {
    return {
      emission: [],
      podcasts: [],
      playing: false
    }
  },
  components: {
    EnDirect,
  },
  created() {
    this.$api.get(`/emissions/${this.$route.params.id}`)
        .then((response) => {
          this.emission = response.data.emission
          this.$api.get(response.data.emission.links.users.href)
              .then((response2) => {
                this.emission.user = `${response2.data.user.nom} ${response2.data.user.prenom}`
              })
              .catch((error2) => {
                console.log(error2.response.data)
              });
        })
        .catch((error) => {
          console.log(error)
        });

    this.$api.get(`/emissions/${this.$route.params.id}/podcasts`)
        .then((response) => {
          this.podcasts = response.data.podcasts
          this.podcasts.forEach(podcast => {
            podcast.playing = false
            podcast.plus = false
          })
        })
        .catch((error) => {
          console.log(error)
        });
  },
  methods: {
    startPlaying(podcast) {
      podcast.playing = true
      //récup le mp4
      //lancer le mp4
    },
    stopPlaying(podcast) {
      podcast.playing = false
      //stop l'audio de son
    },
    togglePlus(podcast) {
      podcast.plus = !podcast.plus
    }
  }
}

</script>

<template>
  <main>
    <en-direct></en-direct>

    <div class="presentation">
      <div class="presentation-infos">
        <img alt="emission photo" :src="emission.photo"/>
        <div class="presentation-infos-texte">
          <h3>{{ emission.titre }}</h3>
          <p> {{ emission.description }}</p>
        </div>
      </div>
    </div>

    <div class="podcasts-emission">
      <h2>Podcasts</h2>
      <div class="episodes">
        <section v-for="podcast in podcasts" class="episode">
          <div class="episode-infos">
            <div>
              <img @click="stopPlaying(podcast)" v-if="podcast.playing" class="pause" src="/icons/pause.svg"
                   alt="pause icon">
              <img @click="startPlaying(podcast)" v-else class="play" src="/icons/miniplay.svg" alt="play icon">
              <p class="titre">{{ podcast.titre }}</p>
            </div>
            <div>
              <p>{{ podcast.duree }}</p>
              <img @click="togglePlus(podcast)" v-if="podcast.plus" class="croix" src="/icons/croix.svg"
                   alt="cross icon">
              <img @click="togglePlus(podcast)" v-else class="plus" src="/icons/plus.svg" alt="plus icon">
            </div>
          </div>
          <div class="episode-infos-plus" :class="{ active : podcast.plus}">
            <p><strong>Présentateur : </strong> {{ emission.user }}</p>
            <p><strong>Invités : </strong> Nom Prénom, Nom Prénom</p>
            <p class="date">{{ podcast.date }}</p>
            <p>{{ podcast.description }}</p>
          </div>
        </section>
      </div>
    </div>
    <router-link to="/liste-des-emissions">Découvrir d'autres émissions</router-link>
  </main>
</template>

<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";
@import "@/assets/listeEmissionsPodcasts";


.podcasts-emission, .presentation {
  padding: 1em
}

.presentation {
  &-infos {
    img {
      width: 100%;
      border-radius: 10px;
      margin-bottom: .5em;
    }

    &-texte {
      text-align: justify;

      h3 {
        margin-bottom: .2em;
        @include text-style(1.3em, inherit, 600);
      }
    }
  }
}

.podcasts-emission {
  h2 {
    @include text-style(1.8em, inherit, bold);
  }

  .episode {
    margin-bottom: 1em;
    padding: 1.5em 2em 1.5em 2em;
    border: 3px solid $purple;
    border-radius: 20px;

    &-infos {
      font-size: 1.1em;
      @include flex(column, nowrap, 1em, space-between, stretch);

      div {
        @include flex(row, nowrap, 1em, space-between, center);
      }

      img {
        height: 1.7em
      }

      .play {
        height: 1.7em;
      }

      .pause {
        height: 1.5em;
        padding-right: .3em;
      }

      .titre {
        @include text-style(inherit, inherit, 500);
      }

      &-plus {
        margin-top: .8em;
        display: none;

        p {
          margin-top: .5em;
        }
        p:nth-child(1) {
          padding-top: 1em
        }

        .date {
          @include text-style(inherit, inherit, 200);
        }
      }
    }
  }
}

.active {
  display: initial !important;
}

@media screen and (min-width: 700px) {
  .podcasts-emission, .presentation {
    padding: 1.5em;
  }
  .presentation {
    &-titre {
      h2 {
        @include text-style(2.3em, inherit, bold);
      }

      img {
        height: 1.5em;
      }
    }

    &-infos {
      @include flex(row, nowrap, 1em, space-between, center);

      img {
        width: 25vw;
      }

      &-texte {
        font-size: 1.1em;

        h3 {
          margin: 0 0 .2em;
          @include text-style(1.5em, inherit, 600);
        }
      }
    }
  }

  .podcasts-emission {
    h2 {
      @include text-style(2.3em, inherit, bold);
    }

    .episodes {
      @include grid(1fr, auto, 1em, center, stretch);

      .episode {
        margin: 0;

        img:hover {
          cursor: pointer;
        }

        &-infos {
          font-size: 1.2em;
          @include flex(row, nowrap, 2.5em, space-between, center);

          div {
            @include flex(row, nowrap, 1em, space-between, center);
          }

          &-plus {
            font-size: 1.1em;
            display: none;
            margin-top: .8em;
            background-color: blue;

            p {
              margin-top: .5em;
            }

            .date {
              @include text-style(inherit, inherit, 200);
            }
          }

        }
      }
    }

  }
}
</style>