<script>
import {mapState, mapActions} from "pinia";
import {useUserStore} from "@/stores/user.js";
import {toast} from "vue3-toastify";
import ToastOptions from "../toasts/toastOptions.js";

export default {
  data() {
    return {
      mail: "",
      password: "",
      username: "",
      nom: "",
      prenom: "",
      errorMessage: null
    }
  },
  methods: {
    ...mapActions(useUserStore, ['loginUser']),
    inscrire() {
      const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      const passwordRegex = /^(?=.*[A-Z])[a-zA-Z\d]{8,}$/

      if (!emailRegex.test(this.mail)) {
        toast.error('Format d\'email invalide.', ToastOptions)
        this.errorMessage = "Format d'email invalide.";
      }

      if (!passwordRegex.test(this.password)) {
        toast.error('Mot de passe invalide. Il doit contenir 8 caractères et au moins une majuscule.', ToastOptions)
        this.errorMessage = "Mot de passe invalide. Il doit contenir 8 caractères et au moins une majuscule.";
      }

      this.$api.post('/users/signup', {
        email: this.mail.trim(),
        username: this.username.trim(),
        password: this.password.trim(),
        nom: this.nom.trim(),
        prenom: this.prenom.trim()
      }).then((resp) => {
        this.connexionAfter()
        this.$router.push('/')
      }).catch(err => {
        //err.response.data.error ? this.errorMessage = err.response.data.error : this.errorMessage = null
        //err.response.data.exception[0].message ? this.errorMessage = err.response.data.exception[0].message : this.errorMessage = null
        toast.error(`Erreur lors de l'inscription.`, ToastOptions)
      })
    },
    connexionAfter() {
      this.$api.post('/users/signin', {}, {
        auth : {
          username: this.mail,
          password: this.password
        }
      }).then(resp => {
        this.loginUser(resp.data)
      }).catch(err => {
        toast.error(`Erreur dans connexion après l\'inscription : ${err.response.data}`, ToastOptions)
      })
    },
  }
}

</script>

<template>
  <div class="login-container">
    <div class="login-form">
      <h2>Inscription</h2>
      <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
      <div class="form-group">
        <label for="nom">Nom</label>
        <input v-model="nom" type="text" id="nom" placeholder=" " required/>
      </div>
      <div class="form-group">
        <label for="prenom">Prénom</label>
        <input v-model="prenom" type="text" id="prenom" placeholder=" " required/>
      </div>
      <div class="form-group">
        <label for="username">Nom d'utilisateur</label>
        <input v-model="username" type="text" id="username" placeholder=" " required/>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input v-model="mail" type="email" id="email" placeholder=" " required/>
      </div>
      <div class="form-group">
        <label for="password">Mot de passe</label>
        <input v-model="password" type="password" id="password" placeholder=" " required/>
      </div>
      <button @click="inscrire()" class="login-button">S'inscrire</button>
      <div class="connexion">
        <RouterLink to="/Connexion">Déjà un compte ? Connectez-vous</RouterLink>
      </div>

    </div>
  </div>
</template>

<style scoped lang="scss">

.error {
  text-align: center;
  background-color: #ffecec;
  color: #e74c3c;
  padding: 10px;
  border-radius: 5px;
  margin-bottom: 20px;
}

.form-group {
  display: block;
  padding: 1em;
}

p {
  text-align: justify;
}

h2 {
  font-size: 35px;
  color: inherit;
  font-weight: inherit;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
  align-items: stretch;
}

label {
  font-size: inherit;
  color: inherit;
  font-weight: inherit;
  width: 30em;
  margin-left: auto;
  margin-right: auto;
  display: flex;
  flex-direction: column;
  flex-wrap: wrap;
  justify-content: center;
  gap: 0;
  align-items: stretch;
  text-align: left;
}

button {
  cursor: pointer;
  font-weight: 400;
  display: flex;
  width: 30em;
  justify-content: center;
  align-items: center;
  flex: 1 0 0;
  border: 2px solid #D4C2FC;
  background-color: #A568BB;
  color: #D9D9D9;
  font-size: 1em;
  padding: 1em;
  margin: 0.5em 0em 0.5em 0em;
  border-radius: 0px;
  transition: border-radius 0.3s;
  margin-left: auto;
  margin-right: auto;
  margin-bottom: 2em;
}

button:hover {
  background-color: #8d4ba5;
  border: 2px solid #b291fa;
  color: white;
}

label {
  font-size: inherit;
  color: inherit;
  font-weight: inherit;
  height: 50px;

}

input {
  font-size: inherit;
  color: inherit;
  font-weight: inherit;
  height: 40px;
  background-color: #E9E9E9;
  margin-bottom: 10px;
  width: 30em;
  padding: 0.2em;

}

hr {
  width: 60em;
}

.register {
  text-align: center;
}

input {
  border: transparent;
  border-bottom: 1px solid #a2a2a2;
}

a {
  text-decoration: none;
  color: #b291fa;
}

.login-container {
  margin-top: 40px;
  margin-bottom: 40px;
  margin: 5em;
  text-align: center;

}

@media screen and (max-width: 750px) {
  input {
    width: 15em;
  }
  label {
    width: 15em;
  }
  .login-button {
    width: 15em;
  }
}

</style>