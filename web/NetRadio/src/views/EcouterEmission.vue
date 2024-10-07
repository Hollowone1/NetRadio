<template>
  <audio id="audio" controls></audio>

  <div id="container">
    <div class="direct-infos">
      <div class="direct-infos-titre">
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
import { ref, onMounted, onUnmounted } from "vue";
import { UserAgent, Session } from '@apirtc/apirtc';
import { useUserStore } from "@/stores/user.js";
import { useRoute } from "vue-router";
import { mapState } from "pinia";
import axios from "axios";

export default {
  data() {
    return {
      emission: [],
      userRole: null
    };
  },
  methods: {
    getUserRole() {
      return this.user.role;
    }
  },
  computed: {
    ...mapState(useUserStore, ['user', 'tokens', 'loggedIn']),
  },
  async created() {
    let route = useRoute();
    try {
      const response = await this.$api.get(`/emissions/${route.params.id}`);
      this.emission = response.data.emission;
    } catch (error) {
      console.log(error);
    }
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
    const tokens = ref({ access_token: null });

    const userStore = useUserStore();
    const getRoleUser = () => {
      return userStore.user.role;
    };

    // Fonction pour se connecter au serveur et gérer le microphone
    const connectToServer = async () => {
      try {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        audioContext.value = new (window.AudioContext || window.webkitAudioContext)();
        mediaStreamSource.value = audioContext.value.createMediaStreamSource(stream);
        mediaRecorder.value = new MediaRecorder(stream);
        mediaRecorder.value.ondataavailable = (event) => {
          if (event.data.size > 0) {
            recordedChunks.value.push(event.data);
          }
        };
      } catch (error) {
        console.error("Error accessing microphone or media devices:", error);
        alert("Veuillez accorder l'accès au microphone pour diffuser ou écouter l'émission.");
      }
    };

    const ua = new UserAgent({
      uri: "apzkey:myDemoApiKey",
    });

    // Fonction pour démarrer le streaming
    const startStreaming = async () => {
      try {
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
      } catch (error) {
        console.error("Error during streaming:", error);
      }
    };

    const getEmission = async () => {
      try {
        const response = await axios.get(`http://localhost:2080/emissions/${route.params.id}`);
        return response.data.emission;
      } catch (error) {
        console.error("Error fetching emission:", error);
        return null;
      }
    };

    const stopStreaming = async () => {
      if (mediaRecorder.value && isStreaming.value) {
        mediaRecorder.value.stop();
        isStreaming.value = false;
        const blob = new Blob(recordedChunks.value, { type: "audio/wav" });
        const url = window.URL.createObjectURL(blob);
        const audio = document.getElementById("audio");
        audio.src = url;

        const currentDate = new Date();
        const fileName = `recording-${currentDate.getFullYear()}-${currentDate.getMonth() + 1}-${currentDate.getDate()}_${currentDate.getHours()}-${currentDate.getMinutes()}-${currentDate.getSeconds()}.wav`;

        const emission = await getEmission();
        if (emission) {
          const formattedDate = `${currentDate.getFullYear()}-${('0' + (currentDate.getMonth() + 1)).slice(-2)}-${('0' + currentDate.getDate()).slice(-2)}`;

          axios.post('http://localhost:2080/podcasts', JSON.stringify({
            "titre": emission.titre,
            "description": emission.description,
            "duree": "00:00:00",
            "date": formattedDate,
            "audio": fileName,
            "photo": emission.photo,
            "emission_id": emission.id
          }), {
            headers: {
              "Content-Type": "application/json",
              Authorization: `Bearer ${tokens.access_token}`
            }
          })
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

    const downloadWav = (blob) => {
      const url = window.URL.createObjectURL(blob);
      const downloadLink = document.createElement('a');
      downloadLink.href = url;
      const currentDate = new Date();
      const fileName = `recording-${currentDate.getFullYear()}-${currentDate.getMonth() + 1}-${currentDate.getDate()}_${currentDate.getHours()}-${currentDate.getMinutes()}-${currentDate.getSeconds()}.wav`;
      downloadLink.download = fileName;
      downloadLink.innerHTML = 'Télécharger le podcast';
      document.body.appendChild(downloadLink);
      downloadLink.click();
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

    onMounted(async () => {
      await userStore.$patch(); // Charge les données utilisateur avant de commencer
      const role = getRoleUser();

      if (role === 2) {
        startStreaming();
      } else if (role === 1) {
        connectToServer();
        startListening();
      }
    });

    onUnmounted(() => {
      stopStreaming();
      window.removeEventListener("beforeunload", beforeUnloadHandler);
    });

    return { stopStreaming, localStream, conversation, startStreaming, getRoleUser };
  },
};
</script>


<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";

#container {
  display: flex;
  flex-direction: column;
  align-items: center; 
  justify-content: center;
}

audio {
  display: block;
  margin: 2rem auto;
  width: 100%; 
  max-width: 600px;
  padding: 2rem; 
}

.direct-infos {
  display: flex;
  flex-direction: column;
  align-items: center; 
  justify-content: center; 
  text-align: center;
}

.direct-infos-titre {
  display: flex;
  align-items: center; 
  gap: 1rem; 
  justify-content: center; 
}

button {
  background-color: #A568BB;
  color: white;
  margin-bottom: 20px;
  cursor: pointer;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  font-size: 1rem;
  width: fit-content;
}

#conference {
  display: flex;
  justify-content: center; 
  gap: 2rem; 
}

@media screen and (min-width: 700px) and (max-width: 1024px) {
  .direct {
    padding: 2rem;
    @include flex(row, nowrap, 4vw, space-between);

    &-infos-titre {
      @include grid(1fr 8fr);
      justify-content: center; // Centrer horizontalement

      h1 {
        @include text-style(4vw, inherit, bold);
        text-align: center; // Centrer le titre
      }

      embed {
        height: 3vw;
      }
    }
  }
}

@media screen and (min-width: 1024px) {
  .direct {
    padding: 3rem;
    @include flex(row, nowrap, 5vw, space-between);

    &-infos-titre {
      @include grid(1fr 15fr);
      justify-content: center; // Centrer horizontalement

      h1 {
        @include text-style(2.5em, inherit, bold);
        text-align: center; // Centrer le titre
      }

      embed {
        height: 2em;
      }
    }
  }
}
</style>
