<template>
  <div class="podcasts">
    <search-bar placeholder="Rechercher un podcast ..."/>
    <div class="jour">
      <h2>Récemment</h2>
      <div class="podcasts-liste">
        <section class="podcast">
          <div class="podcast-info">
            <p>Nom de l'émission</p>
            <p>Titre du podcast</p>
          </div>
          <embed src="/icons/play.svg">
        </section>

        <section class="podcast">
          <div class="podcast-info">
            <p>Nom de l'émission</p>
            <p>Titre du podcast</p>
          </div>
          <embed src="/icons/play.svg">
        </section>
      </div>
    </div>

    <div class="jour">
      <h2>Aujourd'hui</h2>
      <div class="podcasts-liste">
        <section class="podcast">
          <div class="podcast-info">
            <p>Nom de l'émission</p>
            <p>Titre du podcast</p>
          </div>
          <embed src="/icons/play.svg">
        </section>

        <section class="podcast">
          <div class="podcast-info">
            <p>Nom de l'émission</p>
            <p>Titre du podcast</p>
          </div>
          <embed src="/icons/play.svg">
        </section>
      </div>
    </div>

    <div class="jour">
      <h2>Cette semaine</h2>
      <div class="podcasts-liste">
        <section class="podcast">
          <div class="podcast-info">
            <p>Nom de l'émission</p>
            <p>Titre du podcast</p>
          </div>
          <embed src="/icons/play.svg">
        </section>

        <section class="podcast">
          <div class="podcast-info">
            <p>Nom de l'émission</p>
            <p>Titre du podcast</p>
          </div>
          <embed src="/icons/play.svg">
        </section>
      </div>
    </div>
  </div>
  </template>

  <script>
  export default {
    props: {
      podcast: {
        type: Object,
        required: true,
      },
    },
  };
  </script>