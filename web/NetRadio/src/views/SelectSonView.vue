<template>
    <div>
      <h1>Sélectionnez votre son pour la playlist</h1>
      <select v-model="selectedSound" @change="playSound">
        <option v-for="sound in sounds" :key="sound.id" :value="sound">
          {{ sound.name }}
        </option>
      </select>
      <button @click="addSoundToPlaylist">Ajouter à la playlist</button>
      <h2>Playlist</h2>
      <ul>
        <li v-for="(sound, index) in playlist" :key="index">
          {{ sound.name }} - <button @click="playSoundFromPlaylist(index)">Jouer</button>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        sounds: [],
        selectedSound: {},
        playlist: [],
      };
    },
    async created() {
      try {
        const response = await axios.get('http://localhost:2080/son');
        this.sounds = response.data;
      } catch (error) {
        console.error(error);
      }
    },
    methods: {
      playSound() {
        const audio = new Audio(`http://localhost:2080/son/${this.selectedSound.id}`);
        audio.play();
      },
      addSoundToPlaylist() {
        this.playlist.push(this.selectedSound);
      },
      playSoundFromPlaylist(index) {
        const audio = new Audio(`http://localhost:2080/son/${this.playlist[index].id}`);
        audio.play();
      },
    },
  };
  </script>