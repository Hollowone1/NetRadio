
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
  methods : {
    redirect(id) {
      this.$router.push(`/emissions/${id}`)
    }
  },
  directives : {
    image : {
      mounted(el, binding) {
        el.style.background =  `linear-gradient(transparent,black), url('${binding.value}')`;
      }
    }
  }

};
</script>

<template>
  <section @click="redirect(emission.id)" v-image="emission.photo" class="emission">
    <img v-if="edit" @click="$emit('edit')" src="/icons/edit.svg" alt="edit">
    <div v-if="!edit"></div>
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