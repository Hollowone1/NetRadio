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
  import { $api } from '@/plugin/api';
  import { shuffle } from 'lodash';
  import { computed } from 'vue';

  
 
  const props = defineProps({
  selectedDate: Object,
})

  // On récupère les données de l'API
      const creneaux = ref([]);
      const currentDate = computed(() => props.selectedDate);

  
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
  