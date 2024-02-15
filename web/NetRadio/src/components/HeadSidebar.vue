<template>
  <Slide>
    <a id="home">
        <router-link to="/liste-des-podcasts">Podcasts</router-link>
    </a>
    <a id="about">
        <router-link to="/liste-des-emissions">Emissions</router-link>
    </a>
    <a id="contact">
        <router-link to="/grille-des-programmes">Grille des programmes</router-link>
    </a>


  </Slide>
</template>

<script>
import { Slide } from 'vue3-burger-menu'

export default {
  components: {
    Slide
  }
}
</script>

<style>
.bm-burger-button {
  position: fixed;
  width: 36px;
  height: 30px;
  left: 36px;
  top: 36px;
  cursor: pointer;
}

.bm-burger-bars {
  background-color: #373a47;
}

.line-style {
  position: absolute;
  height: 20%;
  left: 0;
  right: 0;
}
.router-link {
  text-decoration: none;
}
.cross-style {
  position: absolute;
  top: 12px;
  right: 2px;
  cursor: pointer;
}

.bm-cross {
  background: #bdc3c7;
}

.bm-cross-button {
  height: 24px;
  width: 24px;
}

@media screen and (min-width: 650px) {
    .bm-burger-button{
        visibility: hidden;
    }
}

.bm-menu {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1000;
  top: 0;
  left: 0;
  background-color: rgb(63, 63, 65);
  overflow-x: hidden;
  padding-top: 60px;
  transition: 0.5s;
}

.bm-overlay {
  background: rgba(0, 0, 0, 0.3);
}

a{
    text-decoration: none;
    color: white;
}

a:hover{
    color: #a568bb;
}
.bm-item-list {
  color: #b8b7ad;
  margin-left: 10%;
  font-size: 20px;
}

.bm-item-list > * {
  display: flex;
  text-decoration: none;
  padding: 0.7em;
}

.bm-item-list > * > span {
  margin-left: 10px;
  font-weight: 700;
  color: white;
}
</style>