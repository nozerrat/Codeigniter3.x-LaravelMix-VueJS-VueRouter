<template>
   <div>
      <h3 class="container"> Monitor </h3>

      <div style="clear:both">
         <div :style="style" class="hidden-xs col-sm-2 col-md-2 col-lg-2">
            &nbsp;
         </div>
         <div :style="style+';padding:0;'" class="rg hidden-xs col-sm-4 col-md-4 col-lg-4">
            <div>
               <canvas id="rg-linea" :width="width" :height="height">[No canvas support]</canvas>
            </div>
         </div>
         <div :style="style" class="col-xs-3  col-sm-1 col-md-1 col-lg-1">
            &nbsp;
         </div>
         <div :style="style" class="col-xs-3  col-sm-1 col-md-1 col-lg-1">
            &nbsp;
         </div>
         <div :style="style+';padding:0;'" class="rg col-xs-6 col-sm-4 col-md-4 col-lg-4">
            <div>
               <canvas id="rg-bar" :width="width" :height="height">[No canvas support]</canvas>
            </div>
         </div>
      </div>
   </div>
</template>
<script>
   var name_component = 'monitor';
   export default Vue.component(name_component, { template: '<'+name_component+'></'+name_component+'>',
      data() {
         return {
            config: this.$root.options,
            height: 120,
            width: 250,
            style: '',
         }
      },
      mounted() {
         this.style= 'height:'+(this.height-20)+'px;background-color:#ccc;border:1px solid #eee;';

         new RGraph.Line({
             id: 'rg-linea',
             data: [84,76,79,84,100,52,53],
             options: {
                 ymax:100,
                 textSize: 8,
                 textAccessible: false,
                 hmargin: 5,
                 tickmarks: 'endcircle',
                 labels: ['Gary','Hoolio','Brad','Olga','Pete','Luis','John'],
             }
         }).draw();

         new RGraph.Bar({
             id: 'rg-bar',
             data: [84,76,79,84,100,52,53],
             options: {
                 // textColor: '#333',
                 ymax:100,
                 textSize: 8,
                 linewidth: 1,
                 backgroundColor: 'yellow',
                 colors: ['Gradient(#0c7:#b8f701:#ecd30c:#de5705:red)'],
                 strokestyle: 'red',
                 textAccessible: false,
                 // title: 'A basic chart',
                 labels: ['Gary','Hoolio','Brad','Olga','Pete','Luis','John'],
             }
         }).draw();

      },
   });
</script>

<style>
   .rg > div {
      top: -15px;
      position: relative;
   }
</style>