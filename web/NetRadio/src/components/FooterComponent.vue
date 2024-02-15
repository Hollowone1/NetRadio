<template>
  <footer>
    <div class="ftl1">
      <router-link to="/"><img class="ft-logo" src="/icons/logo.png" alt="Logo NET RADIO"></router-link>
      <div class="ft-boutons">
        <input class="search" type="search" src="../../public/icons/search.svg" placeholder="Search for...">
      </div>
    </div>
    <div class="bordure"></div>
    <div class="copyrights">copyrights @ idk</div>
  </footer>
</template>


<script>

</script>


<style scoped lang="scss">

@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";
@import "@/assets/listeEmissionsPodcasts";


.bordure {
  margin: 1em;
  border-bottom: 1px solid #D9D9D9;
}

.copyrights {
  margin: 1em;
  color: #D9D9D9;
}

.ft-boutons {
  display: flex;

  .search {

    border-color: transparent;
    border-bottom-color: #dcdcdc;
    border-right-color: #dcdcdc;
    border-radius: 5px;
    width: auto;
    padding: 0.5em;
    font-size: 1em;
    margin: .5em 0em .5em 0em;

  }
}

.ft-logo {
  margin-left: 20px;
  border-radius: 5px;
  height: 50px;
  width: auto;
}

footer {
  background-color: $lightBlack;
  padding: 1em 0;

  .copyright {
    text-align: center;
    & a {
      color: $lightGrey;
    }
  }
}

.ftl1 {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1%;
}

</style>