<script>
import EnDirect from '@/components/EnDirect.vue'
import Emission from '@/components/Emission.vue'
import {isNull} from "lodash";

export default {
  components: {
    EnDirect,
    Emission
  },
  data() {
    return {
      allEmissions: [],
      displayEmissions: [],
      allThemes: [],
      displayThemes: [],
      research: "",
      filter: false
    }
  },
  created() {
    this.$api.get("/emissions")
        .then((response) => {
          this.allEmissions = response.data.emission
          this.displayEmissions = response.data.emission
          let themes = []
          this.allEmissions.forEach(emission => {
            if (!themes.includes(emission.theme)) {
              themes.push(emission.theme)
            }
            this.$api.get(emission.links.users.href)
                .then((response2) => {
                  emission.user = `${response2.data.user[0].nom} ${response2.data.user[0].prenom}`
                })
                .catch((error) => {
                  console.log(error)
                });
          });
          this.allThemes = themes;
          this.displayThemes = themes;
        })
        .catch((error) => {
          console.log(error)
        });
  },
  methods: {
    search() {
      this.filter = false;
      this.displayEmissions = this.allEmissions.filter(emission =>
          emission.titre.toLowerCase().includes(this.research.toLowerCase())
      );
    },
    endSearch() {
      this.filter = false;
      this.research = "";
      this.displayEmissions = this.allEmissions;
    },
    filterByTheme(theme) {
      theme ? (this.displayThemes = [theme], this.filter = true) : (this.displayThemes = this.allThemes, this.endSearch());
    },
    getEmissionsTheme(theme) {
      return this.displayEmissions.filter(emission => emission.theme === theme);
    }
  }
}
</script>
<template>
  <en-direct></en-direct>
  <div class="resultats">
    <h1>Toutes les émissions</h1>
    <div class="recherche">
      <div class="barre-recherche">
        <img src="/icons/loupe.svg" alt="icone recherche">
        <input @keyup.enter="search()" v-model="research" type="text" placeholder="Rechercher">
        <img @click="endSearch()" v-if="research" src="/icons/croix.svg" alt="icone croix">
      </div>
      <div class="genres">
        <button @click="filterByTheme()" class="genre">Tout</button>
        <button @click="filterByTheme(theme)" v-for="theme in allThemes" class="genre">{{ theme }}</button>
      </div>
    </div>
    <div v-if="filter" v-for="theme in displayThemes" class="emissions-liste">
        <emission v-for="emission in getEmissionsTheme(theme)" :emission="emission" :key="emission.id"></emission>
    </div>
    <div v-else class="emissions-liste">
      <emission v-for="emission in displayEmissions" :emission="emission" :key="emission.id"></emission>
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