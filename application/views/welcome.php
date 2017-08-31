<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="es">
	<head>
	   <base href="<?=base_url()?>">
	   <meta charset="utf-8">
	   <meta http-equiv="X-UA-Compatible" content="IE=edge">
	   <meta name="viewport" content="width=device-width, initial-scale=1">
	   <meta name="csrf-token" content="<?=$this->security->get_csrf_hash()?>">
	   <meta name="csrf-token-name" content="<?=$this->security->get_csrf_token_name()?>">

	   <link href="public/css/app.css" rel="stylesheet">
	   <link href="public/css/all.css" rel="stylesheet">
	    
	   <title>QHSE</title>
	   
	   <script src="public/js/app.js"></script>
	</head>
	<body>
		<div id="loading">
	      <div style="overflow: hidden; width:100%; height:100%; z-index:1000; position:fixed; top:0; left:0;">
	         <div style="overflow: hidden; width:100%; height:100%; z-index:1; position:fixed; top:0; left:0; background-color:black; opacity:0.1;"></div>
	         <div style="z-index:1100;text-align:center;font-size:75px;color:#737272;top:50px;margin-top: 120px;;">
	            <h1>Cargando</h1>
	            <i class="fa fa-spinner fa-pulse"></i>
	         </div>
	      </div>
	   </div>
	</body>
</html>
