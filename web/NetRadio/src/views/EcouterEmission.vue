<template>
  <!-- Si l'utilisateur est un auditeur (role 1), il peut seulement écouter l'émission -->
  <!--    <section v-if="getRoleUser() === 1" class="direct">-->
  <!--      <div id="container">-->
  <!--        <div class="direct-infos">-->
  <!--          <div class="direct-infos-titre">-->
  <!--            <embed src="/icons/direct.svg"/>-->
  <!--            <h1>{{ emission.titre }}</h1>-->
  <!--          </div>-->
  <!--        </div>-->
  <!--          <h2 id="title">Écouter l'émission en direct</h2>-->
  <!--          <div id="conference">-->
  <!--            <div id="remote-container"></div>-->
  <!--            <div id="local-container"></div>-->
  <!--          </div>-->
  <!--        </div>-->
  <!--    </section>-->

  <!--  &lt;!&ndash; Si l'utilisateur est un animateur (role 2), il peut lancer l'émission et l'écouter &ndash;&gt;-->
  <!--    <section v-if="getRoleUser() === 2" class="direct">-->

  <div id="container">
    <div class="direct-infos">
      <div class="direct-infos-titre">
        <embed src="/icons/direct.svg"/>
        <!--          <h1>{{ emission.titre }}</h1>-->
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
        <button type="button" @click="startStreaming">Commencer l'émission</button>
        <!-- a peut etre remettre en submit -->
        <button type="button" @click="stopStreaming">Arrêter et sauvegarder l'émission</button>
      </form>

      <div id="conference">
        <div id="remote-container"></div>
        <div id="local-container"></div>
      </div>
    </div>
  </div>
  <!--    </section>-->


</template>

<script>
import {ref, onMounted, onUnmounted} from "vue";
import {UserAgent, Session} from '@apirtc/apirtc'
import {useUserStore} from "@/stores/user.js";
import {useRoute} from "vue-router";
import {mapState} from "pinia";

export default {
  data() {
    return {
      emission: [],
      userRole: null
    }
  },

  computed: {
    ...mapState(useUserStore, ['user', 'tokens', 'loggedIn']),
  },

  created() {
    this.$api.get("/emissions")
        .then((response) => {
          this.emission = response.data.emission.find(emission => emission.onDirect === true)
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

    const getEmission = async () => {
      let promise = new Promise((resolve, reject) => {
        this.$api.get(`/emissions/${this.emission.id}`)
            .then((resp) => {
              resolve(resp.data.emission)
            })
            .catch((error) => {
              reject(error)
            })
      });
      return await promise
    };


      const stopStreaming = async () => {
        if (mediaRecorder.value && isStreaming.value) {
          mediaRecorder.value.stop();
          isStreaming.value = false;

          const blob = new Blob(recordedChunks.value, {type: "audio/wav"});
          const emission = await getEmission();
          if (emission) {
            const formData = new FormData();
            formData.append('titre', emission.titre);
            formData.append('date', emission.date);
            formData.append('duree', emission.duree);
            formData.append('description', emission.description);
            formData.append('photo', emission.photo);
            formData.append('audio', blob);
            formData.append('emission_id', emission.id);

            const response = new Blob([JSON.stringify(formData)], {type: "application/json"});
            this.$api.post('/podcasts', {
                  response
                },
                {
                  headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${tokens.access_token}`
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
      const a = document.createElement("a");
      a.style.display = "none";
      a.href = url;
      a.download = "recording.wav";
      document.body.appendChild(a);
      a.click();
      window.URL.revokeObjectURL(url);
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

    return {stopStreaming, localStream, conversation, startStreaming, downloadWav, getRoleUser};
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