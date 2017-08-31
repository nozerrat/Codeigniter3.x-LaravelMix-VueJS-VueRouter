<template>
   <div class="container" style="margin-top: 50px;">
      <div class="row">
         <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
               <div class="panel-heading">Register</div>
               <div class="panel-body">
                  <div v-if="status || error_db" class="alert" :class="{'alert-success': status, 'alert-danger': error_db}">
                     {{ status }}
                     <span v-if="error_db">
                        Code: <b>{{ error_db.code }}</b><br>
                        Message: <b>{{ error_db.message }}</b><br>
                     </span>
                  </div>
                  <form class="form-horizontal" name="form">
                     <div class="form-group">
                        <label class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                           <input v-model="name" name="name" class="form-control" aria-rules="required" autofocus>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-md-4 control-label">E-Mail Address</label>
                        <div class="col-md-6">
                           <input v-model="email" name="email" type="email" class="form-control" aria-rules="required|email">
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                           <input v-model="password" name="password" type="password" class="form-control" aria-rules="required">
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="col-md-4 control-label">Confirm Password</label>
                        <div class="col-md-6">
                           <input v-model="password_confirmation" name="password_confirmation" type="password" class="form-control" aria-rules="same:password">
                        </div>
                     </div>

                     <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                           <button @click.prevent="submit" type="submit" class="btn btn-primary">
                              Register
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
   var name_component = 'register';
   export default Vue.component(name_component, { template: '<'+name_component+'></'+name_component+'>',
      data() {
         return {
            status: null,
            error_db: null,
            activo: true,
            idcontratante: null,
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
         }
      },
      mounted() {
         this.$root.validatorRegister( 'form' );
      },
      methods: {
         submit() {
            if ( this.$root.validatorRunSuccess( ) ) {
               this.$root.ajax('/register', this.$data,
                  function Then( res, app ) {
                     this.status = res.data.status;
                     this.error_db = null;
                     this.$router.push('/monitor');
                  }.bind(this),
                  function Catch( error, app ) {
                     this.status = null;
                     this.error_db = error.data.error_db;
                     app.error_handdle( error );
                  }.bind(this)
               );
            }
         },      
      }
   });
</script>
