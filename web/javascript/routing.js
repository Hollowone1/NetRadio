
const Accueil = { template: '<div>Accueil</div>' }
const Grille = { template: '<div>Grille</div>' }
const Liste_Emission = { template: '<div>Liste-emission</div>'}
const Liste_Podcast = { template: '<div>Liste-podcast</div>'}
const Presentation_Emission = { template: '<div>Presentation-emission</div>'}
const Resultat_Emission = { template: '<div>Resultat-emission</div>'}
const Resultat_Podcast = { template: '<div>Resultat-podcast</div>'}
const Connect = { template: '<div>Se-connecter</div>'}
const Profil = { template: '<div>Profil</div>'}


const routes = [
  { path: '/', component: Accueil },
  { path: '/grille-emission', component: Grille },
  { path: '/liste-emission', component: Liste_Emission},
  { path: '/liste-podcast', component: Liste_Podcast },
  { path:'/presentation-emission', component: Presentation_Emission},
  { path:'/resultat-emission', component: Resultat_Emission},
  { path:'/resultat-podcast', component: Resultat_Podcast},
  { path:'/se-connecter', component: Connect},
  { path:'/profil', component: Profil},


]

const router = VueRouter.createRouter({
  history: VueRouter.createWebHashHistory(),
  routes,
})

const app = Vue.createApp({})
app.use(router)

app.mount('#app')

