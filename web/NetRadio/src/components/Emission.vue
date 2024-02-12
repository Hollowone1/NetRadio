<template>
    <section class="direct">
      <div class="direct-infos">
        <div class="direct-infos-titre">
          <embed src="../assets/direct.svg" />
          <h1>{{}}</h1>
        </div>
        <p class="direct-infos-sous-titre">EN DIRECT</p>
        <p class="direct-infos-desc">{{}}</p>
        <button class="direct-infos-ecouter">Écouter</button>
      </div>
      <img class="direct-image" :src="emission.image" alt="image de l'émission en direct" />
    </section>
  </template>
  
  <script>
  export default {
    props: {
      emission: {
        type: Object,
        required: true,
      },
    },
  };
  </script>