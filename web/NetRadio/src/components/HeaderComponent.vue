<script>
import { mapState, mapActions } from "pinia";
import { useUserStore } from "@/stores/user.js";
import VueJwtDecode from 'vue-jwt-decode';

export default {
  computed: {
    ...mapState(useUserStore, ['user', 'loggedIn','tokens'])
  },
  data() {
    return {

    }
  },

  methods: {
    ...mapActions(useUserStore, ['logoutUser']),
    logOut() {
      this.logoutUser()
      this.$router.push('/connexion')
    }
  },
};
</script>

<template>
  <header>
    <div class="header">
      <router-link to="/"><img class="header-logo" src="/icons/logo.png" alt="Logo NET RADIO"></router-link>
      <div class="header-boutons">
        <input class="search" type="search" src="/icons/search.svg" placeholder="Rechercher ...">
        <router-link to="/mon-compte" v-if="loggedIn"><img class="header-user-co" src="/icons/user.svg" alt="user icon"/></router-link>

        <button v-if="loggedIn" class="header-boutons-deconnecter" @click="logOut">Se déconnecter</button>
        <router-link v-else to="/connexion"><button class="header-boutons-connecter" >Se connecter</button></router-link>
      </div>
    </div>
    <nav class="nav">
      <div class="nav-item">
        <router-link to="/liste-des-podcasts">Podcasts</router-link>
      </div>
      <div class="nav-item">
        <router-link to="/liste-des-emissions">Emissions</router-link>
      </div>
      <div class="nav-item">
        <router-link to="/grille-des-programmes">Grille des programmes</router-link>
      </div>
    </nav>
  </header>
  <div class="topnav">
    <div id="myLinks">
      <div class="nav-item"><a href="">Podcasts</a></div>
      <div class="nav-item"><a href="">Émissions</a></div>
      <div class="nav-item"><a href="">Grille des programmes</a></div>
    </div>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
      <i class="gg-menu"></i>
    </a>
  </div>
</template>

<style scoped lang="scss">

@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";
@import "@/assets/listeEmissionsPodcasts";

.header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1%;
}

.header-logo {
  margin-left: 1em;
  border-radius: 5px;
  height: 4em;
  width: auto;
}

@media screen and (max-width:750px) {
  .header-logo {
  align-content: center;
  margin-left: 40%;
  border-radius: 5px;
  height: 50px;
  width: auto;
}
}

.header-boutons {
  display: flex;

  .header-user-co {
    height: 50px;
    width: auto;
    margin: .5em 0em .5em 0em;
  }

  .header-boutons-connecter, .header-boutons-deconnecter {

    @include buttonStyle($purple, $purple, white, auto, 1em, .5em 0em .5em 0em, 0px);
    font-weight: 500;
    margin-right: 10px;
  }

  .search {

    border-color: transparent;
    border-bottom-color: #dcdcdc;
    border-right-color: #dcdcdc;
    border-radius: 5px;
    width: auto;
    font-size: 1em;
    margin: .5em 0em .5em 0em;

  }
}

.header-boutons-connecter {
  margin-right: 10px;
}

@media (max-width: 768px) {
  .header {
    flex-direction: column;
    padding: 20px;
  }

  .header-logo {
    width: 20%;
    height: auto;
    margin-bottom: 20px;
  }

  .header-boutons {
    flex-direction: row;
    align-items: center;
    margin-bottom: 20px;
  }

  .header-user-co {
    height: 40px;
    width: auto;
    margin-right: 10px;
  }

  .header-boutons-connecter {
    font-size: 0.8em;
    padding: 5px 10px;
  }

  .search {
    width: 100%;
    font-size: 0.8em;
    padding: 5px 10px;
  }
}

.nav {
  display: flex;
  justify-content: center;
  align-items: center;
  color: black;
  padding: 1em;
  background-color: rgba(0, 0, 0, 0.081);
}

.nav-item a {
  margin: 0 10px;
  text-decoration: none;
  color: black;
  font-weight: bold;
}

.topnav i {
  margin: 0 10px;
  text-decoration: none;
  color: black;
  font-weight: bold;
}

.topnav i {
  display: flex;
  justify-content: center;
  align-items: center;
  color: black;
}


a:hover {

  color: $purple;
}

i:hover {

  color: $purple;
}

@media (max-width: 658px) {
  .nav {
    display: none;
  }
}

#myLinks {
  margin-bottom: 1em;
  display: none;
}

@media (min-width: 658px) {
  .topnav a {
    display: none;
  }
}


</style>
