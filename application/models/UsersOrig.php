<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model {

   public $error;

   public function __construct() {
      parent::__construct( );
   }

   function consultar_uno( array $where ) {
      $result = $this->consultar( $where );
      return @$result[0] ?: [];
   }

   function consultar( array $where = [] ) {
      $wdatos = [];

      if (@$where['id'])            $wdatos['id']            = $where['id']; 
      // if (@$where['idcontratante']) $wdatos['idcontratante'] = $where['idcontratante'];
      if (@$where['name'])          $wdatos['name']          = $where['name'];
      if (@$where['email'])         $wdatos['email']         = $where['email'];
      if (@$where['password'])      $wdatos['password']      = $where['password'];
      // if (@$where['activo'])        $wdatos['activo']        = $where['activo'];

      $result = $this->db
         ->select( '*' )
         ->from( 'users' )
         ->where( $wdatos )
         ->get()
         ->result_array();
      // echo $this->db->last_query() . '<br><br>';

      $this->error = $this->db->error();

      return $result ?: [];
   }


   function insertar( array $args ) {
      $datos = [];

      // if (@$args['idcontratante']) $datos['idcontratante'] = $args['idcontratante'];
      if (@$args['name'])          $datos['name']          = $args['name'];
      if (@$args['email'])         $datos['email']         = $args['email'];
      if (@$args['password'])      $datos['password']      = $args['password'];
      // if (@$args['activo'])        $datos['activo']        = $args['activo'];

      if (!count($datos)) return false;

      $result = $this->db->insert('users', $datos);
      // echo $this->db->last_query() . '<br><br>';

      $this->error = $this->db->error();

      return $this->db->insert_id() ?: $result;
   }


   function actualizar( array $args, array $where ) {
      $datos   = [];
      $wdatos  = [];

      if (@$args['id'])            $datos['id']            = $args['id']; 
      // if (@$args['idcontratante']) $datos['idcontratante'] = $args['idcontratante'];
      if (@$args['name'])          $datos['name']          = $args['name'];
      if (@$args['email'])         $datos['email']         = $args['email'];
      if (@$args['password'])      $datos['password']      = $args['password'];
      // if (@$args['activo'])        $datos['activo']        = $args['activo'];
      if (@$args['password_reset'])$datos['password_reset']= $args['password_reset'];
      
      if (@$where['id'])           $wdatos['id']           = $where['id'];
      if (@$where['email'])        $wdatos['email']        = $where['email'];

      if (!count($datos) || !count($wdatos)) return false;

      $result = $this->db->update('users', $datos, $wdatos);
      // echo $this->db->last_query() . '<br><br>';

      $this->error = $this->db->error();

      return !!$result;
   }

   function borrar( array $where ) {
      $wdatos = [];

      if (@$where['id'])            $wdatos['id']             = $where['id'];
      // if (@$where['idcontratante']) $wdatos['idcontratante']  = $where['idcontratante'];
      if (@$where['name'])          $wdatos['name']           = $where['name'];
      if (@$where['email'])         $wdatos['email']          = $where['email'];
      if (@$where['password'])      $wdatos['password']       = $where['password'];
      // if (@$where['activo'])        $wdatos['activo']         = $where['activo'];

      if (!count($wdatos)) return false;

      $result = $this->db->delete('users', $wdatos);
      // echo $this->db->last_query() . '<br><br>';

      $this->error = $this->db->error();

      return !!$result;
   }

}