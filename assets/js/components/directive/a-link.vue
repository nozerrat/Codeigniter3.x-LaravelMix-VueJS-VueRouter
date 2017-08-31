<template>
   <a href="javascript:;" :to="to" @click.prevent="link" :class="className">
      <slot></slot>
   </a>
</template>

<script>
   export default Vue.component('a-link', {
      props:['to','fn','className'],
      data() {
         return {
            config: this.$root.options,
         }
      },
      methods: {
         link() {
            if ( typeof this.fn==='function' ) {
               this.fn( this );
            }
            if ( this.to ) {
               this.$router.push( this.to );
            }
         },
      }
   });
</script>
