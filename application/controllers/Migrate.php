<?php

class Migrate extends CI_Controller {
   public function __construct() {
      parent::__construct();
      if ( !$this->input->is_cli_request() ) {
         show_error('Usted no tiene permiso para esta acción.');
         return;
      }

      $this->load->library('migration');
   }

   public function version( string $version ) {
      $migration = $this->migration->version( $version );
      if (!$migration) {
         echo $this->migration->error_string().PHP_EOL.PHP_EOL;
      } else {
         echo 'Migración hecha.'.PHP_EOL.PHP_EOL;
      }
   }

   public function generate( $name = null ) {
      if ( !$name ) {
         echo 'Por favor devina el nombre de la migración.'.PHP_EOL.PHP_EOL;
      }
      elseif ( strlen( $name ) < 4 ) {
         echo 'El nombre la de migración debe ser mayor de 4 caracteres'.PHP_EOL.PHP_EOL;
      }
      elseif ( !preg_match('/^[a-z_]*$/i', $name) ) {
         echo 'Nombre de migración incorrecta, los caracteres permitidos son: "a-z" y "_".'.PHP_EOL.PHP_EOL;
      }
      else {
         $fileName = date('YmdHis').'_'.$name.'.php';
         try {
            $folderPath = APPPATH . 'migrations';
            if ( !is_dir($folderPath) ) {
               try {
                  mkdir($folderPath);
               } catch (Exception $e) {
                  echo "Error: ". $e->getMessage() .PHP_EOL.PHP_EOL;
               }
            }

            $filePath = $folderPath .'/'. $fileName;
            if (file_exists($filePath)) {
               echo "El archivo ya existe: \n".$fileName.PHP_EOL.PHP_EOL;
            }
            else {
               $data['className'] = ucfirst( $name );
               $template = $this->load->view('cli/migrations/migration_class_template', $data, TRUE);
               try {
                  $file = fopen($filePath, 'w');
                  $content = "<?php\n" . $template;
                  fwrite($file, $content);
                  fclose($file);
                  echo "El siguiente archivo fue creado:\n" . $fileName .PHP_EOL.PHP_EOL;
               } catch (Exception $e) {
                  echo "Error: ". $e->getMessage() .PHP_EOL.PHP_EOL;
               }
            }
         } catch (Exception $e) {
            echo "No se pudo crear el archivo de migración! \nError: ". $e->getMessage() .PHP_EOL.PHP_EOL;
         }
      }
   }
}