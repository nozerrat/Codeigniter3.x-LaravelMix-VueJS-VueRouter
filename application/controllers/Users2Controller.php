<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users2Controller extends CI_Controller {


   public function index( ) {

      echo " <h1> Users2 </h1> ";
      $this->load->model('users');

      // $res = $this->users->consultar(['name'=>'garlos']);
      // echo $this->users->lastQuery()." <br/> ";
      // var_dump( $res );
      // var_dump( $this->users->error() );
      // echo " <br/><br/> ";

      $res = $this->users->where(['name'=>'garlos'])->firstArray();
      echo $this->users->lastQuery()." <br/> ";
      var_dump( $res );
      var_dump( $this->users->error() );
      echo " <br/><br/> ";
      
      // $res = $this->users->consultar_uno();
      // echo $this->users->lastQuery()." <br/> ";
      // var_dump( $res );
      // var_dump( $this->users->error() );
      // echo " <br/><br/> ";
      
      // $res = $this->users->insertar(['idcontratante'=>'001','name'=>'0','email'=>'0','password'=>'0','activo'=>true]);
      // echo $this->users->lastQuery()."<br/>";
      // echo 'Res: ', $res;
      // var_dump( $this->users->error() );
      // echo " <br/><br/> ";
      
      // $res = $this->users->actualizar(['id'=>'17','idcontratante'=>'001','name'=>'0','email'=>'0','password'=>'0','activo'=>true]);
      // var_dump($this->users->lastQuery());
      // echo '<br/>Res: ', $res;
      // var_dump( $this->users->error() );
      // echo " <br/><br/> ";
      
      // $res = $this->users->borrar(['id'=>'15','idcontratante'=>'001','name'=>'0','email'=>'0','password'=>'0','activo'=>true]);
      // echo $this->users->lastQuery()."<br/>";
      // echo 'Res: ', $res;
      // var_dump( $this->users->error() );
      // echo " <br/><br/> ";

   }



}
