<template>
    <div class="creneaux">
      <h1>Les Creneaux à ce jour </h1>
      <ul>
        <li v-for="creneau in creneaux" :key="creneau.id">
          <router-link :to="creneau.links.emission.href">
            {{ creneau.heureDepart }} - {{ creneau.heureFin }}
          </router-link>
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { shuffle } from 'lodash';
  import { computed } from 'vue';
  
  const props = defineProps({
    selectedDate: Object,
  });
  
  const creneaux = ref([]);
  const currentDate = computed(() => props.selectedDate);
  
  async function fetchData() {
  try {
    const response = await axios.get('http://localhost:2080/creneaux');
    const creneauxData = response.data.creneaux;

    if (!creneauxData) {
      throw new Error('Aucune donnée de créneaux trouvée.');
    }

    const shuffledCreneaux = shuffle(creneauxData.slice(0, 5));
    creneaux.value = shuffledCreneaux;
  } catch (error) {
    console.error('Erreur lors de la récupération des créneaux :', error);
    errorMessage.value = error.message;
  }
}

  
  onMounted(fetchData);
  
  </script>
  
  
  <style scoped>
  a {
    color: black;
  }

    .creneaux{
      margin-left: 3em;
      width: fit-content;
      position: relative;
      height:max-content;
      border-radius: 15px;
      transition: 0.5s;

    }


    li{
      font-size: 18px;
      font-weight: bold;
    }

    li:hover{
      color: #A568BB;
      transform: scale(1.05);
      cursor: pointer;
    }
    
    ul{
      list-style-type: none;
      justify-content: space-around;}

  .creneaux:hover {
  transform: translateY(-20px);
}
    
  
  </style>
  