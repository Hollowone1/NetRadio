<template>
<div class="emissions">
      <h2>Toutes les émissions</h2>
      <div class="theme">
        <h3>Thématique 1</h3>
        <div class="emissions-liste">
          <section class="emission" v-for="emission in emissions" :key="emission.id">
            <p>{{ emission.titre }}</p>
            <p>{{ emission.theme }}</p>
            <p>{{ emission.user_mail }}</p>
          </section>
        </div>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';
  import instance from '@/plugin/api'

  export default {
    data(){
      return{
        emission: []
      }
    },
    created() {
    axios.get(`${instance}/emissions`)
      .then((response) => response.json())
      .then((data) => {
        this.emissions = data;
      })
      .catch((error) => console.log(error));
  },
    props: {
      emission: {
        type: Object,
        required: true,
      },
    },
  };
  </script>