<script>
import EnDirect from '@/components/EnDirect.vue'

export default {
  components: {
    EnDirect,
  },
  data() {
    return {
      emissions: [],
    }
  },
  created() {
    this.$api.get("emissions")
      .then(response => {
        console.log(response)
        this.emissions = response.data.emission;
      })
      .catch(error => {
        console.error('Erreur lors de la récupération des programmes :', error);
      });
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
        <div class="prog" v-for="(emission, index) in emissions" :key="index">
          <div class="prog-infos">
            <div class="prog-infos-texte">
              <h5> {{ emission.titre }}</h5>
              <p>{{ emission.user }}</p>
              <p>Avec nom de l'invité, nom de l'invité, ...</p>
            </div>
            <img :src="emission.photo" alt="image de l'émission">
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
