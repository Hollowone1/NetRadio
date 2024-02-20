<script>
export default {
  props: {
    user: {
      type: Object,
      required: true,
    }
  },
  data() {
    return {
      editedUser: {
        email: this.user.email,
        nom: this.user.nom,
        prenom: this.user.prenom,
        role: this.user.role,
        username: this.user.username
      },
      roles: ['Auditeur', 'Animateur', 'Administrateur']
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
    const roleIndex = parseInt(this.user.role) - 1;
    this.editedUser = {
      email: this.user.email,
      nom: this.user.nom,
      prenom: this.user.prenom,
      role: this.roles[roleIndex], // Utiliser l'index pour accéder au rôle correspondant dans roles
      username: this.user.username
    };
  },
  methods: {
    stopEditing() {
      this.$emit('edited')
      //console.log(this.editedEmission)
      this.editUser()
    },
    editUser() {
      this.editedUser.role = this.roles.indexOf(this.editedUser.role) + 1; // Utiliser indexOf pour récupérer l'index du rôle dans roles
      console.log("edited User", this.editedUser);
      //faire un put sur l'API avec les valeurs du v-model
    }
  }
}

</script>

<template>
  <div class="modal-mask">
    <div class="modal-wrapper">
      <div v-outside class="popup-user-edit">
        <div><img @click="stopEditing" src="/icons/check.svg" alt="edit icon"/></div>
        <div class="info">
          <label for="nom">Nom :</label>
          <input type="text" id="nom" v-model="editedUser.nom">
        </div>
        <div class="info">
          <label for="prenom">Prénom :</label>
          <input type="text" id="prenom" v-model="editedUser.prenom">
        </div>
        <div class="info">
          <label for="username">Nom d'utilisateur :</label>
          <input type="text" id="username" v-model="editedUser.username">
        </div>
        <div class="info">
          <label for="email">E-mail :</label>
          <input type="email" id="email" v-model="editedUser.email"/>
        </div>
        <div class="info">
          <label for="role">Rôle :</label>
          <select id="role" v-model="editedUser.role">
            <option v-for="role in roles" :value="role">{{ role }}</option>
          </select>
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

.popup-user, .popup-user-edit {
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

.popup-user {
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

.popup-user-edit {
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

