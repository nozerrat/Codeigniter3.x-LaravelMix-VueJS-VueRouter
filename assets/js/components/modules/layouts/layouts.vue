<template>
   <div>
      <nav class="navbar navbar-default navbar-static-top" style="margin-bottom: -1px;">
         <div class="container">
            <div class="navbar-header">

               <!-- Collapsed Hamburger -->
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                  <span class="sr-only">Toggle Navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
               </button>

               <!-- Branding Image -->
               <a class="navbar-brand " href="/">
                  {{ config.appTitle }}
               </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
               <!-- not Authentication Links -->
               <!-- Left Side Of Navbar -->
               <ul v-if="config.noAuth" class="nav navbar-nav navbar-right links">
                  <li>
                     <a-link to="/login">Login</a-link>
                  </li>
                  <li>
                     <a-link to="/register">Register</a-link>
                  </li>
               </ul>

               <!-- Authentication Links -->
               <!-- Right Side Of Navbar -->
               <ul v-if="config.isAuth" class="nav navbar-nav navbar-right links">
                  <li>
                     <a-link to="/monitor">Monitor</a-link>
                  </li>
                  <li>
                     <a-link to="/reporte">Reporte</a-link>
                  </li>
                  <li>
                     <a-link to="/adquisicion">Adquisición</a-link>
                  </li>
                  <li>
                     <a-link to="/configuracion">Configuración</a-link>
                  </li>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ config.userName }} <span class="caret"></span>
                     </a>
                     <ul class="dropdown-menu" role="menu">
                        <li>
                           <a-link to="/app">App</a-link>
                        </li>
                        <li>
                           <a-link to="/home">Home</a-link>
                        </li>
                        <li>
                           <a-link to="/perfil">Perfil</a-link>
                        </li>
                        <li>
                           <a href="javascript:;" @click="logout">
                              Logout
                           </a>
                        </li>
                     </ul>
                  </li>
               </ul>
               
            </div>
         </div>
      </nav>

      <!-- view -->
      <router-view></router-view>
      
      <!-- loading -->
      <loading :status="config.loading"></loading>

   </div>
</template>

<script>
   var name_component = 'layouts';
   export default Vue.component(name_component, { template: '<'+name_component+'></'+name_component+'>',
      data() {
         return {
            config: this.$root.options,
         }
      },
      methods: {
         logout() {
            this.$root.ajax('/logout',
               function Then( res, app ) {
                  this.$router.push('/login');
               }.bind(this),
               function Catch( error, app ) {
                  console.log( app.appName, error );
               }.bind(this)
            );

         },
      },
   });
</script>
