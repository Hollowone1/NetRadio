<script>

export default {
  components: {},
  data() {
    return {
      //user: [],
      user: {
        mail: "agathedellinger@gmail.com",
        prenom: "Agathe",
        nom: "Dellinger",
        role: 2
      },
      display: 1,
      //emissions: [],
      emissions: [
        {
          id: 1,
          titre: "Le Monde des Animaux",
          theme: "Nature",
          description: "Découvrez la vie sauvage à travers le monde et apprenez-en davantage sur la faune fascinante qui nous entoure.",
          presentateur: "Marie Dupont"
        },
        {
          id: 2,
          titre: "Exploration Spatiale",
          theme: "Science",
          description: "Plongez dans les mystères de l'univers alors que nous explorons les planètes, les étoiles et les galaxies lointaines.",
          presentateur: "Jean-Luc Martin"
        },
        {
          id: 3,
          titre: "Cuisine du Monde",
          theme: "Cuisine",
          description: "Voyagez à travers les saveurs du monde avec notre chef expert, qui vous apprendra à préparer des plats délicieux et exotiques.",
          presentateur: "Sophie Leblanc"
        },
        {
          id: 4,
          titre: "Histoires d'Hier",
          theme: "Histoire",
          description: "Remontez le temps et revivez les grands moments de l'histoire humaine, des civilisations anciennes aux événements marquants du 20e siècle.",
          presentateur: "Pierre Deschamps"
        },
        {
          id: 5,
          titre: "Santé et Bien-être",
          theme: "Santé",
          description: "Prenez soin de votre corps et de votre esprit avec des conseils et des astuces pour une vie saine et équilibrée.",
          presentateur: "Émilie Lavoie"
        }
      ]

    }
  },
  methods: {
    getUser() {
      //fetch user dans API ou dans pinia
    },
    changeDisplay(number) {
      this.display = number;
    },
    displayEmission(id) {

    }
  }
}

</script>

<template>
  <div v-if="user.role === 1">
    <aside>
      <div>
        <div @click="changeDisplay(1)">Mon compte</div>
        <div @click="changeDisplay(2)">Enregistrements</div>
      </div>
      <div>Déconnexion</div>
    </aside>
    <main>
      <div v-if="display === 1" class="mon-compte">
        <div class="top">
          <h1>Mon compte</h1>
          <button>Modifier mes informations</button>
        </div>
        <div class="info">
          <img src="/icons/profile.svg" alt="profile">
          <div>
            <p>{{ user.nom }}</p>
            <p>{{ user.prenom }}</p>
            <p>{{ user.mail }}</p>
            <p>Mot de passe</p>
          </div>
        </div>
      </div>
      <div v-if="display === 2" class="enregistrements">
        <h1>Vos enregistrements</h1>
        <div class="podcasts">
          <h2>Podcasts</h2>
          <section class="podcast">
            <div class="podcast-info">
              <p>Nom de l'émission</p>
              <p>Titre du podcast</p>
            </div>
            <embed src="/icons/play.svg">
          </section>
        </div>
        <div class="emissions">
          <h2>Émissions</h2>
          <section class="emission">
            <p>Le titre de l'émission</p>
            <p>PRÉSENTATEUR</p>
          </section>
        </div>
      </div>
    </main>
  </div>


  <div v-if="user.role === 2">
    <aside>
      <div>
        <div @click="changeDisplay(1)">Mon compte</div>
        <div @click="changeDisplay(2)">Émissions</div>
        <div @click="changeDisplay(3)">Calendrier</div>
      </div>
      <div>Déconnexion</div>
    </aside>
    <main>
      <div v-if="display === 1" class="mon-compte">
        <div class="top">
          <h1>Mon compte</h1>
          <button>Modifier mes informations</button>
        </div>
        <div class="info">
          <img src="/icons/profile.svg" alt="profile">
          <div>
            <p>{{ user.nom }}</p>
            <p>{{ user.prenom }}</p>
            <p>{{ user.mail }}</p>
            <p>Mot de passe</p>
          </div>
        </div>
      </div>
      <div v-if="display === 2" class="emissions">
        <h1>Toutes les émissions</h1>
        <h2>Émissions</h2>
        <div class="emissions-liste">
          <section v-for="emission in emissions" class="emission">
            <img @click="displayEmission(emission.id)" src="/icons/edit.svg" alt="edit">
            <div class="infos">
              <p>{{ emission.titre }}</p>
              <p>{{ emission.presentateur }}</p>
            </div>
          </section>
        </div>
      </div>
    </main>
  </div>

  <div class="display-emission">
    <div class="top">
      <h3>{{displayEmission.titre}}</h3>
    </div>
  </div>

</template>

<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";

.emissions-liste {
  @include grid(repeat(auto-fit, 13em), auto, 1em, start, center);
  .emission {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: flex-end;
    img {
      height: 2em
    }
  }
}



</style>