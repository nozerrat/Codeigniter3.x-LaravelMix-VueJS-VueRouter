<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('response')) {

   function response( array $data = [], $status = 200 ) {
      $CI =& get_instance();

      $auth = $CI->session->userdata('auth');

      $auth['token']      = $CI->security->get_csrf_hash();
      $auth['token_name'] = $CI->security->get_csrf_token_name();

      $CI->session->set_userdata( [ 'auth' => $auth ] );

      $data['auth'] = $auth;

      set_status_header( $status );
      echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
   }
}