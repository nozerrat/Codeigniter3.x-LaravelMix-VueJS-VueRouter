<template>
   <div class="container">
      <h3> Configuración </h3>

      <div class="title m-b-md">
         Configuración
      </div>
   </div>
</template>
<script>
   var name_component = 'configuracion';
   export default Vue.component(name_component, { template: '<'+name_component+'></'+name_component+'>',
      data() {
         return {
            config: this.$root.options,
         }
      },
   });
</script>
