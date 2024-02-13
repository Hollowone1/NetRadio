<script>
export default {
  props: {
    placeholder: {
      type: String,
      required: false,
      default: "Rechercher"
    },
    genre: {
      type: Array,
      required: false
    }
  }

}
</script>

<template>
  <div class="recherche">
    <div class="barre-recherche">
      <img src="/icons/loupe.svg" alt="icone recherche">
      <input type="text" :placeholder="placeholder">
    </div>
    <div v-if="genre" class="genres">
      <button class="genre">Genre</button>
      <button class="genre">Autre genre</button>
      <button class="genre">Encore genre</button>
      <button class="genre">Dernier genre</button>
      <button class="genre">Genre</button>
      <button class="genre">Genre</button>
    </div>
  </div>
</template>

<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";

.barre-recherche {
  padding: .5em .5em .5em 1em;
  background-color: $lightLightGrey;
  border-bottom: 1px solid $lightGrey;
  @include flex(row, nowrap, .5em, start, center);
  margin-bottom: 1em;
}

input {
  background-color: $lightLightGrey;
  border: none;
  padding: 1em;
  width: 85%;
  @include text-style(1em, inherit, 400);
}

.genres {
  margin-top: 1em;

  button {
    display: inline-block !important;
    padding: .5em 1em .5em 1em;
    @include buttonStyle($transparent, $purple, $purple, auto, 1em, .2em);
    flex-grow: 2;

    &:hover {
      background-color: $purple;
      color: white;
      transition: background-color 0.3s;
    }
  }
}
</style>