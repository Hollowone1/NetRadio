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
      emissions: [],
      themes: []
    }
  },
  created() {
    this.$api.get("/emissions")
        .then((response) => {
          this.emissions = response.data.emission
          let themes = []
          this.emissions.forEach(emission => {
            if (!themes.includes(emission.theme)) {
              themes.push(emission.theme)
            }
            this.$api.get(emission.links.users.href)
                .then((response2) => {
                  emission.user = `${response2.data.user.nom} ${response2.data.user.prenom}`
                })
                .catch((error) => {
                  console.log(error)
                });
          });
          this.themes = themes;
          console.log(this.emissions)
        })
        .catch((error) => {
          console.log(error)
        });
  },
  methods: {
    getEmissionsTheme(theme) {
      return this.emissions.filter(emission => emission.theme === theme);
    }
  }
}
</script>
<template>
    <en-direct></en-direct>
    <div class="emissions">
      <h2>Toutes les émissions</h2>
      <div v-for="theme in themes" class="theme">
        <h3>{{ theme }}</h3>
        <div class="emissions-liste">
          <emission v-for="emission in getEmissionsTheme(theme)" :emission="emission" :key="emission.id"></emission>
        </div>
      </div>
    </div>
</template>

<style scoped lang="scss">
.emissions {
  padding-top: 1em;
  padding-left: 3em;
  padding-right: 3em;
}
</style>