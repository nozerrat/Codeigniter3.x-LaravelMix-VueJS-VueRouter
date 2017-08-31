<template>
   <div class="container">
      <h3> Adquisición </h3>

      <div class="title m-b-md">
         Adquisición
      </div>
   </div>
</template>
<script>
   var name_component = 'adquisicion';
   export default Vue.component(name_component, { template: '<'+name_component+'></'+name_component+'>',
      data() {
         return {
            config: this.$root.options,
         }
      },
   });
</script>
