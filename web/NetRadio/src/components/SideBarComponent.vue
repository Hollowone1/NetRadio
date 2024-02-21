<script>
import {mapActions} from "pinia";
import {useUserStore} from "@/stores/user.js";

export default {
  emits: ['change'],
  data() {
    return {
      display: 1,
      menuMobile: false
    }
  },
  methods: {
    changeDisplay(number) {
      this.display = number;
      this.menuMobile = false;
      let target = event.target;
      target.className = "selected"
      this.$emit('change', number);
    },
    classSelected(number) {
      if (this.display === number) {
        return true;
      }
    },
    ...mapActions(useUserStore, ['logoutUser']),
    logOut() {
      this.logoutUser()
      this.$router.push('/connexion')
    }
  },
}
</script>

<template>
  <aside>
    <div class="nav-list">
      <div class="nav-list">
        <div :class="{ selected: classSelected(1) }" @click="changeDisplay(1)">
          <slot name="1"></slot>
        </div>
        <div :class="{ selected: classSelected(2) }" @click="changeDisplay(2)">
          <slot name="2"></slot>
        </div>
        <div :class="{ selected: classSelected(3) }" @click="changeDisplay(3)">
          <slot name="3"></slot>
        </div>
        <div :class="{ selected: classSelected(4) }" @click="changeDisplay(4)">
          <slot name="4"></slot>
        </div>
      </div>
    </div>
    <div @click="logOut" class="deco">Déconnexion</div>
  </aside>

  <div class="burger">
    <img v-if="!menuMobile" src="/icons/menu-mobile.svg" alt="menu" @click="menuMobile = true">
  </div>
  <div class="mobile" :class="{ active: menuMobile }">
    <img src="/icons/croixBlanc.svg" alt="croix" @click="menuMobile = false">
    <div class="nav">
      <div class="nav-list">
        <div :class="{ selected: classSelected(1) }" @click="changeDisplay(1)">
          <slot name="1"></slot>
        </div>
        <div :class="{ selected: classSelected(2) }" @click="changeDisplay(2)">
          <slot name="2"></slot>
        </div>
        <div :class="{ selected: classSelected(3) }" @click="changeDisplay(3)">
          <slot name="3"></slot>
        </div>
        <div :class="{ selected: classSelected(4) }" @click="changeDisplay(4)">
          <slot name="4"></slot>
        </div>
      </div>
      <div @click="logOut" class="deco">Déconnexion</div>
    </div>
  </div>

</template>

<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";

.mobile, .burger {
  display: none;
}

aside {
  background-color: $lightBlack;
  @include text-style(.9em, $white, 400);
  text-align: center;
  text-transform: uppercase;
  padding-top: 2em;
  padding-bottom: 2em;
  min-width: 12em;
  max-width: 20em;
  flex-basis: 20vw;
  flex-shrink: 0;
  flex-grow: 1;
  @include flex(column, nowrap, 1em, space-between);

  .nav-list {
    @include flex(column, wrap, 2em, stretch, stretch);
    div {
      padding-top: 1em;
      padding-bottom: 1em;
    }
    .selected {
      background-color: $grey;
    }
  }
}

.deco {
  @include text-style(inherit, $purple, 400);
}

@media screen and (max-width: 800px) {

  aside {
    display: none;
  }
  .mobile, .burger {
    display: block;
  }

  .burger {
    background-color: $lightLightGrey;
    height: 2em;
    padding: 1em;

    img {
      height: 1.2em;
    }
  }

  .mobile {
    transition: left 0.5s ease;
    z-index: 1000;
    position: absolute;
    top: 0;
    left: -100vw;
    background-color: $lightBlack;
    width: 70vw;
    min-height: 100vh;
    @include text-style(.9em, $white, 400);
    text-transform: uppercase;
    padding-top: 1em;

    .nav {
      text-align: center;
      @include flex(column, nowrap, 10vh, space-between);
    }

    .nav-list {
      @include flex(column, wrap, 2em, center, stretch);

      div {
        padding: 1em;
      }

      .selected {
        background-color: $grey;
      }
    }

    img {
      height: 1.4em;
      margin: 1em;
    }
  }

  .active {
    left: 0;
  }


}

</style>