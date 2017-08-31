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
                           <input v-model="email" name="email" type="email" class="form-control" aria-rules="required|email" autofocus>   
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                           <input v-model="password" name="password" type="password" class="form-control"  aria-rules="required">
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="password_confirmation" class="col-md-4 control-label">Confirm Password</label>
                        <div class="col-md-6">
                           <input v-model="password_confirmation" name="password_confirmation" type="password" class="form-control"  aria-rules="same:password">
                        </div>
                     </div>

                     <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                           <button @click.prevent="submit" type="button" class="btn btn-primary">
                              Reset Password
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
   var name_component = 'reset';
   export default Vue.component(name_component, { template: '<'+name_component+'></'+name_component+'>',
      data() {
         return {
            status: null,
            status_error: null,
            token: this.$route.params.token,

            email: '',
            password: '',
            password_confirmation: '',
         }
      },
      mounted() {
         this.$root.validatorRegister( 'form' );
         
         this.$root.ajax('/password/reset/authenticate', {token: this.$route.params.token},
            function Then( res, app ) {
               this.email = res.data.email;
            }.bind(this),
            function Catch( error, app ) {
               this.status_error = error.data.status_error;
               app.error_handdle( error );
            }.bind(this)
         );
      },
      methods: {
         submit() {
            this.$root.ajax('/password/reset', this.$data,
               function Then( res, app ) {
                  this.$router.push('/monitor');
                  this.status = res.data.status;
               }.bind(this),
               function Catch( error, app ) {
                  app.error_handdle( error );
               }.bind(this)
            );
         }
      }
   });
</script>
