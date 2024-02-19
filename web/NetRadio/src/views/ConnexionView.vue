<script>
import { mapActions } from 'pinia'
import { useUserStore } from '@/stores/user.js'

export default {
  data() {
    return {
      mail: "",
      password: "",
      errorMessage: null
    }
  },
  methods: {
    ...mapActions(useUserStore, ['loginUser']),
    connection() {
      console.log('Connexion !')
      this.$api.post('/users/signin', {}, {
        auth : {
          username: this.mail,
          password: this.password
        }
      }).then(resp => {
        this.loginUser(resp.data)
        this.$router.push('/')
      }).catch(err => {
        err.response.data.error ? this.errorMessage = err.response.data.error : this.errorMessage = null
        //console.log(err)
      })
    }
  }
}

</script>

<template>
  <div>
    <div class="login-form form">
      <h2>Connexion</h2>
      <div v-if="errorMessage" class="error">{{errorMessage}}</div>
      <div class="form-group">
        <label for="email">Email</label>
        <input v-model="mail" type="email" id="email" placeholder="Votre adresse e-mail ..." required />
      </div>
      <div class="form-group">
        <label for="password">Mot de passe</label>
        <input v-model="password" type="password" id="password" placeholder="Votre mot de passe ..." required />
      </div>
      <button @click="connection()" class="login-button">Se connecter</button>
      <div class="register"><RouterLink to="/inscription"> Pas encore de compte ? Inscrivez-vous</RouterLink></div>
    </div>
  </div>
</template>

<style scoped lang="scss">

.form-group{
  display:block;
  padding: 1em;
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
.register{
  text-align: center;
  color: #8d4ba5;
}
input{
  border: transparent;
  border-bottom: 1px solid #a2a2a2;
}

.form {
  margin-top: 40px;
  margin-bottom: 40px;
  margin: 5em;
  text-align: center;

}
a{
  color: #8d4ba5;
}
@media screen and (max-width: 750px) {
  input{
    width: 15em;
  }
  label{
    width: 15em;
  }
  .login-button{
    width: 15em;
  }
  form {

  margin: 9em;

}
}

</style>