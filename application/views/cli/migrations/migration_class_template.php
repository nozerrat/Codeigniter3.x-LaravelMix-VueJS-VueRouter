defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_<?=$className?> extends CI_Migration {
   public function up() {
      $this->dbforge->add_field("id serial NOT NULL");
      $this->dbforge->add_field("name character varying(255) NOT NULL");
      $this->dbforge->add_field("CONSTRAINT users_pkey PRIMARY KEY (id)");
      $this->dbforge->create_table('tableName');
   }

   public function down() {
      $this->dbforge->drop_table('tableName');
   }
}
