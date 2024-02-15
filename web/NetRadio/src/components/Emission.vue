
<script>

export default {
  emits: ['edit'],
  props: {
    emission: {
      type: Object,
      required: true
    },
    edit : {
      type : Boolean,
      required : false,
      default : false
    }
  },
  data() {
    return {

    }
  },
  directives : {
    image : {
      mounted(el, binding) {
        el.style.background =  `linear-gradient(transparent,black), url('${binding.value}')`;
        //el.style.background = `url('${binding.value}')`;
      }
    }
  }

};
</script>

<template>
  <section v-image="emission.photo" class="emission">
    <img v-if="edit" @click="$emit('edit')" src="/icons/edit.svg" alt="edit">
    <div>
      <p>{{ emission.titre }}</p>
      <p>{{ emission.user }}</p>
    </div>
  </section>
</template>

<style scoped lang="scss">

@import "@/assets/var";
@import "@/assets/layout";
@import "@/assets/fonts";
@import "@/assets/buttons";
@import "@/assets/listeEmissionsPodcasts";


</style>