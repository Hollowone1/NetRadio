<template>
  <header>
    <div class="header">
      <img class="header-logo" src="/icons/logo.png" alt="Logo NET RADIO">
      <div class="header-boutons">
        <input class="search" type="search" src="/icons/search.svg" placeholder="Search for...">
        <!--si on est  connecté-->
        <embed class="header-user-co" src="/icons/user.svg"/>
        <!--si on n'est pas connecté-->
        <button class="header-boutons-connecter">Se connecter</button>
      </div>
    </div>
    <nav class="nav">
      <div class="nav-item"><a href="">Podcasts</a></div>
      <div class="nav-item"><a href="">Émissions</a></div>
      <div class="nav-item"><a href="">Grille des programmes</a></div>
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

  <script>
  export default {
    methods: {
      myFunction() {
        // la fonction ici
      },
    },
  };
  </script>

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
  margin-left: 20px;
  border-radius: 5px;
  height: 80px;
  width : auto;
}

.header-boutons {
  display: flex;
  .header-user-co{
    height: 50px;
    width: auto;
    margin : .5em 0em .5em 0em;
  }

  .header-boutons-connecter{

    @include buttonStyle($purple, $purple, white, auto, 1em, .5em 0em .5em 0em, 0px);
    font-weight: 500;
    margin-right: 10px;
  }
  .search{

    border-color:transparent;
    border-bottom-color:#dcdcdc;
    border-right-color: #dcdcdc;
    border-radius: 5px;
    width : auto;
    font-size : 1em;
    margin : .5em 0em .5em 0em;

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

.nav-item a{
  margin: 0 10px;
  text-decoration: none;
  color: black;
  font-weight: bold;
}

.topnav i{
  margin: 0 10px;
  text-decoration: none;
  color: black;
  font-weight: bold;
}

.topnav i{
  display: flex;
  justify-content: center;
  align-items: center;
  color: black;
}


a:hover{

  color: $purple;
}
i:hover{

  color: $purple;
}

@media (max-width: 658px) {
  .nav {
    display: none;
  }
}

#myLinks{
  margin-bottom: 1em;
  display: none;
}

@media (min-width: 658px) {
  .topnav a{
    display: none;
  }
}


</style>
