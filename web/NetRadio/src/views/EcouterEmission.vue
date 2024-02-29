<template>
  <div>
    <button @click="startStreaming">Commencer l'enregistrement</button>
    <button @click="stopStreaming">Arreter l'enregistrement</button>
    <button @click="downloadWav">Télécharger au format WAV</button>
    <img src="@/assets/telechargement.jpg" alt="image">
  </div>
</template>

<script>
import axios from "axios";
import { ref, onMounted, onUnmounted } from "vue";
import { UserAgent, Session } from '@apirtc/apirtc'


export default {
  setup() {
    // Create a reactive reference to the audio context
    const audioContext = ref(null);

    // Create a reactive reference to the media stream source
    const mediaStreamSource = ref(null);

    // Create a reactive reference to the media recorder
    const mediaRecorder = ref(null);

    // Create a reactive reference to a boolean indicating if we are currently streaming
    const isStreaming = ref(false);

    // Create a reactive reference to store recorded audio chunks
    const recordedChunks = ref([]);

    // A function to set up the connection to the server
    const connectToServer = async () => {
      try {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        audioContext.value = new (window.AudioContext || window.webkitAudioContext)();
        mediaStreamSource.value = audioContext.value.createMediaStreamSource(stream);

        // Create a new media recorder and handle data available events
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

    // A function to start streaming
    const startStreaming = () => {
      console.log("getOrcreateConversation called");

var localStream = null;

//==============================
// 1/ CREATE USER AGENT
//==============================
var ua = new UserAgent({
  uri: "apzkey:myDemoApiKey",
});

//==============================
// 2/ REGISTER
//==============================
ua.register().then((session) => {
  //==============================
  // 3/ CREATE CONVERSATION
  //==============================
  const conversation = session.getConversation(this.name);
  this.conversation = conversation;

  //==========================================================
  // 4/ ADD EVENT LISTENER : WHEN NEW STREAM IS AVAILABLE IN CONVERSATION
  //==========================================================
  conversation.on("streamListChanged", (streamInfo) => {
    console.log("streamListChanged :", streamInfo);
    if (streamInfo.listEventType === "added") {
      if (streamInfo.isRemote === true) {
        conversation
          .subscribeToMedia(streamInfo.streamId)
          .then((stream) => {
            console.log("subscribeToMedia success", stream);
          })
          .catch((err) => {
            console.error("subscribeToMedia error", err);
          });
      }
    }
  });
  //=====================================================
  // 4 BIS/ ADD EVENT LISTENER : WHEN STREAM IS ADDED/REMOVED TO/FROM THE CONVERSATION
  //=====================================================
  conversation
    .on("streamAdded", (stream) => {
      stream.addInDiv(
        "remote-container",
        "remote-media-" + stream.streamId,
        {},
        false
      );
    })
    .on("streamRemoved", (stream) => {
      stream.removeFromDiv(
        "remote-container",
        "remote-media-" + stream.streamId
      );
    });

  //==============================
  // 5/ CREATE LOCAL STREAM
  //==============================
  ua.createStream({
    constraints: {
      audio: true,
      video:true,
    },
  })
    .then((stream) => {
      console.log("createStream :", stream);

      // Save local stream
      localStream = stream;
      stream.removeFromDiv("local-container", "local-media");
      stream.addInDiv("local-container", "local-media", {}, true);

      //==============================
      // 6/ JOIN CONVERSATION
      //==============================
      conversation
        .join()
        .then((response) => {
          console.log("Conversation joined", response);
          //==============================
          // 7/ PUBLISH LOCAL STREAM
          //==============================
          conversation
            .publish(localStream)
            .then((stream) => {
              console.log("published", stream);
            })
            .catch((err) => {
              console.error("publish error", err);
            });
        })
        .catch((err) => {
          console.error("Conversation join error", err);
        });
    })
    .catch((err) => {
      console.error("create stream error", err);
    });
    });
    };

    // A function to stop streaming
    const stopStreaming = () => {
      if (mediaRecorder.value && isStreaming.value) {
        mediaRecorder.value.stop();
        isStreaming.value = false;

        // Send the recorded audio to the server when the recording is stopped
        const blob = new Blob(recordedChunks.value, { type: "audio/wav" });
        // const formData = new FormData();
        // formData.append("title", "My Podcast");
        // formData.append("description", "This is my podcast description.");
        // formData.append("file", blob);

        let emission = getEmission();

        let body = {
          titre: emission.titre,
          description: emission.description,
          audio: blob,
          emission_id: emission.id,
        }

        axios.post("http://localhost:2080/podcasts", body).then((response) => {
          console.log(response);
        });
      }
    };

    // faire une fonction pour récupérer les infos de l'émission à partir de son id dans la route
    // A function to get the emission information from its id in the route
    const getEmission = async () => {
      try {
        const response = await axios.get(`/emissions/${this.$route.params.id}`);
        return response.data.emission;
      } catch (error) {
        console.error(error);
      }
    };

    // A function to download the recorded audio as a WAV file
    const downloadWav = () => {
      if (recordedChunks.value.length > 0) {
        const blob = new Blob(recordedChunks.value, { type: 'audio/wav' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `emission${this.$route.params.id}.wav`;
        a.click();
        URL.revokeObjectURL(url);
      }
    };

    // Run the connectToServer function when the component is mounted
    onMounted(() => {
      connectToServer();
    });

    // Stop streaming and clean up when the component is unmounted
    onUnmounted(() => {
      stopStreaming();
    });

    // Return the functions to be used in the template
    return { startStreaming, stopStreaming, downloadWav };
  },
  data() {
      return {
        name: "",
        conversation: null,
      };
    },
};

</script>


<style scoped>
div {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background-color: #FFFFFF;
  height: 100vh;
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
</style>