<template>
    <div>
      <h1>Les Creneaux à ce jour</h1>
      <ul>
        <li v-for="creneau in creneaux" :key="creneau.id">
          <router-link :to="creneau.links.emission.href">
            {{ creneau.heureDepart }} - {{ creneau.heureFin }}
          </router-link>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import { $api } from '@/plugin/api';
  import { shuffle } from 'lodash';
  
  export default {
    name: 'Creneaux',
    setup() {
      const creneaux = ref([]);
  
      const fetchData = async () => {
        try {
          const response = await $api.get('/creneaux', {
            params: {
              type: 'resource',
            },
          });
          const creneauxData = response.data.creneaux;
          const shuffledCreneaux = shuffle(creneauxData).slice(0, 5);
          creneaux.value = shuffledCreneaux;
        } catch (error) {
          console.error('Error fetching ', error);
        }
      };
  
      onMounted(fetchData);
  
      return {
        creneaux,
      };
    },
  };
  </script>
  
  <style scoped>
  a {
    color: black;
  }
  </style>
  