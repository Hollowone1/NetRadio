<script>
import {toast} from "vue3-toastify";
import ToastOptions from "../toasts/toastOptions.js";
import {useUserStore} from "@/stores/user.js";
export default {
  data() {
    return {
      emission: [],
      userRole: useUserStore().user.role
    }
  },
  created() {
    this.$api.get("/emissions")
        .then((response) => {
          this.emission = response.data.emission.find(emission => emission.onDirect === true)
        })
        .catch((error) => {
          toast.error('Erreur lors de la récupération de l\'émission en direct', ToastOptions)
        });
  },
  methods: {
    redirectToDirect() {
      this.$router.push({path: '/ecouterEmission/' + this.$route.params.id});
    }
  }
}
</script>


<template>
  <section class="direct">
    <div class="direct-infos">
      <div class="direct-infos-titre">
        <embed src="/icons/direct.svg"/>
        <h1>{{ emission.titre }}</h1>
      </div>
      <p class="direct-infos-sous-titre">EN DIRECT</p>
      <p class="direct-infos-desc">{{ emission.description }}</p>
      <button v-if="userRole === '1'" class="direct-infos-ecouter" @click="redirectToDirect()">Écouter</button>
      <button v-else class="direct-infos-ecouter" @click="redirectToDirect()">Lancer le direct</button>
    </div>
    <img class="direct-image" :src="emission.photo" alt="image de l'émission en direct">
  </section>
</template>

<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";



.direct {
  color: white;
  background-color: $lightBlack;
  padding: 1.5rem;
  @include flex(column, nowrap, 2vh, space-between);
  &-infos-titre {
    h1 {
      @include text-style(2rem, inherit, bold);
      display: inline-block;
      margin: 0;
    }
    embed {
      height: 1.5rem;
      display: inline-block;
      margin-right: .5em;
    }
  }
  &-infos-sous-titre {
    margin-top : .5rem;
    margin-bottom : 2rem;
    @include text-style(1em, inherit, 100);
  }
  &-infos-desc {
    text-align: justify;
  }
  button {
    @include buttonStyle($purple, $purple, white, auto, 1em, 1.5em 0em .5em 0em, 0px);
    font-weight: 500;
  }
  img {
    border-radius : 10px;
  }
}

@media screen and (min-width : 700px) and (max-width : 1024px){
  .direct {
    padding: 2rem;
    @include flex(row, nowrap, 4vw, space-between);
    &-infos-titre {
      @include grid(1fr 8fr);
      h1 {
        @include text-style(4vw, inherit, bold);
      }
      embed {
        height: 3vw;
      }
    }
    &-infos-sous-titre {
      @include text-style(2.5vw, inherit, 100);
      margin-bottom: .5em
    }
    &-infos-desc {
      text-align: justify;
      @include text-style(1em, inherit, normal);
      margin-bottom: 1em;
    }
    button {
      @include buttonStyle($purple, $purple, white, auto, 1em, .5em 0em .5em 0em, 0px);
    }
    img {
      width: 45vw;
      height: auto
    }
  }
}

@media screen and (min-width: 1024px) {
  .direct {
    padding: 3rem;
    @include flex(row, nowrap, 5vw, space-between);
    &-infos-titre {
      @include grid(1fr 15fr);
      h1 {
        @include text-style(2.5em, inherit, bold);
      }
      embed {
        height: 2em;
      }
    }
    &-infos-sous-titre {
      @include text-style(1.5em, inherit, 100);
    }
    &-infos-desc {
      text-align: justify;
      @include text-style(1.2em, inherit, normal);
      margin-bottom: 2em;
    }
    button {
      @include buttonStyle($purple, $purple, white, auto, 1.2em, .5em 0em .5em 0em, 0px);
    }
    img {
      width: 30vw;
      height: auto;
    }
  }
}
</style>
