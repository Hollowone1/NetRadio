<script>
import EnDirect from '@/components/EnDirect.vue'

export default {
  components: {
    EnDirect
  },
  data() {
    return {
      creneaux: [],
      currentDate: new Date(),
      heures: [],
      emissions: []
    }
  },
  computed: {
    formaterDate() {
      return this.currentDate.toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        weekday: 'long'
      })
    },
  },
  methods: {
    prevDate() {
      this.currentDate = new Date(this.currentDate.setDate(this.currentDate.getDate() - 1))
    },
    nextDate() {
      this.currentDate = new Date(this.currentDate.setDate(this.currentDate.getDate() + 1))
    },
    getCreneaux() {
      let jour = this.currentDate.getDay();
      if (jour === 0) {
        jour = 7;
      }
      const creneaux = [];
      const heures = [];
      const getEmissionPromises = [];

      this.$api.get("/creneaux")
          .then((resp) => {
            resp.data.creneaux.forEach(creneau => {
              if (creneau.jourSemaine === jour) {
                creneaux.push(creneau);
                if (!heures.includes(creneau.heureDepart)) {
                  heures.push(creneau.heureDepart);
                }
                getEmissionPromises.push(
                    this.getEmission(creneau.links.emission.href)
                        .then(emission => {
                          return this.getUser(emission.links.users.href)
                              .then(user => {
                                emission.presentateur = user.prenom + " " + user.nom;
                                creneau.emission = emission;
                              });
                        })
                );
              }
            });
            Promise.all(getEmissionPromises)
                .then(() => {
                  this.creneaux = creneaux;
                  this.heures = heures;
                });
          })
          .catch((error) => {
            toast.error('Erreur lors de la récupération des créneaux', ToastOptions)
          });
    },
    getCreneauHeure(heure) {
      return this.creneaux.filter(creneau => creneau.heureDepart === heure)
    },
    async getEmission(link) {
      let promise = new Promise((resolve, reject) => {
        this.$api.get(link)
            .then((resp) => {
              resolve(resp.data.emission)
            })
            .catch((error) => {
              reject(error)
            })
      });
      return await promise
    },
    async getUser(link) {
      let promise = new Promise((resolve, reject) => {
        this.$api.get(link)
            .then((resp) => {
              resolve(resp.data.user[0])
            })
            .catch((error) => {
              reject(error)
            })
      });
      return await promise
    },
    redirect(id) {
      this.$router.push(`/emissions/${id}`)
    }
  },
  created() {
    this.getCreneaux()
  },
  watch: {
    //à chaque changement de valeur de currentDate, on refresh les créneaux, et donc la page
    currentDate() {
      this.getCreneaux()
    }
  }
}

</script>
<template>
  <main>

    <en-direct></en-direct>
    <div class="programme">
      <h2>Grille des programmes</h2>
      <h3>Net Radio</h3>
      <div class="dates">
        <img src="/icons/gauche.svg" @click="prevDate">
        <p>{{ formaterDate }}</p>
        <img src="/icons/droite.svg" @click="nextDate">
      </div>

      <section v-for="heure in heures">
        <h4>{{ heure }}</h4>
        <div v-for="creneau in getCreneauHeure(heure)" class="prog">
          <div @click="redirect(creneau.emission.id)" class="prog-infos">
            <div class="prog-infos-texte">
              <h5> {{creneau.emission.titre}} </h5>
              <p>{{creneau.emission.presentateur}}</p>
            </div>
            <img :src="creneau.emission.photo" alt="image de l'émission">
          </div>
        </div>
      </section>
      <a href="">Découvrir toutes les émissions</a>
    </div>
  </main>
</template>

<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";

.programme {
  padding: 1em
}

h2 {
  @include text-style(1.7em, inherit, bold);
  margin: 0;

}

h3 {
  @include text-style(1.3em, inherit, 400);
  margin: 0;
}

.dates {
  width: 70vw;
  margin: 2em auto;
  @include flex(row, nowrap, .5em, space-between, center);

  p {
    @include text-style(1em, white, 400);
    background-color: $purple;
    padding: 1em;
    border-radius: 100px;
    text-align: center;

    &:first-letter {
      text-transform: uppercase;
    }
  }

  img:hover {
    cursor: pointer;
  }
}

h4 {
  text-align: center;
  @include text-style(1.4em, inherit, 600);
  width: 70vw;
  margin-right: auto;
  margin-left: auto;
  padding-top: 1em;
  border-top: 1px solid black;
}

.prog {
  &-infos {
    padding: 1.5em 1em 1.5em 1em;
    background-color: $lightField;
    border-radius: 10px;
    @include flex(row, nowrap, 1.5em, space-between, center);
    cursor: pointer;
  }

  img {
    width: 15vw
  }

  h5 {
    margin: 0 0 .5em 0;
    @include text-style(1.2em, $purple, 600);
  }
}

@media screen and (min-width: 700px) and (max-width: 1024px) {
  .programme {
    padding: 1.5em;

    h2 {
      @include text-style(2.3em, inherit, bold);
    }

    h3 {
      @include text-style(1.8em, inherit, 400);
    }

    .dates {
      width: 50vw;

      p {
        @include text-style(1.3em, white, 400);
        border-radius: 100px;
      }
    }
  }
  h4 {
    text-align: left;
    width: 100%;
    @include text-style(1.8em, inherit, 600);
    border: none;
    margin-bottom: 0.5em;
    margin-top: 0.5em;
    padding-top: 0
  }
  .prog {
    border-left: 1px solid black;
    padding: 2em;
    margin-left: 3em;
    margin-right: 3em;
    display: inline-block;

    &-infos {
      @include flex(row, nowrap, 10em, space-between, center);

      h5 {
        @include text-style(1.5em, $purple, 600);
      }

      p {
        @include text-style(1.2em, inherit, 400);
        margin-top: .2em;
      }

      img {
        width: 5em;
      }

    }
  }
}

@media screen and (min-width: 1024px) {
  .programme {
    padding: 2em;

    h2 {
      @include text-style(2.3em, inherit, bold);
    }

    h3 {
      @include text-style(1.8em, inherit, 400);
    }

    .dates {
      width: 35vw;

      p {
        @include text-style(1.3em, white, 400);
        border-radius: 100px;
      }
    }
  }
  h4 {
    text-align: left;
    width: 100%;
    @include text-style(1.8em, inherit, 600);
    border: none;
    margin-bottom: 0.5em;
    margin-top: 0.5em;
    padding-top: 0
  }
  .prog {
    border-left: 1px solid black;
    padding: 2em;
    margin-left: 3em;
    margin-right: 3em;
    display: inline-block;

    &-infos {
      @include flex(row, nowrap, 10em, space-between, center);

      h5 {
        @include text-style(1.5em, $purple, 600);
      }

      p {
        @include text-style(1.2em, inherit, 400);
        margin-top: .2em;
      }

      img {
        width: 7em;
      }

    }
  }
}
</style>
