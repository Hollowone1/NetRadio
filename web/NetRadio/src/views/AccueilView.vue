<script>
import EnDirect from '@/components/EnDirect.vue'
import Emission from '@/components/Emission.vue'
import Podcast from '@/components/Podcast.vue'
import HeaderComponent from "@/components/HeaderComponent.vue";
export default {
  components: {
    EnDirect,
    HeaderComponent,
    Emission,
    Podcast
  },
  data() {
    return {

    }
  }
}
</script>

<template>

<EnDirect></EnDirect>
<Emission></Emission>
<Podcast></Podcast>
        <RouterView />
  </template>

<style scoped lang="scss">

@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";
.header {
    display: flex;
    align-items: center; 
    justify-content: space-between; 
    padding: 1%;
  }
  .podcasts {
  padding-top: 1em;
  padding-left: 3em;
  padding-right: 3em;
}

.emissions {
  padding-top: 1em;
  padding-left: 3em;
  padding-right: 3em;
}
  .header-logo {
    margin-left: 20px; 
    border-radius: 5px;
    height: 80px;
    width : auto;
  }
  
  .header-boutons {
    display: flex; 
    .header-user-co{
        height: 50px;
        width: auto;
        margin : .5em 0em .5em 0em; 
    }
    
    .header-boutons-connecter{
    
            @include buttonStyle($purple, $purple, white, auto, 1em, .5em 0em .5em 0em, 0px);
            font-weight: 500;
            margin-right: 10px;
    }
    .search{
  
        border-color:transparent;
        border-bottom-color:#dcdcdc;
        border-right-color: #dcdcdc;
        border-radius: 5px;
        width : auto;
        font-size : 1em;
        margin : .5em 0em .5em 0em; 
        
    }
  }
  
  .header-boutons-connecter {
    margin-right: 10px; 
  }
  @media (max-width: 768px) {
    .header {
      flex-direction: column;
      padding: 20px;
    }
  
    .header-logo {
      width: 20%;
      height: auto;
      margin-bottom: 20px;
    }
  
    .header-boutons {
      flex-direction: row;
      align-items: center;
      margin-bottom: 20px;
    }
  
    .header-user-co {
      height: 40px;
      width: auto;
      margin-right: 10px;
    }
  
    .header-boutons-connecter {
      font-size: 0.8em;
      padding: 5px 10px;
    }
  
    .search {
      width: 100%;
      font-size: 0.8em;
      padding: 5px 10px;
    }
  }
  
  
</style>