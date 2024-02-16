<template>
  <div>
    <h2>Options</h2>
    <div>
      <label for="monitorGain">monitorGain</label>
      <input v-model="options.monitorGain" type="number" id="monitorGain" />
    </div>
    <!-- Ajoutez d'autres options ici -->

    <h2>Recorder Commands</h2>
    <button @click="startRecording" :disabled="recording">Start</button>
    <button @click="pauseRecording" :disabled="!recording">Pause</button>
    <button @click="resumeRecording" :disabled="!recording">Resume</button>
    <button @click="stopRecording" :disabled="!recording">Stop</button>
    <button @click="closeRecorder" :disabled="!recording">Close</button>
  </div>
</template>

<script>
import Recorder from 'opus-recorder';
import io from 'socket.io-client';

export default {
  data() {
    return {
      recording: false,
      options: {
        monitorGain: 0,
        // Ajoutez d'autres options ici
      },
      recorder: null,
      socket: null,
    };
  },
  methods: {
    async startRecording() {
      this.recording = true;

      // Connectez-vous à votre serveur Socket.io
      this.socket = io('http://localhost:3000');

      // Créez une nouvelle instance de Recorder avec les options
      this.recorder = new Recorder(this.options);

      // Évitez d'utiliser this.recorder sans vérification
      if (this.recorder) {
        // Écoutez les événements de Recorder
        this.recorder.ondataavailable = (typedArray) => {
          console.log('Data received');
          // Envoyez les données audio à votre serveur socket.io
          this.socket.emit('audio', typedArray);
        };

        // Démarrez l'enregistrement
        await this.recorder.start();
      }
    },
    pauseRecording() {
      // Évitez d'utiliser this.recorder sans vérification
      if (this.recorder) {
        this.recorder.pause();
      }
    },
    resumeRecording() {
      // Évitez d'utiliser this.recorder sans vérification
      if (this.recorder) {
        this.recorder.resume();
      }
    },
    stopRecording() {
      // Évitez d'utiliser this.recorder sans vérification
      if (this.recorder) {
        this.recorder.stop();
        this.socket.disconnect();
      }
    },
    closeRecorder() {
      // Évitez d'utiliser this.recorder sans vérification
      if (this.recorder) {
        this.recorder.close();
        this.recording = false;
      }
    },
  },
};
</script>
