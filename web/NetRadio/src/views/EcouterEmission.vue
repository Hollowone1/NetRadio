<template>
  <body>
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
        
    

  </body>
</template>

<script>
import axios from "axios";
import {ref, onMounted, onUnmounted} from "vue";
import {UserAgent, Session} from '@apirtc/apirtc'

export default {
  data() {
    return {
      emission: [],
    }
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
        const response = await axios.get(`/emissions/${this.$route.params.id}`);
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
  },
};
</script>

<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";

input{
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
    margin-top : .5rem;
    margin-bottom : 2rem;
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
    border-radius : 10px;
  }


@media screen and (min-width : 700px) and (max-width : 1024px){
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