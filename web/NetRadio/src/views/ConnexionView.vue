<script>
export default {
  data() {
    return {
      mail: "",
      password: "",
      errorMessage: null
    }
  },
  methods: {
    connection() {
      console.log('Connexion !')
      //api post connexion avec data
    }
  }
}

</script>

<template>
  <div >
    <form class="login-form">
      <h2>Connexion</h2>
      <div v-if="errorMessage" class="error">{{errorMessage}}</div>

      <div class="form-group">
        <input v-model="mail" type="email" id="email" placeholder=" " required />
        <label for="email">Email</label>
      </div>
      <div class="form-group">
        <input v-model="password" type="password" id="password" placeholder=" " required />
        <label for="password">Mot de passe</label>
      </div>
      <button @click="connection()" class="login-button">Se connecter</button>
      <div class="register"><RouterLink to="/inscription">Pas encore de compte ? Inscrivez-vous</RouterLink></div>
    </form>
  </div>
</template>

<style scoped lang="scss">

</style>