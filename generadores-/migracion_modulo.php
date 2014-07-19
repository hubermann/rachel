<?php  
#este archivo se encarga de generar el archivo de migracion para crear las tablas en la BD

$migracion = "--\n-- Table structure for table `".$plural."`\n--\n\nCREATE TABLE IF NOT EXISTS `".$plural."` ( \n `id_".$singular."` int(".$longitudes[0].") NOT NULL AUTO_INCREMENT, \n";
foreach ($campos as $key => $value) {

 	if($key!=0){
 		if($tipos[$key] ==1){ $tipo = "varchar($longitudes[$key]) NOT NULL,\n";}
 		if($tipos[$key] ==2){ $tipo = "int($longitudes[$key]) NOT NULL,\n";}
 		if($tipos[$key] ==3){ $tipo = "text NOT NULL, \n";}
 		if($tipos[$key] ==4){ $tipo = "date NOT NULL, \n";}
 		$migracion .= "`$value` $tipo";
 	}
} 
#si necesita imagenes agrego campo para marcar principal
if($_POST['campo_img']){$migracion .="`main_image` tinyint(5) NOT NULL,\n";}
#si require imagen agrego campo avatar 
if($_POST['require_image']){$migracion .="`avatar` varchar(255) NOT NULL,\n";}

$migracion .= "PRIMARY KEY (`id_".$singular."`) \n ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; \n\n";

#verifico si existe la migracion de esta tabla
$tabla = @file_get_contents("./proyectos/".$proyecto."/migracion.txt",'r');
$buscar = "-- Table structure for table `$plural`";
$resultado = strpos($tabla, $buscar);

if($resultado == FALSE){
	$path = fopen("./proyectos/".$proyecto."/migracion.txt","w+");
	fwrite($path, $tabla."\n\n".$migracion);
}
echo '<p>Migracion de modulo: OK</p>';

?>