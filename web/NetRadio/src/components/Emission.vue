<script>

export default {
  emits: ['edit'],
  props: {
    emission: {
      type: Object,
      required: true
    },
    edit: {
      type: Boolean,
      required: false,
      default: false
    },
    redirect: {
      type: Boolean,
      required: false,
      default: true
    }
  },
  methods: {
    redirectToPage(id) {
      this.redirect ? this.$router.push(`/emissions/${id}`) : null;
    }
  },
  directives: {
    image: {
      mounted(el, binding) {
        el.style.background = `linear-gradient(transparent, black), url('${binding.value}')`;
        el.style.transition = 'background 0.5s ease';
        el.style.backgroundSize = 'cover';

        el.addEventListener('mouseenter', function () {
          el.style.background = `linear-gradient(rgba(0,0,0,0.25), black), url('${binding.value}')`;
          el.style.backgroundSize = 'cover';
        });

        el.addEventListener('mouseleave', function () {
          el.style.background = `linear-gradient(transparent, black), url('${binding.value}')`;
          el.style.backgroundSize = 'cover';

        });
      }
    }
  }


};
</script>

<template>
  <section @click="redirectToPage(emission.id)" v-image="emission.photo" class="emission">
    <img v-if="edit" @click="$emit('edit')" src="/icons/edit.svg" alt="edit">
    <div v-if="!edit"></div>
    <div>
      <p>{{ emission.titre }}</p>
      <p>{{ emission.user }}</p>
    </div>
  </section>
</template>

<style scoped lang="scss">


</style>