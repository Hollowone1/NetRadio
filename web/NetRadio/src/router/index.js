import { createRouter, createWebHistory } from 'vue-router'
import Accueil from '@/views/AccueilView.vue'
import GrilleDesProgrammes from '@/views/GrilleProgrammesView.vue'
import ListeEmission from '@/views/ListeEmissionsView.vue'
import ListePodcasts from '@/views/Liste-podcastsView.vue'
import PresentationEmission from '@/views/PresentationEmissionView.vue'
import ResultatEmission from '@/views/ResultatsEmissionsView.vue'
import ResultatPodcast from '@/views/ResultatsPodcastsView.vue'
import ToutesLesEmissions from '@/views/ToutesEmissionsView.vue'
import ProfilUtilisateur from '@/views/ProfilUtilisateurView.vue'
import MonCompte from '@/views/MonCompteView.vue'
import ListeUtilisateurs from '@/views/Liste-utilisateurView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [



    {
      path: '/',
      name: 'accueil',
      component: Accueil
    },
    {
      path: '/grille-des-programmes',
      name: 'grille des programmes',
      component: GrilleDesProgrammes
    },
    {
      path: '/liste-des-emissions',
      name: 'liste des emissions',
      component: ListeEmission
    },
    {
      path: '/liste-des-podcasts',
      name: 'liste des podcasts',
      component: ListePodcasts
    },
    {
      path: '/presentation-emission',
      name: 'presentation des émissions',
      component: PresentationEmission
    },
    {
      path: '/resultat-emission',
      name: 'résultat des émissions',
      component: ResultatEmission
    },
    {
      path: '/resultat-podcast',
      name: 'résultat des podcast',
      component: ResultatPodcast
    },
    {
      path: '/toutes-les-emissions',
      name: 'résultat des emissions',
      component: ToutesLesEmissions
    },
    {
      path: '/profil',
      name: 'profil-utilisateurs',
      component: ProfilUtilisateur
    },
    {
      path: '/mon-compte',
      name: 'mon compte',
      component: MonCompte
    },
    {
      path: '/liste-utilisateur',
      name: 'liste des utilisateurs',
      component: ListeUtilisateurs
    },

  ]
})

export default router

