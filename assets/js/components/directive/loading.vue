<template>
   <div v-if="status">
      <div style="overflow: hidden; width:100%; height:100%; z-index:1000; position:fixed; top:0; left:0;">
         <div style="overflow: hidden; width:100%; height:100%; z-index:1; position:fixed; top:0; left:0; background-color:black; opacity:0.1;"></div>
         <div style="z-index:1100;text-align:center;font-size:75px;color:#737272;top:50px;margin-top: 120px;;">
            <h1>Cargando</h1>
            <i class="fa fa-spinner fa-pulse"></i>
         </div>
      </div>
   </div>
</template>

<script>
   export default Vue.component('loading', {
  		// template: '<loading></loading>',
      props: ['status'],
      propsData: {
         status: false,
      },
      data() {
         return {
            config: window[window.appName].options,
         }
      },
   });
</script>
