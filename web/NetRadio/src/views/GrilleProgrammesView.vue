<script>
import EnDirect from '@/components/EnDirect.vue'
export default {
  components: {
    EnDirect
  },
  data() {
    return {

    }
  }
}

</script>
<template>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/accueil.css">
    <title>NetRadio - Grille des émissions </title>
    <link rel="stylesheet" type="text/css" href="../css/grille-programmes.css">
  </head>
  <body>
  <header>
    <div class="header">
      <img class="header-logo" src="/icons/logo.png" alt="Logo NET RADIO">
      <div class="header-boutons">
        <input class="search" type="search" src="../assets/search.svg" placeholder="Search for...">
        <!--si on est  connecté-->
        <embed class="header-user-co" src="/icons/user.svg"/>
        <!--si on n'est pas connecté-->
        <button class="header-boutons-connecter">Se connecter</button>
      </div>
    </div>
    <nav class="nav">
      <div class="nav-item"><a href="./podcasts.html">Podcasts</a></div>
      <div class="nav-item"><a href="./emissions.html">Émissions</a></div>
      <div class="nav-item"><a href="./programmation.html">Grille des programmes</a></div>
    </nav>
  </header>
  <div class="topnav">
    <div id="myLinks">
      <div class="nav-item"><a href="./podcasts.html">Podcasts</a></div>
      <div class="nav-item"><a href="./emissions.html">Émissions</a></div>
      <div class="nav-item"><a href="./programmation.html">Grille des programmes</a></div>
    </div>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
      <i class="gg-menu"></i>
    </a>
  </div>
  <main>

    <en-direct></en-direct>

    <div class="programme">
      <h2>Grille des programmes</h2>
      <h3>Net Radio</h3>
      <div class="dates">
        <img src="/icons/gauche.svg">
        <p>Jeudi 9 novembre 2023</p>
        <img src="/icons/droite.svg">
      </div>

      <section>
        <h4>Heure 1</h4>
        <div class="prog">
          <div class="prog-infos">
            <div class="prog-infos-texte">
              <h5>Le nom de l'émission</h5>
              <p>Nom présentateur</p>
              <p>Avec nom de l'invité, nom de l'invité, ...</p>
            </div>
            <img src="/icons/placeholder.png" alt="image de l'émission">
          </div>
        </div>

        <h4>Heure 2</h4>
        <div class="prog">
          <div class="prog-infos">
            <div class="prog-infos-texte">
              <h5>Le nom de l'émission</h5>
              <p>Nom présentateur</p>
              <p>Avec nom de l'invité, nom de l'invité, ...</p>
            </div>
            <img src="/icons/placeholder.png" alt="image de l'émission">
          </div>
        </div>

        <h4>Heure 3</h4>
        <div class="prog">
          <div class="prog-infos">
            <div class="prog-infos-texte">
              <h5>Le nom de l'émission</h5>
              <p>Nom présentateur</p>
              <p>Avec nom de l'invité, nom de l'invité, ...</p>
            </div>
            <img src="/icons/placeholder.png" alt="image de l'émission">
          </div>
        </div>
      </section>
      <a href="">Découvrir toutes les émissions</a>
    </div>
  </main>
  </body>
  </html>
</template>