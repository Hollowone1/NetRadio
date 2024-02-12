import { createRouter, createWebHistory } from 'vue-router'
import AccueilView from '../views/HomeView.vue'
import GrilleDesProgrammesViewVue from '@/views/Grille-des-programmesView.vue'
import ListeEmissionViewVue from '@/views/Liste-emission-view.vue'
import ListePodcastsViewVue from '@/views/Liste-podcastsView.vue'
import PresentationEmissionViewVue from '@/views/Presentation-emissionView.vue'
import ResultatEmissionViewVue from '@/views/Resultat-emissionView.vue'
import ResultatPodcastViewVue from '@/views/Resultat-podcastView.vue'
import ToutesLesEmissionsViewVue from '@/views/Toutes-les-emissionsView.vue'
import ProfilUtilisateurViewVue from '@/views/Profil-utilisateurView.vue'
import MonCompteViewVue from '@/views/Mon-compteView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'accueil',
      component: AccueilView
    },
    {
      path: '/grille-des-programmes',
      name: 'grille des programmes',
      component: GrilleDesProgrammesViewVue
    },
    {
      path: '/liste-des-emissions',
      name: 'liste des emissions',
      component: ListeEmissionViewVue
    },
    {
      path: '/liste-des-podcasts',
      name: 'liste des podcasts',
      component: ListePodcastsViewVue
    },
    {
      path: '/presentation-emission',
      name: 'presentation des émissions',
      component: PresentationEmissionViewVue
    },
    {
      path: '/resultat-emission',
      name: 'résultat des émissions',
      component: ResultatEmissionViewVue
    },
    {
      path: '/resultat-podcast',
      name: 'résultat des podcast',
      component: ResultatPodcastViewVue
    },
    {
      path: '/toutes-les-emissions',
      name: 'résultat des emissions',
      component: ToutesLesEmissionsViewVue
    },
    {
      path: '/profil',
      name: 'profil-utilisateurs',
      component: ProfilUtilisateurViewVue
    },
    {
      path: '/mon-compte',
      name: 'mon compte',
      component: MonCompteViewVue
    },

  ]
})

export default router
