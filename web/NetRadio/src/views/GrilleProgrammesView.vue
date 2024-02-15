<script>
import EnDirect from '@/components/EnDirect.vue'

export default {
  components: {
    EnDirect,
  },
  data() {
    return {
      emissions: [],
      currentDate: new Date(),
      programs: [],
    }
  },
  computed: {
    formattedCurrentDate() {
      return this.currentDate.toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' });
    }
  },
  created() {
    this.loadPrograms()
  },
  methods: {
    prevDate() {
      const date = new Date(this.currentDate);
      date.setDate(date.getDate() - 1);
      this.currentDate = date;
      this.loadPrograms();
      this.displayEmission();
    },
    nextDate() {
      const date = new Date(this.currentDate);
      date.setDate(date.getDate() + 1);
      this.currentDate = date;
      this.loadPrograms();
      this.displayEmission();
    },
    loadPrograms() {
  this.$api.get('podcasts', { params: { date: this.currentDate } })
    .then(response => {
      this.emissions = response.data.podcasts;
      this.programs = this.emissions.map(program => {
        program.start_time = new Date(program.start_time);
        return program;
      });
      this.programs.sort((a, b) => a.start_time - b.start_time);
      this.displayEmission();
    })
    .catch(error => {
      console.error('Erreur lors de la récupération des programmes :', error);
    });
},
    findAndDisplayCurrentEmission() {
      const currentEmission = this.emissions.find(emission => emission.date === this.formattedCurrentDate);
      if (currentEmission) {
        this.displayEmission(currentEmission);
      }
    },
    displayEmission() {
  const currentDate = new Date(this.currentDate);
  const currentYear = currentDate.getFullYear();
  const currentMonth = currentDate.getMonth() + 1;
  const currentDay = currentDate.getDate();

  this.currentEmission = this.emissions.find(emission => {
    const emissionDate = new Date(emission.date);
    return (
      emissionDate.getFullYear() === currentYear &&
      emissionDate.getMonth() + 1 === currentMonth &&
      emissionDate.getDate() === currentDay
    );
  });

  if (!this.currentEmission) {
    console.log('Aucune émission trouvée pour cette date');
  }
}
  }
}
</script>
<template>
  <header-component></header-component>

  <main>

    <en-direct></en-direct>

    <div class="programme">
      <h2>Grille des programmes</h2>
      <h3>Net Radio</h3>
      <div class="dates">
        <img src="/icons/gauche.svg" @click="prevDate">
        <p>{{ formattedCurrentDate }}</p>
        <img src="/icons/droite.svg" @click="nextDate">
      </div>

      <section>
        <div class="prog" v-for="(emission, index) in emissions" :key="emission.id">
          <div class="prog-infos">
            <div class="prog-infos-texte">
              <h5> {{ emission.titre }}</h5>
              <p>{{ emission.user }}</p>
              <p>Avec nom de l'invité, nom de l'invité, ...</p>
            </div>
            <img :src="emission.photo" alt="image de l'émission">
          </div>
          <div v-if="currentEmission">
             <h2>{{ currentEmission.title }}</h2>
             <p>{{ currentEmission.description }}</p>
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
