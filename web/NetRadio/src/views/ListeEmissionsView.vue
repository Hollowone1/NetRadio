<script>
import EnDirect from '@/components/EnDirect.vue'
import Emission from '@/components/Emission.vue'

export default {
  components: {
    EnDirect,
    Emission
  },
  data() {
    return {
      currentEmission: {} 
    }
  }
}
</script>
<template>
  <main>
    <en-direct></en-direct>
    <emission></emission>
    
  </main>
</template>

<style scoped lang="scss">
.emissions {
  padding-top: 1em;
  padding-left: 3em;
  padding-right: 3em;
}
</style>