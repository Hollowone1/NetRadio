import { createRouter, createWebHistory } from 'vue-router'
import Accueil from '@/views/AccueilView.vue'
import GrilleDesProgrammes from '@/views/GrilleProgrammesView.vue'
import ListeEmission from '@/views/ListeEmissionsView.vue'
import ListePodcasts from '@/views/ListePodcastsView.vue'
import PresentationEmission from '@/views/PresentationEmissionView.vue'
import MonCompte from '@/views/MonCompteView.vue'
import Connexion from '@/views/ConnexionView.vue'
import Inscription from '@/views/InscriptionView.vue'



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
      path: '/emissions/:id',
      name: 'presentation emission',
      component: PresentationEmission
    },
    {
      path: '/mon-compte',
      name: 'mon compte',
      component: MonCompte
    },
    {
      path: '/connexion',
      name: 'connexion',
      component: Connexion
    },
    {
      path: '/inscription',
      name: 'inscription',
      component: Inscription
    },
    {
        path: '/ecouterEmission/:id',
        name: 'ecouterEmission',
        component: () => import('@/views/EcouterEmission.vue')
    },
    {
      path: '/enregistrerEmission',
      name: 'enregistrerEmission',
      component: () => import('@/views/EnregistrerEmission.vue')
    },

  ]
})

export default router