
require('./autoload');


window[window.appName].mount( 
   window[window.appName],
   function( res, app ) {
      document.body.querySelector('div[id="loading"]').innerHTML = '';
      setTimeout(function() {
         app.app.$mount( window.appName );
      }, 50);
   },
   function( error, app ) {
      console.error( error );
   }
);