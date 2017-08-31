<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Validator\Validator;

class UsersController extends CI_Controller {

   public $auth = [];
   private $validator;

   public function __construct() {
      parent::__construct();
      if ( !$this->input->is_ajax_request() || $this->input->method()!=='post' ) return show_404();
      
      $this->load->model('users');
      $this->load->helper('array');
      $this->load->library('encryption',NULL,'encrypt');

      $this->validator = (new Validator)
      ->create([
         'noExisteCorreo'=>['El Correo que ingresó ya existe.', function( $value, $param, $data, $validator ) {
            $result = $this->users->consultar_uno( ['email'=>$value] );
            return count($result)===0;
         }],
      ]);
   }
  
   function register() {
      $input = $this->input->post();

      $this->validator->make($input,[
         'email'=>'required|email|noExisteCorreo',
         'name'=>'required',
         'password'=>'required|min:6',
         'password_confirmation'=>'same:password',
      ]);

      if ($this->validator->fails() === TRUE) {
         response( ['error'=>$this->validator->messages()], 401 );
      }
      else {
         // Encriptamos el password
         $input['password'] = $this->encrypt->encrypt( $input['password'] );

         // Insertamos los datos
         $last_id  = $this->users->insertar( $input /*['name'=>'name']*/ );
         $error_db = $this->users->error();

         if ( $error_db['message'] ) {
            response( ['error_db'=>$error_db], 403 );
         }
         else {
            // consultamos para iniciar sesion
            $result  = $this->users->consultar_uno([ 'id' => $last_id ]);
            
            $auth['auth']['auth']   = elements(array('id', 'idcontratante', 'email', 'name'), $result);
            $auth['auth']['isAuth'] = !!count($result);
            $auth['auth']['noAuth'] =  !count($result);

            $this->session->set_userdata( $auth );

            response( ['status'=>'Ya fue creado Satisfactoriamente'] );
         }
      }
   }



}
