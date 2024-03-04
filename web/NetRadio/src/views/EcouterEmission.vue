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
  data() {
      return {
        name: "",
        conversation: null,
      };
    },
};

setup(){

    const localStream = ref(null);
    const conversation = ref(null);
    const audioContext = ref(null);
    const mediaStreamSource = ref(null);
    const mediaRecorder = ref(null);
    const isStreaming = ref(false);
    const recordedChunks = ref([]);
  
    onMounted(async () => {
      //==============================
      // 1/ CREATE USER AGENT
      //==============================
      const ua = new UserAgent({
        uri: "apzkey:myDemoApiKey",
        })

        connectToServer();
        startStreaming();
  });
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
      //==============================
      // 2/ REGISTER
      //==============================
      const session = await ua.register();

      //==============================
      // 3/ CREATE CONVERSATION
      //==============================
      const conversationInstance = session.getConversation('myConversation');
      conversation.value = conversationInstance;

      //==========================================================
      // 4/ ADD EVENT LISTENER : WHEN NEW STREAM IS AVAILABLE IN CONVERSATION
      //==========================================================
      conversationInstance.on("streamListChanged", (streamInfo) => {
        console.log("streamListChanged :", streamInfo);
        if (streamInfo.listEventType === "added") {
          if (streamInfo.isRemote === true) {
            conversationInstance
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
      conversationInstance
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
      const createStream = await ua.createStream({
        constraints: {
          audio: true,
          video: true,
        },
      });
      console.log("createStream :", createStream);

      // Save local stream
      localStream.value = createStream;
      createStream.removeFromDiv("local-container", "local-media");
      createStream.addInDiv("local-container", "local-media", {}, true);

      //==============================
      // 6/ JOIN CONVERSATION
      //==============================
      const joinResponse = await conversationInstance.join();
      console.log("Conversation joined", joinResponse);

      //==============================
      // 7/ PUBLISH LOCAL STREAM
      //==============================
      const publishResponse = await conversationInstance.publish(localStream.value);
      console.log("published", publishResponse);
    };

    // A function to stop streaming
    const stopStreaming = () => {
      if (mediaRecorder.value && isStreaming.value) {
        mediaRecorder.value.stop();
        isStreaming.value = false;

        // Send the recorded audio to the server when the recording is stopped
        const blob = new Blob(recordedChunks.value, { type: "audio/wav" });

        let body = {
          titre: emission.titre,
          description: emission.description,
          audio: blob,
          emission_id: emission.id,
        }

        axios.post("http://localhost:2080/podcasts", body).then((response) => {
          console.log(response);
        });

        // Download the recorded audio as a WAV file
        downloadWav();
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
        a.download = `emission${$route.params.id}.wav`;
        a.click();
        URL.revokeObjectURL(url);
      }
    };


    // Stop streaming and clean up when the component is unmounted
    onUnmounted(() => {
      stopStreaming();
      downloadWav()
    });

    // Return the functions to be used in the template
    return { stopStreaming,localStream,conversation };
  }

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