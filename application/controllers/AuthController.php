<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Validator\Validator;

class AuthController extends CI_Controller {

   public $auth = [];
   private $validator;


   public function __construct() {
      parent::__construct();

      // Valores predeterminado para autenticar la sesion del usuario
      $this->auth['auth']['auth']       = new stdClass();
      $this->auth['auth']['isAuth']     = FALSE;
      $this->auth['auth']['noAuth']     = TRUE;

      // Validamos que existe valor en el Session
      $auth = $this->session->userdata('auth');
      if ( !@$auth['auth'] ) {
         $this->session->set_userdata( $this->auth );
      }

      // Instancia de objetos
      $this->load->model('users');
      $this->load->helper('array');
      $this->load->library('encryption',NULL,'encrypt');

      $this->validator = (new Validator)
      ->create([
         'existeCorreo'=>['No podemos encontrar el usuario con esa dirección de correo electrónico.', function( $value, $param, $data, $validator ) {
            $result = $this->users->consultar_uno( ['email'=>$value] );
            return count($result) > 0;
         }],
         'compararPass'=>['La clave que ingresó es incorrecta.', function( $value, $param, $data, $validator ) {
            $result = $this->users->consultar_uno( ['email'=>$data['email']] );
            if ( ($error = $this->encrypt->decrypt(@$result['password'])===$value)===FALSE ) {
               $validator->set( 'email', $validator->roles_created['existeCorreo'][0] );
            }
            return $error;
         }],
         'authenticateToken'=>['No existe ninguna autorización para cambiar el password.', function( $value, $param, $data, $validator ) {
            $result = $this->users->consultar_uno( ['email'=>$value] );
            
            return @$result['password_reset']==='false' || @$result['email']!==$this->authenticateToken(true);
         }],
      ]);
   }


   function index() {
      $this->load->view('welcome');
   }


   function auth() {
      if ( !$this->input->is_ajax_request() || $this->input->method()!=='post' ) return show_404();
      response( );
   }


   function login() {
      if ( !$this->input->is_ajax_request() || $this->input->method()!=='post' ) return show_404();

      $input  = $this->input->post();

      $result = $this->users->consultar_uno( elements(['email'], $input) );
      
      $this->validator
      ->make($input,[
         'email'=>'required|email|existeCorreo',
         'password'=>'required|min:6|compararPass',
      ]);

      if ($this->validator->fails() === TRUE) {
         response( ['error'=>$this->validator->messages( )], 401 );
      }
      else {
         // iniciamos sesion
         $auth['auth']['auth']   = elements(['id', 'idcontratante', 'email', 'name'], $result);
         $auth['auth']['isAuth'] = !!count($result);
         $auth['auth']['noAuth'] =  !count($result);

         $this->session->set_userdata( $auth );
         
         response( );
      }
   }


   function logout() {
      if ( !$this->input->is_ajax_request() || $this->input->method()!=='post' ) return show_404();

      $this->session->sess_destroy();
      $this->session->set_userdata( $this->auth );
      response( );
   }


   function sendResetLinkEmail() {
      if ( !$this->input->is_ajax_request() || $this->input->method()!=='post' ) return show_404();
      
      $input = $this->input->post();

      $this->validator
      ->make($input,[
         'email'=>'required|email|existeCorreo',
         'password'=>'required|min:6',
      ]);
      
      $result = $this->users->consultar_uno(elements(['email'], $input));

      if ($this->validator->fails() === TRUE) {
         response( ['error'=>$this->validator->messages()], 401 );
      }
      else {
         $token = $this->encrypt->encrypt( $input['email'] );
         $token = str_replace(['/','+'], ['-',':'], $token);
         $args = ['email'=>$input['email'], 'token'=>$token];

         $this->sendEmail($args, function($status) use($result,$token) {
            if ($status) {
               $this->users->actualizar(['password_reset'=>$token], $result);
               response( ['status'=>'Se le ha enviado un link a su correo para resetear su password'] );
            } else {
               response( ['status_error'=>'Se produjo un error al enviar el correo. Intente luego.'] );
            }
         });
      }
   }


   public function authenticateToken( bool $returnTokenEmail = false ) {
      if ( !$this->input->is_ajax_request() || $this->input->method()!=='post' ) return show_404();

      $input = $this->input->post();

      $token = str_replace(['-',':'],['/','+'], $input['token']);
      $email = $this->encrypt->decrypt( $token );

      if ( $returnTokenEmail ) {
         return $email;
      } else {
         $result = $this->users->consultar_uno(['email'=>$email,'password_reset'=>$input['token']]);
         if ( count($result)===0 || @$result['password_reset']==='false' || $email===FALSE ) {
            response( ['status_error'=>'No existe ninguna autorización para cambiar el password.'], 403 );
         }
         else {
            response( ['email'=>$email] );
         }
      }
   }


   public function passwordReset() {
      if ( !$this->input->is_ajax_request() || $this->input->method()!=='post' ) return show_404();

      $input = $this->input->post();

      $this->validator->make($input,[
         'email'=>'required|email|existeCorreo',
      ]);

      $result = $this->users->consultar_uno(elements(['email'], $input));

      if ($this->validator->fails()===TRUE) {
         response( ['error'=>$this->validator->messages()], 401 );
      }
      else {
         // Encriptamos el password
         $input['password'] = $this->encrypt->encrypt( $input['password'] );
         $input['password_reset'] = 'false';
         $this->users->actualizar($input, $result);

         // iniciar sesion
         $auth['auth']['auth']   = elements(array('id', 'idcontratante', 'email', 'name'), $result);
         $auth['auth']['isAuth'] = !!count($result);
         $auth['auth']['noAuth'] =  !count($result);

         $this->session->set_userdata( $auth );

         response( ['status'=>'Ya fue creado Satisfactoriamente'] );
      }
   }

   
   public function sendEmail( array $args, Closure $callback ) {
      if ( !$this->input->is_ajax_request() || $this->input->method()!=='post' ) return show_404();
      $this->load->library('email');

      $this->email->clear();

      $this->email->from($args['email'], 'Your Name');
      $this->email->to($args['email']);
      // $this->email->cc('another@another-example.com');
      // $this->email->bcc('them@their-example.com');

      $this->email->subject('Email de Prueba');
      $this->email->message('<a href="'.base_url().'password/reset/'.$args['token'].'">Resetear</a>');

      $callback( $this->email->send( ) );

   }
}
