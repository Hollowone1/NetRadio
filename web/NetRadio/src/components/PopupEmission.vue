Fonctionne
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
        user: this.emission.user,
        theme: this.emission.theme,
        description: this.emission.description
      }
    }
  },
  directives: {
    outside : {
      beforeMount(el, binding) {
        el.clickOutsideEvent = function(event) {
          if (!(el === event.target || el.contains(event.target))) {
            console.log('click outside', binding.value)

            //vnode.context.$emit('close')
            //el.dispatchEvent(event);
          }
        };
        document.addEventListener('click', el.clickOutsideEvent);
      },
      unmounted(el) {
        // Remove the event listener when the bound element is unmounted
        document.removeEventListener('click', el.clickOutsideEvent);
      }
    },
  },
  methods: {
    stopEditing() {
      this.edit = false
      this.$emit('edited')
      //console.log(this.editedEmission)
      this.editEmission()
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

      <div v-outside="edit" v-if="edit === false" class="popup-emission">
        <div class="top">
          <h3>{{ emission.titre }}</h3>
          <img @click="edit = true" src="/icons/editPurple.svg" alt="edit icon"/>
        </div>
        <div class="infos">
          <p><strong>Présentateur / animateur :</strong> {{ emission.user }}</p>
          <p>{{ emission.theme }}</p>
          <p>{{ emission.description }}</p>
        </div>
      </div>

      <div v-outside v-if="edit === true" class="popup-emission-edit">
        <div><img @click="stopEditing" src="/icons/check.svg" alt="edit icon"/></div>
        <div class="titre">
          <label for="titre">Titre de l'émission :</label>
          <input type="text" id="titre" v-model="editedEmission.titre">
        </div>
        <div class="presentateur">
          <label for="presentateur">Présentateur :</label>
          <input type="text" id="presentateur" v-model="editedEmission.user">
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

$widthPopup : 60vw;
$widthPopupEm: 30em;

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
  width:$widthPopup;
  max-width: calc($widthPopupEm * 1.5);
  min-width: calc($widthPopupEm / 1.5);

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
      @include text-style(1.5em, $lightBlack, 500);
    }
  }

  .infos {
    @include flex(column, nowrap, .5em, start);

    p:nth-child(1) {

      @include text-style(1.1em, inherit, inherit);
      strong {
        @include text-style(1em, inherit, 500);
      }
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
  @include flex(column, nowrap, 1em, start, flex-start);
  div {
    @include flex(column, nowrap, .5em, start, flex-start);
  }
  label {
    @include text-style(1.2em, $lightBlack, 500);
  }
  textarea{
    min-height: 6em;
  }
  input, textarea {
    width:calc($widthPopup - 1em);
    max-width: calc($widthPopupEm * 1.5);
    min-width: calc($widthPopupEm / 1.5);
    resize: none;
    border-color: transparent;
    border-bottom-color: #dcdcdc;
    background-color: $lightLightGrey;
    height: fit-content;
    font-size: 1em;
    padding: .3em .5em;
    @include text-style(.95em, $darkGrey, 300);
  }
  input:focus, textarea:focus {
    @include text-style(.95em, black, 350);
    outline: none !important;
  }
  div:nth-child(1){
    position: relative;
    height: 0;
    align-self: flex-end;
    img {
      height: 2em;
    }
  }
  .theme {
    margin-bottom: 0;
  }

}

</style>

