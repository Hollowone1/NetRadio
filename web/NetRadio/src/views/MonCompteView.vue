<script>
import PopupEmission from "@/components/PopupEmission.vue";
import PopupUtilisateur from "@/components/PopupUtilisateur.vue";
import PopupPlaylist from "@/components/PopupPlaylist.vue";
import Calendar from "@/components/Calendar.vue";
import Creneaux from "@/components/creneaux.vue";
import Emission from '@/components/Emission.vue'
import SideBar from "@/components/SideBarComponent.vue";
import {mapState, mapActions} from "pinia";
import {useUserStore} from "@/stores/user.js";
import {jwtDecode} from "jwt-decode";
import axios from "axios";
import {ref, onMounted, onUnmounted} from "vue";
import {UserAgent, Session} from '@apirtc/apirtc'



export default {
  components: {
    PopupEmission,
    Emission,
    SideBar,
    PopupUtilisateur,
    PopupPlaylist,
    Calendar,
    Creneaux
  },
  data() {
    return {
      showPopupEmission: false,
      showPopUpNewEmission: false,
      showPopupUser: false,
      showPopUpPlaylist: false,
      showPopUpNewPlaylist: false,
      emissionToDisplay: {},
      userToDisplay: {},
      playlistToDisplay: {},
      display: 1,
      emissions: [],
      users: [],
      playlists: [],
      creneaux : [],
      roles: ['Auditeur', 'Animateur', 'Administrateur'],
      emissionsOfUser: [],
    }
  },
  computed: {
    ...mapState(useUserStore, ['user', 'tokens', 'loggedIn']),
  },
  created() {
    const mail = jwtDecode(this.tokens.access_token).upr.email
    this.$api.get(`/users/mail/${mail}`, {
      headers: {
        Authorization: `Bearer ${this.tokens.access_token}`
      }
    })
        .then((response) => {
          this.setUser(response.data.user)
        })
        .catch((error) => {
          console.log(error.response.data.exception)
          if (error.response.data.exception[0].code === 401) {
            this.$router.push('/connexion')
            this.logoutUser()
          }
          //refresh le token ici
        });

    this.user.role === '3' ? this.getUsers() : null
    this.user.role === '3' ? this.getEmissions() : null
    this.user.role === '2' ? this.getPlaylists() : null
    this.user.role === '2' ? this.getEmissionByUser() : null


  },
  
  methods: {
    ...mapActions(useUserStore, ['setUser', 'logoutUser']),
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
                    emission.email = response2.data.user[0].email
                  })
                  .catch((error) => {
                    console.log(error)
                  });
            });
            console.log("emissions", this.emissions)
          })
          .catch((error) => {
            console.log(error)
          })
    },
    getEmissionByUser() {
      this.$api.get(`/emissions?email=${this.user.email}`)
          .then((response) => {
            this.emissionsOfUser = response.data.emission
          })
          .catch((error) => {
            console.log(error)
          })
    },
    getPlaylists() {
      this.$api.get(`/users/${this.user.email}/playlists`, {
        headers: {
          Authorization: `Bearer ${this.tokens.access_token}`
        }
      })
          .then((response) => {
            this.playlists = response.data.playlists
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
      this.showPopUpNewEmission = false;
      console.log(this.emissionToDisplay)
      const index = this.emissions.findIndex(emission => emission.id === this.emissionToDisplay.id);
      this.$api.get(`/emissions/${this.emissionToDisplay.id}`)
          .then((response) => {
            if (index !== -1) {
              this.emissions.splice(index, 1, response.emission);
            }
          })
          .catch((error) => {
            console.log(error)
          })
      //this.getEmissions()
    },
    

    displayUser(email) {
      this.userToDisplay = this.users.find(user => user.email === email);
      this.showPopupUser = true;
    },
    updateUser() {
      console.log("updateUser donc edited!")
      this.showPopupUser = false;
      this.getUsers()
    },
    displayPlaylist(id) {
      this.playlistToDisplay = this.playlists.find(playlist => playlist.id === id);
      this.showPopUpPlaylist = true;
    },
    addPlaylist() {
      this.showPopUpNewPlaylist = true;
    },
    addEmission() {
      this.showPopUpNewEmission = true;
    },
    updatePlaylist() {
      this.showPopUpPlaylist = false;
      this.showPopUpNewPlaylist = false;
      this.getPlaylists()
    },

    getCreneaux () {
      // BUT ici est de récupérer les créneaux
      this.$api.get('/creneaux')
          .then((response) => {
            this.creneaux = response.data.emission
            this.creneaux.forEach(emission => {
              this.$api.get(emission.links.users.href)
                  .then((response2) => {
                    emission.user = `${response2.data.user[0].nom} ${response2.data.user[0].prenom}`
                    emission.email = response2.data.user[0].email
                  })
                  .catch((error) => {
                    console.log(error)
                  });
            });
            console.log("creneaux", this.creneaux)
          })
          .catch((error) => {
            console.log(error)
          })
    } },


 

  setup() {
    const localStream = ref(null);
    const conversation = ref(null);
    const audioContext = ref(null);
    const mediaStreamSource = ref(null);
    const mediaRecorder = ref(null);
    const isStreaming = ref(false);
    const recordedChunks = ref([]);

    const ua = new UserAgent({
      uri: "apzkey:myDemoApiKey",
    });

    const connectToServer = async () => {
      try {
        const stream = await navigator.mediaDevices.getUserMedia({audio: true});
        audioContext.value = new (window.AudioContext || window.webkitAudioContext)();
        mediaStreamSource.value = audioContext.value.createMediaStreamSource(stream);
        mediaRecorder.value = new MediaRecorder(stream);
        mediaRecorder.value.ondataavailable = (event) => {
          if (event.data.size > 0) {
            recordedChunks.value.push(event.data);
          }
        };
      } catch (error) {
        console.error("Error accessing microphone:", error);
      }
    };

    const startStreaming = async () => {
      await connectToServer();
      const session = await ua.register();
      const conversationInstance = session.getConversation('myConversation');
      conversation.value = conversationInstance;

      conversationInstance.on("streamListChanged", (streamInfo) => {
        if (streamInfo.listEventType === "added" && streamInfo.isRemote === true) {
          conversationInstance.subscribeToMedia(streamInfo.streamId)
              .then((stream) => {
                console.log("subscribeToMedia success", stream);
              })
              .catch((err) => {
                console.error("subscribeToMedia error", err);
              });
        }
      });

      conversationInstance
          .on("streamAdded", (stream) => {
            stream.addInDiv("remote-container", "remote-media-" + stream.streamId, {}, false);
          })
          .on("streamRemoved", (stream) => {
            stream.removeFromDiv("remote-container", "remote-media-" + stream.streamId);
          });

      const createStream = await ua.createStream({
        constraints: {
          audio: true,
          video: false,
        },
      });

      localStream.value = createStream;
      createStream.removeFromDiv("local-container", "local-media");
      createStream.addInDiv("local-container", "local-media", {}, true);

      const joinResponse = await conversationInstance.join();
      console.log("Conversation joined", joinResponse);

      const publishResponse = await conversationInstance.publish(localStream.value);
      console.log("published", publishResponse);

      isStreaming.value = true;
    };

    const stopStreaming = () => {
      if (mediaRecorder.value && isStreaming.value) {
        mediaRecorder.value.stop();
        isStreaming.value = false;

        const blob = new Blob(recordedChunks.value, {type: "audio/wav"});
        const emission = getEmission(); // This function needs to be defined
        if (emission) {
          const body = {
            titre: emission.titre,
            description: emission.description,
            audio: blob,
            emission_id: emission.id,
          };
          axios.post("http://localhost:2080/podcasts", body)
              .then((response) => {
                console.log(response);
              })
              .catch((error) => {
                console.error(error);
              });
        }
        downloadWav();
      }
    };

    const downloadWav = () => {
      if (recordedChunks.value.length > 0) {
        const blob = new Blob(recordedChunks.value, {type: 'audio/wav'});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `emission${this.$route.params.id}.wav`;
        a.click();
        URL.revokeObjectURL(url);
      }
    };

    const getEmission = async () => {
      try {
        const response = await axios.get(`http://localhost:2080/emissions/${this.$route.params.id}`);
        return response.data.emission;
      } catch (error) {
        console.error(error);
        return null;
      }
    };

    onMounted(() => {
      startStreaming();
    });

    onUnmounted(() => {
      stopStreaming();
    });

    return {stopStreaming, localStream, conversation, startStreaming, downloadWav};
  }
}


</script>

<template>
  <div class="view" v-if="user.role === `1`">
    <side-bar @change="changeDisplay">
      <template v-slot:1>Mon compte</template>
      <template v-slot:2>Enregistrements</template>
      <template v-slot:3>Calendrier</template>
    </side-bar>
    <main>
      <div v-if="display === 1" class="display mon-compte">
        <div class="top">
          <h1>Mon compte</h1>
        </div>
        <div class="info">
          <img src="/icons/profile.svg" alt="profile">
          <div>
            <p><strong>Nom et prénom : </strong> {{ user.nom }} {{ user.prenom }}</p>
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
      <div v-if="display === 3" class="display mon-compte">
        <div class="top">
          <h1>Calendrier</h1>
        </div>
        <div class="info">
          <Calendar :creneaux="creneaux" @dayclick="onDayClick"/>
        </div>
        <Creneaux :selectedDate="selectedDate" />
        <creneaux v-for="creneaux in creneaux" :Creneaux="creneaux" :key="creneaux.id"></creneaux>

      </div>
    </main>
  </div>


  <div class="view" v-if="user.role === `2`">
    <side-bar @change="changeDisplay">
      <template v-slot:1>Mon compte</template>
      <template v-slot:2>Mes playlists</template>
      <template v-slot:3>Mes émissions</template>
      <template v-slot:4>Lancer un direct</template>
    </side-bar>
    <main>
      <div v-if="display === 1" class="display mon-compte">
        <div class="top">
          <h1>Mon compte</h1>
        </div>
        <div class="info">
          <img src="/icons/profile.svg" alt="profile">
          <div>
            <p><strong>Nom et prénom : </strong> {{ user.nom }} {{ user.prenom }}</p>
            <p><strong>Nom d'utilisateur : </strong>{{ user.username }} </p>
            <p><strong>Email :</strong> {{ user.email }}</p>
          </div>
        </div>
      </div>
      <div v-if="display === 2" class="display playlists">
        <div class="top">
          <h1>Mes playlists</h1>
          <img @click="addPlaylist" src="/icons/ajouter.svg" alt="add icon">
        </div>
        <popup-playlist newOne v-if="showPopUpNewPlaylist" @close="showPopUpNewPlaylist = false"
                        @created="updatePlaylist"></popup-playlist>
        <popup-playlist :playlist="playlistToDisplay" v-if="showPopUpPlaylist" @close="showPopUpPlaylist = false"
                        @edited="updatePlaylist"></popup-playlist>
        <div class="playlists-liste">
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
          <h1>Mes émissions</h1>
        </div>
        <div v-if="emissionsOfUser.length > 0" class="emissions-liste">
          <emission v-for="emission in emissionsOfUser" :emission="emission" :key="emission.id"></emission>
        </div>
        <div v-else class="emissions-liste"> Pas encore d'émission ? Contactez un admnistrateur !</div>
        <p class="info-nv">Pour créer une nouvelle émission ou modifier une existante, veuillez contacter un administrateur.</p>
      </div>
      <div v-if="display === 4" class="display lancer-direct">
        <div class="top">
          <h1>Lancer un direct</h1>
        </div>
        <div class="mon-direct">
          <section class="direct">
            <div id="container">

              <div class="direct-infos">
                <div class="direct-infos-titre">
                  <embed src="/icons/direct.svg"/>
                  <h1>{{ emission.titre }}</h1>
                </div>
                <h2 id="title">Enregistrer votre émission en direct</h2>
                <form id="create">
                  <input
                      type="text"
                      name="conference_name"
                      id="conference-name"
                      placeholder="Entrez le nom de votre émission"
                      autocomplete="off"
                  />
                  <button type="submit" id="create_conference">
                    Commencer l'émission
                  </button>
                  <button type="submit" @click="stopStreaming">Arrêter et sauvegarder l'émission</button>
                </form>

                <div id="conference">
                  <div id="remote-container"></div>
                  <div id="local-container"></div>
                </div>
              </div>
            </div>
          </section>
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
        </div>
        <div class="info">
          <img src="/icons/profile.svg" alt="profile">
          <div>
            <p><strong>Nom et prénom : </strong> {{ user.nom }} {{ user.prenom }}</p>
            <p><strong>Nom d'utilisateur : </strong>{{ user.username }} </p>
            <p><strong>Email :</strong> {{ user.email }}</p>
          </div>
        </div>
      </div>
      <div v-if="display === 2" class="display emissions">
        <div class="top">
          <h1>Toutes les émissions</h1>
          <img @click="addEmission" src="/icons/ajouter.svg" alt="add icon">
        </div>
        <popup-emission newOne v-if="showPopUpNewEmission" @close="showPopUpNewEmission = false"
                        @created="updateEmission"></popup-emission>
        <popup-emission :emission="emissionToDisplay" v-if="showPopupEmission" @close="showPopupEmission = false"
                        @edited="updateEmission"></popup-emission>
        <div class="emissions-liste">
          <emission :redirect="false" :edit="true" @edit="displayEmission(emission.id)" v-for="emission in emissions"
                    :emission="emission"
                    :key="emission.id"></emission>
        </div>
      </div>

      <div v-if="display === 3" class="display calendrier">
        <Calendar :columns="columns" @dayclick="onDayClick"/>
        
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

.info-nv {
  margin-top: 1em;
}

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
    margin-bottom: 0;

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
      //flex-basis: 80vw;
      flex-basis: 100vw;
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
        height: 7em
      }
    }
  }
}


</style>