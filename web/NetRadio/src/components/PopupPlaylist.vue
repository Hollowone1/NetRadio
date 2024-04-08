<script>
import {mapState, mapActions} from "pinia";
import {useUserStore} from "@/stores/user.js";

//TODO : véirfier si il y a vrmnt un changement dans la edtiedPlaylist avant de faire un put inutile
export default {
  props: {
    playlist: {
      type: Object,
      required: false,
      default: []
    },
    newOne: {
      type: Boolean,
      required: false,
      default: false
    }
  },
  data() {
    return {
      edit: false,
      sounds: [],
      editedPlaylist: {
        id: this.playlist.id,
        name: this.playlist.name,
        description: this.playlist.description,
        sounds: this.sounds
      },
      newPlaylist: {
        name: "",
        description: "",
        sounds: []
      },
      newSound: false,
      addedSound: {
        titre: "",
        nomArtiste: "",
        audio: ""
      },
    }
  },
  computed: {
    ...mapState(useUserStore, ['user'])
  },
  created() {
    this.$api.get(`/sons/playlist/${this.playlist.id}`)
        .then((response) => {
          this.sounds = response.data.sons
          this.editedPlaylist.sounds = this.sounds
        })
        .catch((error) => {
          console.log(error)
        });

  },
  methods: {
    cancelCreating() {
      this.$emit('close')
      this.newPlaylist = {
        name: "",
        description: "",
        sounds: []
      }
    },
    createPlaylist() {
      this.$api.post(`/playlists/`, {
        name: this.newPlaylist.name,
        description: this.newPlaylist.description,
        emailUser: this.user.email
      })
          .catch((error) => {
            console.log(error)
          });
      this.$emit('created')
    },
    cancelEditing() {
      this.$emit('close')
      this.editedPlaylist.sounds = this.sounds
    },
    stopEditing() {
      console.log(this.changed)
      this.newOne ? this.createPlaylist() : this.editPlaylist()
    },
    editPlaylist() {
      console.log("edited Playlist", this.editedPlaylist);
      //faire un put sur l'API avec les valeurs du v-model
      this.$emit('edited')
    },
    removeSound(id) {
      this.newOne ?
          this.newPlaylist.sounds = this.newPlaylist.sounds.filter(sound => sound.id !== id)
          : this.editedPlaylist.sounds = this.editedPlaylist.sounds.filter(sound => sound.id !== id)
    },
    addSound() {
      console.log(this.editedPlaylist.id)
      this.$api.post(`/playlists/${this.editedPlaylist.id}/son`, {
        son: {
          titre: this.addedSound.titre,
          nomArtiste: this.addedSound.nomArtiste,
          audio: this.addedSound.audio
        },
        idPlaylist: this.editedPlaylist.id
      })
          .catch((error) => {
            console.log(error)
          })
      this.editedPlaylist.sounds.push(this.addedSound)
      this.newSound = false
      this.addedSound = {
        titre: "",
        nomArtiste: "",
        audio: ""
      }
    }
  }
}

</script>

<template>


  <div v-if="!newOne" class="modal-mask">
    <div class="modal-wrapper">

      <div v-if="edit === false" class="popup-playlist">
        <div class="top">
          <h3>{{ playlist.name }}</h3>
          <img @click="edit = true" src="/icons/editPurple.svg" alt="edit icon"/>
        </div>
        <div class="infos">
          <p>{{ playlist.description }}</p>
          <p v-if="sounds.length > 0">Sons dans la playlist :</p>
          <ul v-if="sounds.length > 0" class="son">
            <li v-for="sound in sounds">{{ sound.titre }} - {{ sound.nomArtiste }}</li>
          </ul>
          <p v-else>Aucun son</p>
        </div>
      </div>

      <div v-else class="popup-playlist-edit">
        <div>
          <div @click="cancelEditing" class="cancel">Annuler</div>
          <img @click="stopEditing" src="/icons/check.svg" alt="edit icon"/>
        </div>
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
          <button v-if="!newSound" @click="newSound = true">Ajouter un son</button>
          <div v-if="newSound">
            <label for="titre">Titre :</label>
            <input type="text" id="titre" v-model="addedSound.titre">
            <label for="nom">Nom de l'artiste :</label>
            <input type="text" id="nom" v-model="addedSound.nomArtiste">
            <label for="audio">Lien vers l'audio :</label>
            <input type="text" id="audio" v-model="addedSound.audio">
            <button @click="addSound">Ajouter</button>
          </div>
          <div v-for="sound in editedPlaylist.sounds">
            <p>{{ sound.titre }} - {{ sound.nomArtiste }} (<a
                :href="sound.audio">{{ sound.audio }}</a>)</p>
            <img @click="removeSound(sound.id)" src="/icons/poubelle.svg" alt="delete icon"/>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div v-else class="modal-mask">
    <div class="modal-wrapper">
      <div class="popup-playlist-create">
        <div>
          <div @click="cancelCreating" class="cancel">Annuler</div>
          <img @click="stopEditing" src="/icons/check.svg" alt="edit icon"/>
        </div>
        <div class="info">
          <label for="nom">Nom de la playlist :</label>
          <input type="text" id="nom" v-model="newPlaylist.name">
        </div>
        <div class="info">
          <label for="description">Description :</label>
          <input type="text" id="description" v-model="newPlaylist.description">
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


a {
  @include text-style(1em, $purple, 500);
}

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

.popup-playlist, .popup-playlist-edit, .popup-playlist-create {
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

.cancel {
  cursor: pointer;
  @include text-style(1.2em, $purple, 500);
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
    padding-top: 2em;
    height: 0;
    width: 100%;
    @include flex(row, nowrap, 1em, space-between, end);

    img {
      height: 2em;
    }
  }

  .theme {
    margin-bottom: 0;
  }

}

</style>

