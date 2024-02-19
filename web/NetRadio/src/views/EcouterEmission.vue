<template>
  <div>
    <button @click="startStreaming">Start Streaming</button>
    <button @click="stopStreaming">Stop Streaming</button>
    <button @click="downloadWav">Download Wav</button>
  </div>
</template>

<script>
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

    // Create a reactive reference to an array of recorded chunks
    const recordedChunks = ref([]);

    // A function to set up the connection to the server
    const connectToServer = async () => {
      try {
        // Request access to the user's microphone
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });

        // Create a new audio context
        audioContext.value = new (window.AudioContext || window.webkitAudioContext)();

        // Create a media stream source from the user's microphone stream
        mediaStreamSource.value = audioContext.value.createMediaStreamSource(stream);

        // Create a media stream destination
        const destination = audioContext.value.createMediaStreamDestination();

        // Connect the media stream source to the media stream destination
        mediaStreamSource.value.connect(destination);

        // Create a new media recorder using the media stream destination's stream
        mediaRecorder.value = new MediaRecorder(destination.stream);

        // Add an event listener to the dataavailable event on the media recorder
        mediaRecorder.value.ondataavailable = (e) => {
          if (e.data.size > 0) {
            // Add the recorded chunk to the array of recorded chunks
            recordedChunks.value.push(e.data);
          }
        };

        // Start the media recorder
        mediaRecorder.value.start();
      } catch (error) {
        console.error("Error accessing microphone:", error);
      }
    };

    // A function to start streaming
    const startStreaming = () => {
      if (!audioContext.value) {
        // If the audio context is not yet initialized, call connectToServer
        connectToServer();
      }
      if (!isStreaming.value) {
        // If we are not currently streaming, reset the array of recorded chunks
        recordedChunks.value = [];
        // If the media recorder is in the "inactive" state, start it
        if (mediaRecorder.value.state === "inactive") {
          mediaRecorder.value.start();
        }
        // Set the streaming boolean to true
        isStreaming.value = true;
      }
    };

    // A function to stop streaming
    const stopStreaming = () => {
      if (mediaRecorder.value) {
        // Stop the media recorder
        mediaRecorder.value.stop();
      }
      if (mediaStreamSource.value) {
        // Disconnect the media stream source
        mediaStreamSource.value.disconnect();
      }
      // Set the streaming boolean to false
      isStreaming.value = false;
    };

    // A function to download the recorded audio as a WAV file
    const downloadWav = () => {
      // Create a new Blob from the array of recorded chunks
      const blob = new Blob(recordedChunks.value, { type: "audio/wav" });

      // Create a URL object from the Blob
      const url = URL.createObjectURL(blob);

      // Create a new link element
      const link = document.createElement("a");

      // Set the link's href to the URL object
      link.href = url;

            // Set the link's download attribute to "audio.wav"
            link.download = "audio.wav";

            // Append the link to the body of the page
            document.body.appendChild(link);

        // Programmatically click the link to initiate the download
        link.click();

        // Clean up by removing the link from the page
        document.body.removeChild(link);

        // Revoke the object URL to free up memory
        URL.revokeObjectURL(url);
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
      return {
      startStreaming,
      stopStreaming,
      downloadWav,
      };
    },
  };
</script>