<template>
  <div class="emissions">
    <h2>Toutes les émissions</h2>
    <div class="theme">
      <h3>Thématique 1</h3>
      <div class="emissions-liste">
        <section class="emission" v-for="emission in emissionsData" :key="emission.id">
          <img :src="emission.photo" alt="photo de l'émission" >
          <p>{{ emission.titre }}</p>
          <p>{{ emission.theme }}</p>
          <p>{{ emission.user_mail }}</p>
        </section>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  data(){
    return{
      emissionsData: []
    }
  },
  created() {
    this.$api.get("emissions")
      .then((response) => {
        console.log(response)
        if (response.data) {
          console.log(response.data)
          this.emissionsData = response.data.emission;
        } else {
          throw new Error('Emissions data not found');
        }
      })
      .catch((error) => console.log(error));
  },
  props: {
    emission: {
      type: Object,
      required: true,
      default: () => ({})
    },
  },
};
</script>

<style scoped>

img{
  width: 75%;
  
}

</style>