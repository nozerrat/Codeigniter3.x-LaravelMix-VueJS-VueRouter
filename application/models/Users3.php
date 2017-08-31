<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Daniia\Daniia;


class Users3 extends Daniia {
   protected $table      = "users";
   protected $primaryKey = "id";

   public function index() {
      $result = $this
         ->from( 'personas' )
         ->select( )
         ->getArray();
      echo $this->sql . '<br>';
      var_dump( $result );
      
      $result = $this
         ->table('personas')
         ->first();
      echo $this->sql . '<br>';
      var_dump( $result );

      $result = $this
         ->from(function (Daniia $daniia) {
            $daniia->table("personas");
         }, 'AliasForFROM')->first();
      echo $this->sql . '<br>';
      var_dump( $result );

      $result = $this
         ->from(function (Daniia $daniia) {
            $daniia->from(function (Daniia $daniia) {
               $daniia->from(function (Daniia $daniia) {
                  $daniia->table("personas");
               }, "C");
            }, "B");
         }, "A")->first();
      echo $this->sql . '<br>';
      var_dump( $result );

      $result = $this
         ->select("P.id","P.nombre","P.apellido")
         ->from(function (Daniia $daniia) {
            $daniia->table("personas")->select("personas.id","personas.nombre","personas.apellido");
         }, 'P')->first();
      echo $this->sql . '<br>';
      var_dump( $result );
   }
}

