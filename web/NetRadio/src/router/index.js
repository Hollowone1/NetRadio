import { createRouter, createWebHistory } from 'vue-router'
import AccueilView from '@/views/AccueilView.vue'
import GrilleDesProgrammesViewVue from '@/views/GrilleProgrammesView.vue'
import ListeEmissionViewVue from '@/views/ListeEmissionsView.vue'
import ListePodcastsViewVue from '@/views/Liste-podcastsView.vue'
import PresentationEmissionViewVue from '@/views/PresentationEmissionView.vue'
import ResultatEmissionViewVue from '@/views/ResultatsEmissionsView.vue'
import ResultatPodcastViewVue from '@/views/ResultatsPodcastsView.vue'
import ToutesLesEmissionsViewVue from '@/views/ToutesEmissionsView.vue'
import ProfilUtilisateurViewVue from '@/views/ProfilUtilisateurView.vue'
import MonCompteViewVue from '@/views/MonCompteView.vue'
import ListeUtilisateursView from '@/views/Liste-utilisateurView.vue'

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
    {
      path: '/liste-utilisateur',
      name: 'liste des utilisateurs',
      component: ListeUtilisateursView
    },

  ]
})

export default router
