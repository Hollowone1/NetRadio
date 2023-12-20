Vue.component('navbarBack', {
    data: function () {
      return {
        
      }
    },
    template:`<section>
    <aside>
        <router-link to="">Mon compte</router-link>
        <router-link to="">Enregistrements</router-link>
        <router-link to="">Déconnexion</router-link>
    </aside>
    <section>
        <div class="navProfil">
            <router-link to="">En direct</router-link>
            <router-link to="">Podcasts</router-link>
            <router-link to="">Emissions</router-link to="">
            <router-link to="">Grille des programmes</router-link>
        </div>
        <div class="account">
            <router-link to="">Mon compte</router-link to="">
            <button>Modifier mes informations</button>
            
        </div>
        <div class="info">
            <img alt="profile">
            <p>Nom</p>
            <p>Prénom</p>
            <p>Mot de passe</p>
        </div>
    </section>
</section>`
})