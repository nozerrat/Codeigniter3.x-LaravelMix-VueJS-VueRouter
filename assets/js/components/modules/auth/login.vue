<template>
   <div class="container" style="margin-top: 50px;">
      <div class="row">
         <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
               <div class="panel-heading">Login</div>
               <div class="panel-body">
                  <form class="form-horizontal" name="form">
                     <div class="form-group">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                        <div class="col-md-6">
                           <input v-model="email" name="email" type="email" class="form-control"  aria-rules="required|email" autofocus>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                           <input v-model="password" name="password" type="password" class="form-control" aria-rules="required|min:6">
                        </div>
                     </div>

                     <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                           <div class="checkbox">
                              <label>
                                 <input v-model="remember" name="remember" type="checkbox" > Remember Me
                              </label>
                           </div>
                        </div>
                     </div>

                     <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                           <button @click.prevent="submit" class="btn btn-primary">
                              Login
                           </button>

                           <a-link to="/password/reset">
                              Forgot Your Password?
                           </a-link>
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
   var name_component = 'login';
   export default Vue.component(name_component, { template: '<'+name_component+'></'+name_component+'>',
      data() {
         return {
            _token: this.$root.options._token,
            email: null,
            password: null,
            remember: null,
         }
      },
      mounted() {
         this.$root.validatorRegister( 'form' );
      },
      methods: {
         submit() {
            if ( this.$root.validatorRunSuccess( ) ) {
               this.$root.ajax('/login', this.$data,
                  function Then( res, app ) {
                     this.$router.push('/monitor');
                  }.bind(this),
                  function Catch( error, app ) {
                     app.error_handdle( error );
                  }.bind(this)
               );
            }
         }
      }
   });
</script>

