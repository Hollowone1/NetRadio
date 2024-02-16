<template>
    <div>
      <button @click="startRecording">Start Recording</button>
      <button @click="stopRecording">Stop Recording</button>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import io from 'socket.io-client';
  
  const socket = io('http://localhost:3000');
  
  export default {
    name: 'Recorder',
    data() {
      return {
        recorder: null,
        chunks: [],
      };
    },
    methods: {
      async stopRecording() {
        // Arrêter l'enregistrement audio
        this.recorder.stop();
  
        // Attendre que tous les morceaux soient disponibles avant de les envoyer au serveur
        await new Promise((resolve) => {
          this.recorder.onstop = () => {
            resolve();
          };
        });
  
        // Créer un Blob à partir des morceaux
        const recordedBlob = new Blob(this.chunks, { type: 'audio/webm' });
  
        // Convertir le Blob en une URL de données
        const recordedUrl = window.URL.createObjectURL(recordedBlob);
  
        // Envoyer une requête POST à l'API pour enregistrer le podcast
        const formData = new FormData();
        formData.append('audio', recordedBlob);
        const response = await axios.post('http://localhost:2080/podcast', formData);
      },
      startRecording() {
        navigator.mediaDevices
          .getUserMedia({ audio: true })
          .then((stream) => {
            const mediaRecorder = new MediaRecorder(stream);
  
            mediaRecorder.addEventListener('dataavailable', (event) => {
              this.chunks.push(event.data);
              socket.emit('audio-chunk', event.data);
            });
  
            this.recorder = mediaRecorder;
            mediaRecorder.start();
          })
          .catch((error) => {
            console.error('Error accessing microphone:', error);
          });
      },
    },
    mounted() {
      // Se connecter au serveur Socket.io
      socket.connect();
  
      // Écouter les événements 'audio-chunk' envoyés par le serveur
      socket.on('audio-chunk', (chunk) => {
        // Stocker le morceau audio reçu
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        audioContext.decodeAudioData(chunk, (audioBuffer) => {
          const audioBufferSource = audioContext.createBufferSource();
          audioBufferSource.buffer = audioBuffer;
          audioBufferSource.connect(audioContext.destination);
          audioBufferSource.start(0);
        });
      });
  
      // Écouter les événements 'disconnect' pour gérer les déconnexions
      socket.on('disconnect', () => {
        console.log('Un client s\'est déconnecté');
      });
    },
    beforeDestroy() {
      // Se déconnecter du serveur Socket.io
      socket.disconnect();
    },
  };
  </script>