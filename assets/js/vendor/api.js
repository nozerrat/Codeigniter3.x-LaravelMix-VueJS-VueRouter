window.Vue = require('vue');
window.Vue.use( window.VueRouter = require('vue-router').default );



// Se obtiene el valor CSRF
window.token = document.head.querySelector('meta[name="csrf-token"]').content;

// Se obtiene el valor CSRF
window.token_name = document.head.querySelector('meta[name="csrf-token-name"]').content;

// Base URL
window.base_url = document.head.querySelector('base[href]').href;

// Title
window.appTitle = document.head.querySelector('title').innerHTML;

// Se asigna el nombre de la aplicación
document.writeln('<div id="z'+window.token+'"><layouts></layouts></div>')

// Nombre de la aplicación para arrancar VueJS
window.appName = '#z'+window.token;



/**
 * Configuración de la aplicación
 */
window[window.appName]           = {};
window[window.appName].app       = null;
window[window.appName].appName   = window.appName;

window[window.appName].options   = {};
window[window.appName].options.auth       = {};
window[window.appName].options.isAuth     = false;
window[window.appName].options.noAuth     = true;
window[window.appName].options.userName   = '';

window[window.appName].options.appTitle   = window.appTitle;

window[window.appName].options.token      = window.token;
window[window.appName].options.token_name = window.token_name;









window[window.appName].config = function( options, callback ) {
   if (typeof options!=='function' && options) {
      window[window.appName].options.auth       = options.auth || {};
      window[window.appName].options.isAuth     = options.isAuth;
      window[window.appName].options.noAuth     = options.noAuth;
      window[window.appName].options.userName   = options.auth.name;

      window[window.appName].options.token      = window.token      = options.token;
      window[window.appName].options.token_name = window.token_name = options.token_name;
   }
   else {
      callback = options;
   }

   if ( typeof callback==='function' ) {
      callback( window[window.appName] );
   }

   return window[window.appName];
};
window[window.appName].config();



/**
 * [ajax]
 * @param  {String}   url           [URL a solicitar]
 * @param  {Object}   data          [Datos a enviar]
 * @param  {Function} callbackThen  [Callback cuando la solicitud es exitosa]
 * @param  {Function} callbackCatch [Callback cuando la solicitud es erronea]
 * @return {App}                    [Retorna la aplicacion]
 *
 * Uso:
 *    
   app.ajax('/auth', [{key:value,...},]
      function Then( res, app ) {
         console.log( app.appName, res.data );
      },
      function Catch( error, app ) {
         console.log( app.appName, error );
      }
   );
 */
window[window.appName].ajax = function ( url, data, callbackThen, callbackCatch) {

   if ( typeof url!=='string' ) {
      return console.error( 'La URL es requerido...' );
   }

   if ( typeof data==='function' ) {
      callbackCatch = callbackThen;
      callbackThen  = data;
      data = {};
   }

   data[window.token_name] = window.token;

   url = url.substr(0,1).match(/\//) ? url.substr(1) : url;

   window[window.appName].options.loading = true;

   setTimeout(function() {
      window.jQuery.post( window.base_url + url, data, null, 'json' )
      .done(function( data, textStatus, jqXHR ) {
         jqXHR.data = jqXHR.responseJSON;
         
         window[window.appName].config( jqXHR.data.auth, function( app ) {
            window[window.appName].options.loading = false;
            if ( typeof callbackThen==='function' ) {
               callbackThen( jqXHR, app );
            }
         });
      })
      .fail(function( jqXHR, textStatus, errorThrown ) {
         jqXHR.data = jqXHR.responseJSON;
         window[window.appName].config( jqXHR.data.auth, function( app ) {
            if ( jqXHR.status < 500 ) {
               window[window.appName].options.loading = false;
            }
            if ( typeof callbackCatch==='function' ) {
               callbackCatch( jqXHR, window[window.appName] );
            }
            else {
               console.error( errorThrown );
            }
         });
      });
   });

   return window[window.appName];
}



window[window.appName].authenticate = function( callbackThen, callbackCatch ) {
   window[window.appName].options.loading = true;
   
   var token_data = {};
   token_data[window.token_name] = window.token;

   setTimeout(function() {
      window.jQuery.post( window.base_url + 'auth', token_data, null, 'json' )
      .done(function( data, textStatus, jqXHR ) {
         jqXHR.data = jqXHR.responseJSON;
         window[window.appName].config( jqXHR.data.auth, function( app ) {
            window[window.appName].options.loading = false;
            if ( typeof callbackThen==='function' ) {
               callbackThen( jqXHR, app );
            }
         });
      })
      .fail(function( jqXHR, textStatus, errorThrown ) {
         jqXHR.data = jqXHR.responseJSON;
         window[window.appName].config( jqXHR.data.auth, function( app ) {
            if ( jqXHR.status < 500 ) {
               window[window.appName].options.loading = false;
            }
            if ( typeof callbackCatch==='function' ) {
               callbackCatch( jqXHR, window[window.appName] );
            }
            else {
               console.error( errorThrown );
            }
         });
      });
   });

   return window[window.appName];
}



window[window.appName].aLink = function( ) {
   document.body.querySelectorAll('ul[class*="nav"] li[class="active"]').forEach( function(element, index) {
      element.className = '';
   });
   document.body.querySelectorAll('ul[class*="nav"] li[class="dropdown active"]').forEach( function(element, index) {
      element.className = 'dropdown';
   });
   setTimeout(function() {
      try {
         var path = window.location.pathname;
         document.body.querySelector('a[to="'+path+'"]').parentNode.className='active';
         var LI = document.body.querySelector('a[to="'+path+'"]').parentNode.parentNode.parentNode;
         if ( LI.nodeName==="LI" && LI.className==="dropdown" ) {
            LI.className = 'dropdown active';
         }
      } catch(e) {}
   }, 200);
}



window[window.appName].mount = function( app, callbackThen, callbackCatch ) {
   app.authenticate(
      function Then( res, app ) {
         /**
          * Se realiza la instancia de Vue
          */
         app.app = new Vue({
            router: require('../components/routes.vue'),
            data() {
               // Se realiza un bind de la configuración de la aplicación
               return app
            },
         });

         /**
          * Se arranca la Aplicación VueJS
          */
         if ( typeof callbackThen==='function' ) {
            // llamado asincrono
            callbackThen( res, app );
         }
         else {
            // llamado sincrono
            app.app.$mount( window.appName );
         }

         mount_options_validator();
      },
      function Catch( error, app ) {
         if ( typeof callbackCatch==='function' ) {
            callbackCatch( error, app );
         }
         else {
            console.error( error );
         }
      }
   );

   return window[window.appName];
}



//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
/**
   Type: Class
   Scope: Public
   Registramos el nombre del formulario a ser validado
   e.g:
      var app = window[window.appName].register( 'loginForm' );

   return app;
**/
window[window.appName].validatorRegister = function( nameForm ) {
   window.Validator.cleanAll().removeAll().register( nameForm.replace(/ /g,'') );
   return window[window.appName];
};

/**
   Type: Function
   Inicializamos las validaciones de los campos del Formulario registrado
   y chequea que las validaciones sean satisfactorio
   e.g:
      window[window.appName].runSuccess();

   return Boolean;
**/
window[window.appName].validatorRunSuccess = function( ) {
   return window.Validator.run().success;
};


/**
   Type: Function
   Resetea los valores de un formulario
   e.g:
      var app = window[window.appName].resetForm();

   return app;
**/
window[window.appName].validatorResetForm = function( ) {
   window.Validator.resetForm();
   return window[window.appName];
};    

/**
   Type: Function
   Scope: Public
   Inicializamos las validaciones de los campos del Formulario registrado
   y chequea si las validaciones contiene error
   e.g:
      window[window.appName].runError();

   return Boolean;
**/
window[window.appName].validatorRunError = function( ) {
   return window.Validator.run().error;
};

/**
   Type: Function
   Scope: Public
   Emite a la vista los errores registrado.

   e.g:
      var app = window[window.appName].handlerError( response );

   return app;
**/
window[window.appName].error_handdle = function( response ) {
   if ( window.Validator ) {
      for (idx in response.responseJSON) {
         if ( idx==='error' && typeof response.responseJSON[idx]==='object' ) {
            window.Validator.cleanAll().add_error( response.responseJSON[idx] );
         }
      }
   }
   return window[window.appName];
}

/**
   Creamos reglas de validaciones
**/
function mount_options_validator() {
   // window.Validator.options.addClassHelpBlock = 'col-lg-offset-4 col-md-offset-4 col-sm-offset-4';
   window.Validator.create([{
      edad_limite: {
         message: 'Disculpe, su edad debe ser mayor o igual a 17 años',
         fn: function( value, field, rule, param, Validator ) {
            value = value.split('/');
            var dia = value[0]||0, mes = value[1]||0, anio = value[2]||0;
            var hoy = new Date();
            var edad = ( hoy.getFullYear() - parseInt( anio ) ) - 1;
            if( ( hoy.getMonth() + 1 ) >= parseInt( mes ) )
               if( hoy.getDate() >= parseInt( dia ) ) edad += 1;
            return edad >= 17;
         }
      },
      fecha_mayor_al_actual: {
         message: 'La fecha debe ser menor o igual que la fecha actual',
         fn: function( value, field, rule, param, Validator ) {
            value = value.split('/');
            var dia = value[0]||0, mes = value[1]||0, anio = value[2]||0;
            var hoy = new Date();
            var result = true;
            if ( hoy.getFullYear() < parseInt( anio ) ) result = false;
            if ( hoy.getFullYear() == parseInt( anio ) ) {
               if ( ( hoy.getMonth() + 1 ) < parseInt( mes ) ) result = false;
               if ( ( hoy.getMonth() + 1 ) == parseInt( mes ) )
                  if ( hoy.getDate() < parseInt( dia ) ) result = false;
            }
            return result;
         }
      },
      telf_format: {
         message: 'Formato incorrecto: Ej: 0212-12345678',
         fn: function( value, field, rule, param, Validator ) {
            return value.match(/^[0-9]{1,4}[- ]?[0-9]{1,12}$/);
         }
      },
      tipo_documento:{
         message: 'El formato de documento es incorrecto. Ingrese J0000000 o V000000000, hasta 10 dígitos, sin guiones ni espacios',
         fn: function( value, field, rule, param, Validator ) {
            return value.match(/^[VEJG][0-9]{1,10}$/);
         }
      },

      /**
         Solo registramos los mensajes para las reglas sin eventos
         esto son ejecutado por:
         e.g 1:
            Validator.add_error( 'field', 'Mensaje de error' );

         e.g 2:
            Validator.add_error( { field: 'Mensaje de error' } );

         e.g 3:
            Validator.add_error( { field: ['Mensaje de error'] } );
      **/
      cliente_exists: {
         message: 'El Cliente ya fue registrado',
      },
      contratante_exists: {
         message: 'El Contratante ya fue registrado',
      },
      user_exists: {
         message: 'Lo sientimos, usted aun no esta registrado al sistema',
      },
      password_wrong: {
         message: 'El <b>Usuario</b> o <b>Password</b> son incorrectos',
      },
      maxLength: {
         message: 'Demasiado largo',
      },
      username23505: { // código lanzado por Postgres que indica que una Primary Key esta repetida
         message: 'El <b>Email</b> que ingresó ya existe',
      },
      invalid_authorize: { // Indica si el email o passworod es incorrecto
         message: 'El valor <b>Email</b> o <b>Password</b> son invalidos',
      },
      unique: { // Indica si el email o passworod es incorrecto
         // message: 'A record with that `username` already exists (`garlos@gmail.com`).',
         message: 'El valor <b>:value</b> ya esta registrado.',
      },
   }]);
}
