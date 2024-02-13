<script>
export default {
  props: {
    emission: {
      type: Object,
      required: true,
    }
  },
  data() {
    return {
      edit: false,
      editedEmission: {
        titre: this.emission.titre,
        presentateur: this.emission.presentateur,
        theme: this.emission.theme,
        description: this.emission.description
      }
    }
  },
  methods: {
    stopEditing() {
      this.edit = false
      this.$emit('close')
    },
    editEmission() {
      //faire un put sur l'API avec les valeurs du v-model
    }
  }
}

</script>

<template>
  <div class="modal-mask">
    <div class="modal-wrapper">

      <div v-if="edit === false" class="popup-emission">
        <div class="top">
          <h3>{{ emission.titre }}</h3>
          <img @click="edit = true" src="/icons/editPurple.svg" alt="edit icon"/>
        </div>
        <div class="infos">
          <p><strong>Présentateur / animateur :</strong> {{ emission.presentateur }}</p>
          <p>{{ emission.theme }}</p>
          <p>{{ emission.description }}</p>
        </div>
      </div>

      <div v-if="edit === true" class="popup-emission-edit">
        <img @click="stopEditing" src="/icons/check.svg" alt="edit icon"/>
        <div class="titre">
          <label for="titre">Titre de l'émission :</label>
          <input type="text" id="titre" v-model="editedEmission.titre">
        </div>
        <div class="presentateur">
          <label for="presentateur">Présentateur :</label>
          <input type="text" id="presentateur" v-model="editedEmission.presentateur">
        </div>
        <div class="theme">
          <label for="theme">Thème :</label>
          <input type="text" id="theme" v-model="editedEmission.theme">
        </div>
        <div class="description">
          <label for="description">Description :</label>
          <textarea id="description" v-model="editedEmission.description"/>
        </div>
      </div>

    </div>
  </div>
</template>


<style scoped lang="scss">
@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";

.modal-mask {
  width: 100%;
  height: 100%;
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.popup-emission, .popup-emission-edit {
  width: fit-content;
  max-width: 60vw;
  background-color: $white;
  font-size: 1.1em;
  border: 3px solid $purple;
  border-radius: 10px;
  padding: 1em;
  margin: 0px auto;
}

.popup-emission {
  .top {
    @include flex(row, nowrap, 1em, space-between, center);
    padding-bottom: .5em;

    img {
      height: 2em;
    }

    h3 {
      margin: 0;
      @include text-style(1.4em, inherit, 500);
    }
  }

  .infos {
    @include flex(column, nowrap, .5em, start);

    p:nth-child(1) {
      @include text-style(1.1em, inherit, inherit);
    }

    p:nth-child(2) {
      @include text-style(1.2em, inherit, 200);
      text-transform: uppercase;
    }

    p:nth-child(3) {
      @include text-style(1em, inherit, 400);
    }
  }
}

.popup-emission-edit {
  img {
    height: 2em;
  }
  .infos {
    @include flex(column, nowrap, .5em, start);

    p:nth-child(1) {
      @include text-style(1.1em, inherit, inherit);
    }

    p:nth-child(2) {
      @include text-style(1.2em, inherit, 200);
      text-transform: uppercase;
    }

    p:nth-child(3) {
      @include text-style(1em, inherit, 400);
    }
  }
}

</style>
