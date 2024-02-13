<template>
<div class="emissions">
      <h2>Toutes les émissions</h2>
      <div class="theme">
        <h3>Thématique 1</h3>
        <div class="emissions-liste">
          <section class="emission">
            <p>Le titre de l'émission</p>
            <p>PRÉSENTATEUR</p>
          </section>
          <section class="emission">
            <p>Le titre de l'émission</p>
            <p>PRÉSENTATEUR</p>
          </section>
          <section class="emission">
            <p>Le titre de l'émission</p>
            <p>PRÉSENTATEUR</p>
          </section>
          <section class="emission">
            <p>Le titre de l'émission</p>
            <p>PRÉSENTATEUR</p>
          </section>
          <section class="emission">
            <p>Le titre de l'émission</p>
            <p>PRÉSENTATEUR</p>
          </section>
          <section class="emission">
            <p>Le titre de l'émission</p>
            <p>PRÉSENTATEUR</p>
          </section>
        </div>
      </div>
    </div>
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