<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Daniia\Daniia;
use Daniia\BaseDaniia;

class Users extends BaseDaniia {
   protected $primaryKey = "id";
   public $error;

   public function __construct() {
      // $CI =& get_instance();
      // $CI->load->helper('array');
   }

   function consultar_uno( array $where = [] ) {
      $this->consultar( $where );
      $result = $this->getData();
      return @$result[0] ?: [];
   }

   function consultar( array $where = [] ) {
      $wdatos = [];
      if (@$where['id'])            $wdatos['id']            = $where['id']; 
      if (@$where['idcontratante']) $wdatos['idcontratante'] = $where['idcontratante'];
      if (@$where['name'])          $wdatos['name']          = $where['name'];
      if (@$where['email'])         $wdatos['email']         = $where['email'];
      if (@$where['password'])      $wdatos['password']      = $where['password'];
      if (@$where['activo'])        $wdatos['activo']        = $where['activo'];

      $this
      // ->table('contratante') // inner join implicito
      // ->where('contratante.idcontratante','users.idcontratante',FALSE)
      ->where( $wdatos )
      ->getArray();
      
      return $this->getData() ?: [];
   }


   function insertar( array $datos ) {
      if (!count($datos)) return FALSE;

      $res = $this->insertGetId($datos);

      return $this->lastId() ?: !!$res;
   }


   function actualizar( array $datos ) {
      $datos['id'] = @$datos['id'] ?: FALSE;

      if ( !count($datos) ) return FALSE;
      
      $res = $this
      // ->where('users.idcontratante','001')
      ->update( $datos );

      return !!$res;
   }

   function borrar( array $where ) {
      $wdatos = [];
      if (@$where['id'])    $wdatos['id']    = $where['id'];
      if (@$where['email']) $wdatos['email'] = $where['email'];

      if (!count($wdatos)) return FALSE;

      $res = $this->delete( $wdatos );

      return !!$res;
   }

}

