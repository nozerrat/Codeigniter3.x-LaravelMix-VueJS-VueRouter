<template>
   <div class="container" style="margin-top: 50px;">
      <div class="row">
         <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
               <div class="panel-heading">Reset Password</div>
               <div class="panel-body">
                  <div v-if="status || status_error" class="alert" :class="{'alert-success': status, 'alert-danger': status_error}">
                     {{ status }} {{ status_error }}
                  </div>
                  <form class="form-horizontal" name="form">

                     <div class="form-group">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                        <div class="col-md-6">
                           <input v-model="email" name="email" type="email" class="form-control"  aria-rules="required|email">   
                        </div>
                     </div>

                     <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                           <button @click.prevent="submit" type="button" class="btn btn-primary">
                              Send Password Reset Link
                           </button>
                        </div>
                     </div>
                     
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
   var name_component = 'email';
   export default Vue.component(name_component, { template: '<'+name_component+'></'+name_component+'>',
      data() {
         return {
            status: null,
            status_error: null,
            email: null,
         }
      },
      mounted() {
         this.$root.validatorRegister( 'form' );
      },
      methods: {
         submit() {
            this.$root.ajax('/password/email', this.$data,
               function Then( res, app ) {
                  console.log( res );
                  this.status = res.data.status;
                  this.status_error = null;
               }.bind(this),
               function Catch( error, app ) {
                  this.status = null;
                  this.status_error = error.data.status_error;
                  // console.log( error );
                  app.error_handdle( error );
               }.bind(this)
            );
         }
      }
   });
</script>
