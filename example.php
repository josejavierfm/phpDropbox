<?php
date_default_timezone_set('Europe/Madrid');
require_once("Dropbox.php");

$carpeta_dropbox="mybackup";



// create instance



try {
  	echo "<h1>Create class</h1><br>";
  	$phpDB=new phpDropbox();
  	echo "<h2>Create folder</h2><br>";
  	$nuevacarpeta=$carpeta_dropbox."_new_".date("YmdH");
  	$phpDB->CrearCarpetaDROPBOX($nuevacarpeta);
  	
  	echo "<h2>Metadata folder</h2><br>";
  	$data=$phpDB->MetadataDROPBOX($nuevacarpeta);
  	echo "<pre>";print_r($data);echo "</pre>";

	echo "<h2>Files on folder ".$carpeta_dropbox."</h2><br>";
	$archivos_existentes = $phpDB->FicherosDROPBOX($nuevacarpeta);
	$obj = json_decode($archivos_existentes);
	if ($obj->entries){
	  	foreach($obj->entries as $ae){
	  		$nombres[]= $ae->name;
	  	}
	}
	echo "<pre>";print_r($nombres);echo "</pre>";

	echo "<h2>Upload a file</h2><br>";
	$ficherotmp=date("YmdHis").".txt";
	$content="Test File \n";
	$content.=date("YmdHis")."\n";
	file_put_contents($ficherotmp, $content);
	echo "File test created<br>";

	if ($phpDB->SubirDROPBOX($ficherotmp,".",$nuevacarpeta)){
		echo "Subido correctamente<br>";
		unlink($ficherotmp);
	}
				
	


} catch (Exception $e) {
	echo "Se ha producido una excepcion";
  	var_dump($e);
}


