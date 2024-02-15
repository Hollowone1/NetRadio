<script>
export default {
  data() {
    return {
      mail : "",
      password : "",
      password2 : "",
      username: "",
      errorMessage : null
    }
  },
  methods: {
    inscrire() {
      console.log('Inscription !')
      //api post inscription avec data
    }
  }
}

</script>

<template>
  <div class="login-container">
    <div class="login-form">
      <h2>Inscription</h2>
      <div v-if="errorMessage" class="error">{{errorMessage}}</div>
      <div class="form-group">
        <input v-model="username" type="text" id="username" placeholder=" " required />
        <label for="username">Nom d'utilisateur</label>
      </div>
      <div class="form-group">
        <input v-model="mail" type="email" id="email" placeholder=" " required />
        <label for="email">Email</label>
      </div>
      <div class="form-group">
        <input v-model="password" type="password" id="password" placeholder=" " required />
        <label for="password">Mot de passe</label>
      </div>
      <div class="form-group">
        <input v-model="password2" type="password" id="password" placeholder=" " required />
        <label for="password">Confirmer le mot de passe</label>
      </div>
      <button @click="inscrire()" class="login-button">S'inscrire</button>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>