<template>
  <div>
    <h2>Audio Player</h2>
    <button @click="startListening" :disabled="listening">Start Listening</button>
    <button @click="stopListening" :disabled="!listening">Stop Listening</button>
    <h2>Recordings</h2>
    <ul>
      <li v-for="(recording, index) in recordings" :key="index">
        <audio controls :src="recording.url"></audio>
      </li>
    </ul>
  </div>
</template>

<script>
import { Decoder } from 'opus-recorder'; // Utilisez Decoder au lieu de Recorder
import io from 'socket.io-client';

export default {
  data() {
    return {
      listening: false,
      socket: null,
      recordings: [],
      opusDecoder: null, // Utilisez Decoder au lieu de Recorder
    };
  },
  methods: {
    startListening() {
      this.listening = true;

      // Connectez-vous à votre serveur Socket.io
      this.socket = io('http://localhost:3000');

      // Créez une nouvelle instance de Decoder avec le chemin de l'encodeur
      this.opusDecoder = new Decoder();

      this.socket.on('audio', (data) => {
        const audioData = new Int16Array(data);
        this.opusDecoder.decode(audioData).then((decodedData) => {
          const blob = new Blob([decodedData], { type: 'audio/ogg' });
          const url = URL.createObjectURL(blob);
          this.recordings.push({ url });
        });
      });
    },
    stopListening() {
      this.listening = false;
      this.socket.disconnect();
      this.opusDecoder.close();
    },
  },
};
</script>
