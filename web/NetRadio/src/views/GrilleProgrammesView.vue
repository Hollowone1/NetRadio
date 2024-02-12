Grille prog
<script>
import EnDirect from '@/components/EnDirect.vue'
import HeaderComponent from "@/components/HeaderComponent.vue";
export default {
  components: {
    EnDirect,
    HeaderComponent
  },
  data() {
    return {

    }
  }
}
</script>
<template>
  <header-component></header-component>
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
</template>
