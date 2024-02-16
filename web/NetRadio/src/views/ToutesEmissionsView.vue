<script>
import EnDirect from '@/components/EnDirect.vue'
import Emission from '@/components/Emission.vue'

export default {
  components: {
    EnDirect,
    Emission
  },
  data() {
    return {
      emissions: []
    }
  },
  created() {
    this.$api.get("/emissions")
        .then((response) => {
          this.emissions = response.data.emission
        })
        .catch((error) => {
          console.log(error)
        });
  }
}
</script>

<template>
    
  <main>
    <h2>Liste des émissions</h2>
    <div class="utilisateurs">
      <div class="role" v-for="(emission, index) in emissions" :key="index">
        <span>{{ emission.titre }}</span>
        <img src="" alt="edit">
      </div>
      <div class="info">
        <p>{{ emission.user_mail }}</p>
      </div>
    </div>
  </main>
</template>

<style scoped lang="scss">

</style>