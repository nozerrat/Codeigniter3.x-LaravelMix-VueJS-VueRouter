<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Blog extends CI_Migration {
   public function up() {
      $this->dbforge->add_field("id serial NOT NULL");
      $this->dbforge->add_field("name character varying(255) NOT NULL");
      $this->dbforge->add_field("email character varying(255) NOT NULL");
      $this->dbforge->add_field("password character varying(255) NOT NULL");
      $this->dbforge->add_field("password_reset character varying(255) DEFAULT 'false'");
      $this->dbforge->add_field("CONSTRAINT users_pkey PRIMARY KEY (id)");
      $this->dbforge->add_field("CONSTRAINT users_email_unique UNIQUE (email)");
      $this->dbforge->create_table('users');
   }

   public function down() {
      $this->dbforge->drop_table('users');
   }
}

