<template>
    <div id="app">
      <Header />
      <Emission :emission="emission" />
      <Podcast :podcast="podcast" />
      <Footer />
    </div>
  </template>
  
  <script>
  import Header from "./components/Header.vue";
  import Footer from "./components/Footer.vue";
  import Emission from "./components/Emission.vue";
  import Podcast from "./components/Podcast.vue";

  </script>