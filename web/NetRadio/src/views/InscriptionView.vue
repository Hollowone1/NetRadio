<script>
export default {
  data() {
    return {
      mail : "",
      password : "",
      username: "",
      errorMessage : null
    }
  },
  methods: {
    inscrire() {

      this.$api.post('/signup', {
        username: this.username,
        email: this.mail,
        password: this.password,
      })
      .then(response => {
        console.log('Inscription réussie :', response);
        // Rediriger vers la page de connexion ou afficher un message de succès
      })
      .catch(error => {
        console.error('Erreur lors de l\'inscription :', error);
        this.errorMessage = "Une erreur s'est produite lors de l'inscription.";
      });
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
        <label for="username">Nom d'utilisateur</label>
        <input v-model="username" type="text" id="username" placeholder=" " required />     
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input v-model="mail" type="email" id="email" placeholder=" " required />
      </div>
      <div class="form-group">
        <label for="password">Mot de passe</label>
        <input v-model="password" type="password" id="password" placeholder=" " required />  
      </div>
      <button @click="inscrire()" class="login-button">S'inscrire</button>
    </div>
  </div>
</template>

<style scoped lang="scss">

.form-group{
  display:block;
  text-align: center;
}


body {
  margin: 0;
  padding: 0;
}


@font-face {
  font-family: "Inter";
  src: url("../fonts/Inter/Inter-VariableFont_slnt,wght.ttf");
}
* {
  font-family: "Inter", Helvetica, Arial, sans-serif;
}

p {
  text-align: justify;
}

h2 {
  font-family: "Inter", sans-serif;
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
  font-family: "Inter", sans-serif;
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
}

button {
  cursor: pointer;
  font-family: "Inter", Helvetica, Arial, sans-serif;
  font-weight: 400;
  display: flex;
  width: auto;
  justify-content: center;
  align-items: center;
  flex: 1 0 0;
  border: 2px solid #D4C2FC;
  background-color: #A568BB;
  color: #D9D9D9;
  font-size: 1em;
  padding: 0.5em 1em 0.5em 1em;
  margin: 0.5em 0em 0.5em 0em;
  border-radius: 0px;
  transition: border-radius 0.3s;
  margin-left: auto;
  margin-right: auto;
}
button:hover {
  background-color: #8d4ba5;
  border: 2px solid #b291fa;
}

label {
  font-size: inherit;
  color: inherit;
  font-weight: inherit;
  height: 30px;
}

input {
  font-size: inherit;
  color: inherit;
  font-weight: inherit;
  height: 40px;
  background-color: #E9E9E9;
  margin-bottom: 10px;
}

hr {
  width: 30em;
}
.register{
  text-align: center;
}

a{
  text-decoration: none;
  color: #b291fa;
}
form {
  margin-top: 40px;
  margin-bottom: 40px;
}

</style>