<template>
    <div class="calendrier">
      <VCalendar :columns="columns" @dayclick="onDayClick"/> <!--@dayclick="onDayClick"-->
    </div>
  </template>
  
  <script setup>
  import { useScreens } from 'vue-screen-utils';
  import { ref } from 'vue'

  
  const { mapCurrent } = useScreens({ xs: '0px', sm: '640px', md: '768px', lg: '1024px' });
  const columns = mapCurrent({ lg: 2 }, 1);
  const selectedDate = ref(null)

  
  const onDayClick = (date) => {
    selectedDate.value = date
    emit('dayclick', selectedDate.value)

  };

  const emit = defineEmits(['dayclick'])

  </script>

<style scoped>

.calendrier{
    padding: 30px;
     text-align: center;
}
.vc-container{
    background-color: #3b3d3f;
}
@media screen and (max-width: 550px) {
    .calendar{
        margin-left: 50%;
    }
}

</style>