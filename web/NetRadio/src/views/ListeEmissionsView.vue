<script>
import EnDirect from '@/components/EnDirect.vue'
import HeaderComponent from "@/components/HeaderComponent.vue";

export default {
  components: {
    EnDirect,
    HeaderComponent
  },
  data() {
    return {}
  }
}
</script>
<template>
  <main>
    <en-direct></en-direct>

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
  </main>
</template>

<style scoped lang="scss">
.emissions {
  padding-top: 1em;
  padding-left: 3em;
  padding-right: 3em;
}
</style>