<template>
   <div class="container">
      <h3> Reporte </h3>

      <div class="title m-b-md">
         Reporte
      </div>
   </div>
</template>
<script>
   var name_component = 'reporte';
   export default Vue.component(name_component, { template: '<'+name_component+'></'+name_component+'>',
      data() {
         return {
            config: this.$root.options,
         }
      },
   });
</script>
