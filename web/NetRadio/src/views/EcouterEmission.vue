<template>
  <audio id="audio" controls></audio>

  <div id="container">
    <div class="direct-infos">
      <div class="direct-infos-titre">
        <embed src="/icons/direct.svg"/>
                  <h1>{{ emission.titre }}</h1>
      </div>

      <h2 v-if="getUserRole() === '1'" id="title">Ecouter votre émission en direct</h2>
      <h2 v-else id="title">Enregistrer votre émission en direct</h2>

      <button v-if="getUserRole() === '1'" type="button" @click="startStreaming">Écouter l'émission</button>
      <button v-else type="button" @click="startStreaming">Commencer l'émission</button>

      <button v-if="getUserRole() !== '1'" type="button" @click="stopStreaming">Arrêter et sauvegarder l'émission</button>

      <div id="conference">
        <div id="remote-container"></div>
        <div id="local-container"></div>
      </div>
    </div>
  </div>

</template>

<script>
import {ref, onMounted, onUnmounted} from "vue";
import {UserAgent, Session} from '@apirtc/apirtc'
import {useUserStore} from "@/stores/user.js";
import {useRoute} from "vue-router";
import {mapState} from "pinia";
import axios from "axios";

export default {
  data() {
    return {
      emission: [],
      userRole: null
    }
  },
  methods: {
    getUserRole() {
      console.log(this.user);
      return this.user.role
    }
  },

  computed: {
    ...mapState(useUserStore, ['user', 'tokens', 'loggedIn']),
  },

  created() {
    let route = useRoute();
    this.$api.get(`/emissions/${route.params.id}`)
        .then((response) => {
          this.emission = response.data.emission;
        })
        .catch((error) => {
          console.log(error)
        });
  },


  setup() {
    const localStream = ref(null);
    const conversation = ref(null);
    const audioContext = ref(null);
    const mediaStreamSource = ref(null);
    const mediaRecorder = ref(null);
    const isStreaming = ref(false);
    const recordedChunks = ref([]);
    const route = useRoute();


    let tokens = ref({access_token: null});
    onMounted(() => {
      // this.userRole = useUserStore().user.role;
      tokens.access_token = useUserStore().tokens.access_token;
    });


    const ua = new UserAgent({
      uri: "apzkey:myDemoApiKey",
    });

    const connectToServer = async () => {
      try {
        const stream = await navigator.mediaDevices.getUserMedia({audio: true});
        audioContext.value = new (window.AudioContext || window.webkitAudioContext)();
        mediaStreamSource.value = audioContext.value.createMediaStreamSource(stream);
        mediaRecorder.value = new MediaRecorder(stream);
        // console.log(mediaStreamSource.value);
        mediaRecorder.value.ondataavailable = (event) => {
          if (event.data.size > 0) {
            recordedChunks.value.push(event.data);
            // console.log(event.data);
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
                // recordedChunks.value.push((stream.getStream(streamInfo.streamId))); // TODO: peut etre faire quelque chose de ce style
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

    const getEmission = async () => {
      try {
        console.log(route.params.id)
        const response = await axios.get(`http://localhost:2080/emissions/${route.params.id}`);
        return response.data.emission;
      } catch (error) {
        console.error(error);
        return null;
      }
    };


    const stopStreaming = async () => {
      if (mediaRecorder.value && isStreaming.value) {
        mediaRecorder.value.stop();
        isStreaming.value = false;
        const blob = new Blob(recordedChunks.value, {type: "audio/wav"});

        let url = window.URL.createObjectURL(blob);
        // url = url.replace("blob:", "");

        const audio = document.getElementById("audio");
        audio.src = url;

        const currentDate = new Date();
        const fileName = `recording-${currentDate.getFullYear()}-${currentDate.getMonth() + 1}-${currentDate.getDate()}_${currentDate.getHours()}-${currentDate.getMinutes()}-${currentDate.getSeconds()}.wav`;

        const emission = await getEmission();
        console.log(emission);
        if (emission) {

          const currentDate = new Date();
          const year = currentDate.getFullYear();
          const month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
          const day = ('0' + currentDate.getDate()).slice(-2);

          const formattedDate = `${year}-${month}-${day}`;

          axios.post('http://localhost:2080/podcasts', JSON.stringify({
                "titre": emission.titre,
                "description": emission.description,
                "duree": "00:00:00",
                "date": formattedDate,
                "audio": fileName,
                "photo": emission.photo,
                "emission_id": emission.id
              }),
              {
                headers: {
                  "Content-Type": "application/json",
                  Authorization: `Bearer ${tokens.access_token}`
                  // "Access-Control-Allow-Origin": "*"
                }
              }
          )
              .then((response) => {
                console.log(response);
                downloadWav(blob);
                window.removeEventListener("beforeunload", beforeUnloadHandler);
              })
              .catch((error) => {
                console.error("Error creating podcast:", error);
                window.removeEventListener("beforeunload", beforeUnloadHandler);
              });
        }
      }
    };


    const beforeUnloadHandler = (event) => {
      if (mediaRecorder.value && isStreaming.value) {
        event.preventDefault();
        event.returnValue = "";
      }
    };

    const downloadWav = (blob) => {
      const url = window.URL.createObjectURL(blob);
      // Création du lien de téléchargement
      const downloadLink = document.createElement('a');
      downloadLink.href = url;
      const currentDate = new Date();
      const fileName = `recording-${currentDate.getFullYear()}-${currentDate.getMonth() + 1}-${currentDate.getDate()}_${currentDate.getHours()}-${currentDate.getMinutes()}-${currentDate.getSeconds()}.wav`;
      downloadLink.download = fileName;
      downloadLink.innerHTML = 'Télécharger le podcast'; // Texte du lien
      document.body.appendChild(downloadLink);
      downloadLink.click();

      // const a = document.createElement("a");
      // a.style.display = "none";
      // a.href = url;
      // a.download = "recording.wav";
      // document.body.appendChild(a);
      // a.click();
      // window.URL.revokeObjectURL(url);
    };


    const userStore = useUserStore();
    const getRoleUser = () => {
      console.log(userStore.user.role);
      return userStore.user.role;
    };

    const startListening = async () => {
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

      const joinResponse = await conversationInstance.join();
      console.log("Conversation joined", joinResponse);
    };

    onMounted(() => {
      if (getRoleUser() === 2) {
        startStreaming();
      } else if (getRoleUser() === 1) {
        connectToServer();
        startListening();
      }
    });


    onUnmounted(() => {
      stopStreaming();
      window.removeEventListener("beforeunload", beforeUnloadHandler);
    });

    return {stopStreaming, localStream, conversation, startStreaming, getRoleUser};
  },
};
</script>

<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";

input {
  width: 25%;
}

button {
  background-color: #A568BB;
  color: white;
  margin-bottom: 10px;
  cursor: pointer;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  font-size: 1rem;
}

.direct {
  color: white;
  background-color: #334155;
  padding: 1.5rem;
  @include flex(column, nowrap, 2vh, space-between);

  &-infos-titre {
    h1 {
      @include text-style(2rem, inherit, bold);
      display: inline-block;
      margin: 0;
    }

    embed {
      height: 1.5rem;
      display: inline-block;
      margin-right: .5em;
    }
  }

  &-infos-sous-titre {
    margin-top: .5rem;
    margin-bottom: 2rem;
    @include text-style(1em, inherit, 100);
  }

  &-infos-desc {
    text-align: justify;
  }

  button {
    @include buttonStyle($purple, $purple, white, auto, 1em, 1.5em 0em .5em 0em, 0px);
    font-weight: 500;
  }

  img {
    border-radius: 10px;
  }


  @media screen and (min-width: 700px) and (max-width: 1024px) {
    .direct {
      padding: 2rem;
      @include flex(row, nowrap, 4vw, space-between);

      &-infos-titre {
        @include grid(1fr 8fr);

        h1 {
          @include text-style(4vw, inherit, bold);
        }

        embed {
          height: 3vw;
        }
      }

      &-infos-sous-titre {
        @include text-style(2.5vw, inherit, 100);
        margin-bottom: .5em
      }

      &-infos-desc {
        text-align: justify;
        @include text-style(1em, inherit, normal);
        margin-bottom: 1em;
      }

      button {
        @include buttonStyle($purple, $purple, white, auto, 1em, .5em 0em .5em 0em, 0px);
      }

      img {
        width: 45vw;
        height: auto
      }
    }
  }

  @media screen and (min-width: 1024px) {
    .direct {
      padding: 3rem;
      @include flex(row, nowrap, 5vw, space-between);

      &-infos-titre {
        @include grid(1fr 15fr);

        h1 {
          @include text-style(2.5em, inherit, bold);
        }

        embed {
          height: 2em;
        }
      }

      &-infos-sous-titre {
        @include text-style(1.5em, inherit, 100);
      }

      &-infos-desc {
        text-align: justify;
        @include text-style(1.2em, inherit, normal);
        margin-bottom: 2em;
      }

      button {
        @include buttonStyle($purple, $purple, white, auto, 1.2em, .5em 0em .5em 0em, 0px);
      }

      img {
        width: 30vw;
        height: auto;
      }
    }
  }
}
</style>