<script>
export default {
  props: {
    playlist: {
      type: Object,
      required: true,
    }
  },
  data() {
    return {
      edit: false,
      sounds: [],
      editedPlaylist: {
        name : this.playlist.name,
        description : this.playlist.description
      },
      addedSound : {
        titre : "",
        nomArtiste : "",
        audio: ""
      }
    }
  },
  directives: {
    outside: {
      beforeMount(el, binding) {
        el.clickOutsideEvent = function (event) {
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
  created() {
    //faire un get sur l'API pour récupérer les sons de la playlist

  },
  methods: {
    stopEditing() {
      this.$emit('edited')
      //console.log(this.editedEmission)
      this.editPlaylist()
    },
    editPlaylist() {
      console.log("edited Playlist", this.editedPlaylist);
      //faire un put sur l'API avec les valeurs du v-model
    }
  }
}

</script>

<template>
  <div class="modal-mask">
    <div class="modal-wrapper">

      <div v-outside v-if="edit === false" class="popup-playlist">
        <div class="top">
          <h3>{{ playlist.name }}</h3>
          <img @click="edit = true" src="/icons/editPurple.svg" alt="edit icon"/>
        </div>
        <div class="infos">
          <p>{{ playlist.description }}</p>
          <p>Sons dans la playlist : </p>
          <div class="son" v-for="sound in sounds"></div>
        </div>
      </div>

      <div v-else v-outside class="popup-playlist-edit">
        <div><img @click="stopEditing" src="/icons/check.svg" alt="edit icon"/></div>
        <div class="info">
          <label for="nom">Nom de la playlist :</label>
          <input type="text" id="nom" v-model="editedPlaylist.name">
        </div>
        <div class="info">
          <label for="description">Description :</label>
          <input type="text" id="description" v-model="editedPlaylist.description">
        </div>
        <div class="info">
          <label for="sons">Sons dans la playlist :</label>

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

$widthPopup: 60vw;
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

.popup-playlist, .popup-playlist-edit {
  width: $widthPopup;
  max-width: calc($widthPopupEm * 1.5);
  min-width: calc($widthPopupEm / 1.5);

  background-color: $white;
  font-size: 1.1em;
  border: 3px solid $purple;
  border-radius: 10px;
  padding: 1em;
  margin: 0px auto;
}

.popup-playlist {
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

.popup-playlist-edit {
  @include flex(column, nowrap, 1em, start, flex-start);

  div {
    @include flex(column, nowrap, .5em, start, flex-start);
  }

  label {
    @include text-style(1.2em, $lightBlack, 500);
  }

  input {
    width: calc($widthPopup - 1em);
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

  div:nth-child(1) {
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

