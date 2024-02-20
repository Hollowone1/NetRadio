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
      if (!audioContext.value) {
        connectToServer();
      }
      if (!isStreaming.value) {
        isStreaming.value = true;

        // Start recording
        recordedChunks.value = []; // Clear any previous recorded chunks
        mediaRecorder.value.start();
      }
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