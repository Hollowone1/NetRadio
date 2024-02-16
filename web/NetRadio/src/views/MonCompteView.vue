<script>
import PopupEmission from "@/components/PopupEmission.vue";
import Emission from '@/components/Emission.vue'
import SideBar from "@/components/SideBarComponent.vue";
import {mapState, mapActions} from "pinia";
import {useUserStore} from "@/stores/user.js";
//import VueJwtDecode from "vue-jwt-decode";
import { jwtDecode } from "jwt-decode";

export default {
  components: {
    PopupEmission,
    Emission,
    SideBar
  },
  data() {
    return {
      showPopupEmission: false,
      emissionToDisplay: {},
      display: 1,
      emissions: [],
    }
  },
  computed: {
    ...mapState(useUserStore, ['user', 'tokens', 'loggedIn'])
  },
  created() {
    this.$api.get("/emissions")
        .then((response) => {
          this.emissions = response.data.emission
          this.emissions.forEach(emission => {
            this.$api.get(emission.links.users.href)
                .then((response2) => {
                  emission.user = `${response2.data.user.nom} ${response2.data.user.prenom}`
                })
                .catch((error) => {
                  console.log(error)
                });
          });
        })
        .catch((error) => {
          console.log(error)
        });

    const mail = jwtDecode(this.tokens.access_token).upr.email
    this.$api.get(`/users/mail/${mail}`)
        .then((response) => {
          //console.log(response.data)
          this.setUser(response.data.user)
        })
        .catch((error) => {
          console.log(error)
        });

  },
  methods: {
    ...mapActions(useUserStore, ['setUser']),
    changeDisplay(number) {
      this.display = number;
    },
    displayEmission(id) {
      this.emissionToDisplay = this.emissions.find(emission => emission.id === id);
      this.showPopupEmission = true;
    },
    updateEmission() {
      this.showPopupEmission = false;
      //aller refetch les infos de l'émission quand elle a été mise à jour !
    }
  }
}

</script>

<template>
  <div class="view" v-if="user.role === `1`">
    <side-bar @change="changeDisplay">
      <template v-slot:1>Mon compte</template>
      <template v-slot:2>Enregistrements</template>
    </side-bar>
    <main>
      <div v-if="display === 1" class="display mon-compte">
        <div class="top">
          <h1>Mon compte</h1>
          <button>Modifier mes informations</button>
        </div>
        <div class="info">
          <img src="/icons/profile.svg" alt="profile">
          <div>
            <p><strong>Nom d'utilisateur :</strong> {{ user.nom }}</p>
            <p><strong>Email :</strong> {{ user.prenom }}</p>
          </div>
        </div>
      </div>
      <div v-if="display === 2" class="display enregistrements">
        <h1>Vos enregistrements</h1>
        <div class="podcasts">
          <h2>Podcasts</h2>
          <section class="podcast">
            <div class="podcast-info">
              <p>Nom de l'émission</p>
              <p>Titre du podcast</p>
            </div>
            <embed src="/icons/play.svg">
          </section>
        </div>
        <div class="emissions">
          <h2>Émissions</h2>
          <section class="emission">
            <p>Le titre de l'émission</p>
            <p>PRÉSENTATEUR</p>
          </section>
        </div>
      </div>
    </main>
  </div>


  <div class="view" v-if="user.role === `2`">
    <side-bar @change="changeDisplay">
      <template v-slot:1>Mon compte</template>
      <template v-slot:2>Émissions</template>
      <template v-slot:3>Calendrier</template>
    </side-bar>
    <main>
      <div v-if="display === 1" class="display mon-compte">
        <div class="top">
          <h1>Mon compte</h1>
          <button>Modifier mes informations</button>
        </div>
        <div class="info">
          <img src="/icons/profile.svg" alt="profile">
          <div>
            <p><strong>Nom d'utilisateur :</strong>{{ user.prenom }} {{ user.nom }} </p>
            <p><strong>Email :</strong> {{ user.mail }}</p>
          </div>
        </div>
      </div>
      <div v-if="display === 2" class="display emissions">
        <h1>Toutes les émissions</h1>
        <popup-emission :emission="emissionToDisplay" v-if="showPopupEmission" @close="showPopupEmission = false"
                        @edited="updateEmission"></popup-emission>
        <div class="emissions-liste">
          <emission :edit="true" @edit="displayEmission(emission.id)" v-for="emission in emissions" :emission="emission"
                    :key="emission.id"></emission>
        </div>
      </div>
    </main>
  </div>


</template>

<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";

.display {
  padding: 2em 3em;

  h1 {
    @include text-style(1.5em, inherit, 700);
    margin: 0;
  }

  h2 {
    @include text-style(1.25em, inherit, 600);
    margin-top: 1em;
  }
}

.view {
  @include flex(column, nowrap, 0, start, stretch);

  main {
    background-color: $lightLightGrey;
    flex-basis: 80vw;
    flex-shrink: 1;
    flex-grow: 0;
  }
}

.mon-compte {
  min-height: 40vh;

  @include flex(column, nowrap, 3em, start, center);

  .top {
    @include flex(column, nowrap, .5em, start, center);
    text-align: center;

    h1 {
      margin: 0
    }

    button {
      @include buttonStyle($purple, $purple, $white, fit-content, .8em)
    }
  }

  .info {
    @include flex(row, nowrap, 1em, center, center);

    img {
      height: 5em;
      border-radius: 50%;
      margin-right: 1em;
    }

    p {
      @include text-style(1em, inherit, 400);
      margin-bottom: .25em;
      margin-top: .25em;
      text-align: center;
    }
  }
}

.emissions-liste {
  @include grid(repeat(auto-fit, 13em), auto, 1em, start, center);
}

@media screen and (min-width: 800px) {
  .display {
    h1 {
      @include text-style(2em, inherit, 700);
      margin-bottom: 1em;
    }

    h2 {
      @include text-style(1.5em, inherit, 600);
      margin-top: 1em;
    }
  }
  .view {
    @include flex(row, nowrap, 0, start, stretch);
    min-height: 60vh;

    main {
      flex-basis: 80vw;
      flex-shrink: 1;
      flex-grow: 0;
    }
  }
  .mon-compte {
    @include flex(column, nowrap, 2em, start);

    .top {
      @include flex(row, wrap, 2em, space-between, center);

      button {
        @include buttonStyle($purple, $purple, $white);
        flex: 0 0 fit-content;
      }
    }

    .info {
      @include flex(row, wrap, 2em, start, center);

      div {
        @include flex(column, nowrap, 1em, start, flex-start);
      }

      p {
        @include text-style(1.3em, inherit, 400);
      }

      img {
        height: 6em
      }
    }
  }
}


</style>