<script>
export default {
  emits: ['close', 'edited', 'created'],
  props: {
    emission: {
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
      newEmission : {
        titre: "",
        user: "",
        theme: "",
        description: "",
        photo: ""
      },
      editedEmission: {
        id: this.emission.id,
        titre: this.emission.titre,
        user: this.emission.user,
        theme: this.emission.theme,
        description: this.emission.description,
        photo: this.emission.photo
      },
      changed: false
    }
  },
  methods: {
    cancelCreating() {
      this.$emit('close')
      this.newEmission = {
        titre: "",
            user: "",
            theme: "",
            description: "",
            photo: ""
      }
    },
    stopPopup() {
      if (this.newOne) {
        if (this.changed) {
          this.createEmission()
          this.$emit('created')
        } else {
          this.$emit('close')
        }
      } else {
        if (this.changed) {
          this.editEmission()
          this.$emit('edited')
        } else {
          this.$emit('close')
        }
      }
    },
    editEmission() {
      console.log("editEmission", this.editedEmission)
      this.edit = false
      this.$api.put(`emissions/${this.editedEmission.id}`, {
        titre: this.editedEmission.titre,
        theme: this.editedEmission.theme,
        description: this.editedEmission.description,
        photo: this.editedEmission.photo,
        onDirect : 0,
        user: this.editedEmission.user
      }).then(() => {
        this.changed = false
      }).catch((err) => {
        console.log(err.response.data)
      })
    },
    createEmission() {
      console.log("createEmission", this.newEmission)
      this.$api.post(`emissions/`, {
        titre: this.newEmission.titre,
        theme: this.newEmission.theme,
        description: this.newEmission.description,
        photo: this.newEmission.photo,
        onDirect : 0,
        user: this.newEmission.user
      }).then(() => {
        this.changed = false
      }).catch((err) => {
        console.log(err.response.data)
      })
    }
  },
  watch: {
    editedEmission: {
      handler() {
        this.changed = true
      },
      deep: true
    },
    newEmission: {
      handler() {
        this.changed = true
      },
      deep: true
    }
  }
}

</script>

<template>
  <div v-if="!newOne" class="modal-mask">
    <div class="modal-wrapper">

      <div class="popup">

        <div v-if="edit === false" class="popup-emission">
          <div class="top">
            <h3>{{ emission.titre }}</h3>
            <img @click="edit = true" src="/icons/editPurple.svg" alt="edit icon"/>
          </div>
          <div class="infos">
            <p><strong>Présentateur / animateur :</strong> {{ emission.user }}</p>
            <p>{{ emission.theme }}</p>
            <p>{{ emission.description }}</p>
            <p>Photo : <a :href="emission.photo">{{emission.photo}}</a></p>
          </div>
        </div>

        <div v-else class="popup-emission-edit">
          <div><img @click="stopPopup" src="/icons/check.svg" alt="edit icon"/></div>
          <div class="titre">
            <label for="titre">Titre de l'émission :</label>
            <input type="text" id="titre" v-model="editedEmission.titre">
          </div>
          <div class="presentateur">
            <label for="presentateur">Email du présentateur :</label>
            <input type="text" id="presentateur" v-model="editedEmission.user">
          </div>
          <div class="theme">
            <label for="theme">Thème :</label>
            <input type="text" id="theme" v-model="editedEmission.theme">
          </div>
          <div class="photo">
            <label for="photo">Photo :</label>
            <input type="text" id="photo" v-model="editedEmission.photo">
          </div>
          <div class="description">
            <label for="description">Description :</label>
            <textarea id="description" v-model="editedEmission.description"/>
          </div>
        </div>

      </div>

    </div>
  </div>

  <div v-if="newOne" class="modal-mask">
    <div class="modal-wrapper">

      <div class="popup">

        <div class="popup-emission-create">
          <div>
            <div @click="cancelCreating" class="cancel">Annuler</div>
            <img @click="stopPopup" src="/icons/check.svg" alt="edit icon"/>
          </div>
          <div class="titre">
            <label for="titre">Titre de l'émission :</label>
            <input type="text" id="titre" v-model="newEmission.titre">
          </div>
          <div class="presentateur">
            <label for="presentateur">Email du présentateur :</label>
            <input type="text" id="presentateur" v-model="newEmission.user">
          </div>
          <div class="theme">
            <label for="theme">Thème :</label>
            <input type="text" id="theme" v-model="newEmission.theme">
          </div>
          <div class="photo">
            <label for="photo">Photo :</label>
            <input type="text" id="photo" v-model="newEmission.photo">
          </div>
          <div class="description">
            <label for="description">Description :</label>
            <textarea id="description" v-model="newEmission.description"/>
          </div>
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

.popup {
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
    a {
      color: $grey;
    }

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

