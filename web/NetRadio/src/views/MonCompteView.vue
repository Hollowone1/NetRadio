<script>
import PopupEmission from "@/components/PopupEmission.vue";
import PopupUtilisateur from "@/components/PopupUtilisateur.vue";
import PopupPlaylist from "@/components/PopupPlaylist.vue";
import Emission from '@/components/Emission.vue'
import SideBar from "@/components/SideBarComponent.vue";
import {mapState, mapActions} from "pinia";
import {useUserStore} from "@/stores/user.js";
import {jwtDecode} from "jwt-decode";

export default {
  components: {
    PopupEmission,
    Emission,
    SideBar,
    PopupUtilisateur,
    PopupPlaylist
  },
  data() {
    return {
      showPopupEmission: false,
      showPopupUser: false,
      showPopUpPlaylist: false,
      emissionToDisplay: {},
      userToDisplay: {},
      playlistToDisplay: {},
      display: 1,
      emissions: [],
      users: [],
      playlists: [],
      roles: ['Auditeur', 'Animateur', 'Administrateur']

    }
  },
  computed: {
    ...mapState(useUserStore, ['user', 'tokens', 'loggedIn'])
  },
  created() {
    const mail = jwtDecode(this.tokens.access_token).upr.email
    this.$api.get(`/users/mail/${mail}`, {
      headers: {
        Authorization: `Bearer ${this.tokens.access_token}`
      }
    })
        .then((response) => {
          //console.log(response.data)
          this.setUser(response.data.user)
        })
        .catch((error) => {
          console.log(error)
        });

    this.user.role === '3' ? this.getUsers() : null
    this.user.role === '3' ? this.getEmissions() : null
    this.user.role === '2' ? this.getPlaylists() : null

  },
  methods: {
    ...mapActions(useUserStore, ['setUser']),
    getUsers() {
      this.$api.get('/users')
          .then((response) => {
            this.users = response.data.users
          })
          .catch((error) => {
            console.log(error)
          })
    },
    getEmissions() {
      this.$api.get('/emissions')
          .then((response) => {
            this.emissions = response.data.emission
            this.emissions.forEach(emission => {
              this.$api.get(emission.links.users.href)
                  .then((response2) => {
                    emission.user = `${response2.data.user[0].nom} ${response2.data.user[0].prenom}`
                  })
                  .catch((error) => {
                    console.log(error)
                  });
            });
          })
          .catch((error) => {
            console.log(error)
          })
    },
    getEmissionByUser() {

    },
    getPlaylists() {
      this.$api.get(`/user/${this.user.email}/playlists`)
          .then((response) => {
            this.playlists = response.data
          })
          .catch((error) => {
            console.log(error.response.data)
          })
    },
    changeDisplay(number) {
      this.display = number;
    },
    displayEmission(id) {
      this.emissionToDisplay = this.emissions.find(emission => emission.id === id);
      this.showPopupEmission = true;
    },
    updateEmission() {
      this.showPopupEmission = false;
      this.getEmissions()
    },
    displayUser(email) {
      this.userToDisplay = this.users.find(user => user.email === email);
      this.showPopupUser = true;
    },
    updateUser() {
      this.showPopupUser = false;
      this.getUsers()
    },
    displayPlaylist(id) {
      this.playlistToDisplay = this.playlists.find(playlist => playlist.id === id);
      this.showPopUpPlaylist = true;
    },
    updatePlaylists() {
      this.showPopUpPlaylist = false;
      this.getPlaylists()
    },
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
            <p><strong>Nom d'utilisateur : </strong> {{ user.username }}</p>
            <p><strong>Email :</strong> {{ user.email }}</p>
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
      <template v-slot:2>Mes playlists</template>
      <template v-slot:3>Mon émission</template>
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
            <p><strong>Nom d'utilisateur : </strong>{{ user.username }} </p>
            <p><strong>Email :</strong> {{ user.email }}</p>
          </div>
        </div>
      </div>
      <div v-if="display === 2" class="display playlists">
        <div class="top">
          <h1>Mes playlists</h1>
          <img src="/icons/ajouter.svg" alt="add icon">
        </div>
        <div class="playlists-liste">
          <section class="playlist">
            <div class="top">
              <p>Les hits de Noël</p>
              <img @click="displayPlaylist(1)" src="/icons/editPurple.svg" alt="play icon">
            </div>
            <div class="playlist-info">
              <p>Tous les classiques de Noël sont à retrouver dans cette playlist.</p>
            </div>
          </section>
          <section class="playlist">
            <div class="top">
              <p>Les hits de Noël</p>
              <img @click="displayPlaylist(1)" src="/icons/editPurple.svg" alt="play icon">
            </div>
            <div class="playlist-info">
              <p>Tous les classiques de Noël sont à retrouver dans cette playlist.</p>
            </div>
          </section>
          <section class="playlist">
            <div class="top">
              <p>Les hits de Noël</p>
              <img @click="displayPlaylist(1)" src="/icons/editPurple.svg" alt="play icon">
            </div>
            <div class="playlist-info">
              <p>Tous les classiques de Noël sont à retrouver dans cette playlist.</p>
            </div>
          </section>
          <section class="playlist" v-for="playlist in playlists">
            <div class="top">
              <p>{{ playlist.name }}</p>
              <img @click="displayPlaylist(playlist.id)" src="/icons/editPurple.svg" alt="play icon">
            </div>
            <div class="playlist-info">
              <p>{{ playlist.description }}</p>
            </div>
          </section>
        </div>
      </div>
      <div v-if="display === 3" class="display mon-emission">
        <div class="top">
          <h1>Mon émission</h1>
          <img src="/icons/editPurple.svg" alt="add icon">
        </div>
      </div>
    </main>
  </div>


  <div class="view" v-if="user.role === `3`">
    <side-bar @change="changeDisplay">
      <template v-slot:1>Mon compte</template>
      <template v-slot:2>Émissions</template>
      <template v-slot:3>Calendrier</template>
      <template v-slot:4>Utilisateurs</template>
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
            <p><strong>Nom d'utilisateur : </strong>{{ user.username }} </p>
            <p><strong>Email :</strong> {{ user.email }}</p>
          </div>
        </div>
      </div>
      <div v-if="display === 2" class="display emissions">
        <h1>Toutes les émissions</h1>
        <popup-emission :emission="emissionToDisplay" v-if="showPopupEmission" @close="showPopupEmission = false"
                        @edited="updateEmission"></popup-emission>
        <div class="emissions-liste">
          <emission :redirect="false" :edit="true" @edit="displayEmission(emission.id)" v-for="emission in emissions"
                    :emission="emission"
                    :key="emission.id"></emission>
        </div>
      </div>
      <div v-if="display === 4" class="display users">
        <h1>Tous les utilisateurs</h1>
        <popup-utilisateur :user="userToDisplay" v-if="showPopupUser" @close="showPopupUser = false"
                           @edited="updateUser"></popup-utilisateur>
        <div class="users-liste">
          <section v-for="user in users" class="user">
            <div class="top">
              <p>{{ roles[user.role - 1] }}</p>
              <img @click="displayUser(user.email)" src="/icons/editPurple.svg" alt="play icon">
            </div>
            <div class="user-info">
              <p><strong>{{ user.nom }}</strong> {{ user.prenom }}</p>
              <p>{{ user.email }}</p>
            </div>
          </section>
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

.playlists {
  .top {
    @include flex(row, nowrap, .5em, space-between, center);
    img {
      height: 2.5em;
    }
  }
}


.top {
  @include flex(column, nowrap, .5em, start, center);
  text-align: center;

  h1 {
    margin: 0
  }

  img {
    height: 2em;
  }

  button {
    @include buttonStyle($purple, $purple, $white, fit-content, .8em)
  }
}

.mon-compte {
  min-height: 40vh;

  @include flex(column, nowrap, 3em, start, center);

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

.users-liste {
  @include grid(repeat(auto-fill, minmax(15em, 1fr)), auto, 1em, center, center);
}

.playlists-liste {
  @include grid(repeat(auto-fill, minmax(20em, 1fr)), auto, 1em, center, center);

}

.playlist {
  @include flex(column, nowrap, .5em, start, stretch);
  background-color: $white;
  border-radius: 10px;
  padding: 1em .7em;
  border: 2px solid $lightGrey;
  .top {
    @include flex(row, nowrap, 1em, space-between, center);
    padding-bottom: .5em;
    margin-bottom : 0;

    img {
      height: 1.5em;
    }

    p {
      margin: 0;
      @include text-style(1.2em, $purple, 400);
      text-transform: uppercase;
    }
  }
  p {
    @include text-style(1em, inherit, 300);
    margin: 0;

  }
}

.user {
  @include flex(column, nowrap, 0, start, stretch);
  background-color: $white;
  border-radius: 10px;
  padding: 1em .7em;
  border: 2px solid $lightGrey;

  .top {
    @include flex(row, nowrap, 1em, space-between, center);
    padding-bottom: .5em;

    img {
      height: 1.5em;
    }

    p {
      margin: 0;
      @include text-style(1em, $purple, 200);
      text-transform: uppercase;
    }
  }

  .user-info {
    @include flex(column, nowrap, .5em, start);

    p {
      @include text-style(1.1em, inherit, 300);

      strong {
        @include text-style(1em, inherit, 700);
        text-transform: uppercase;
      }
    }
  }
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


  .top {
    @include flex(row, wrap, 2em, space-between, center);
    margin-bottom: 1em;

    h1 {
      margin: 0
    }

    button {
      @include buttonStyle($purple, $purple, $white);
      flex: 0 0 fit-content;
    }
  }

  .mon-compte {
    @include flex(column, nowrap, 2em, start);

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