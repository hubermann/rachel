<?php  

#migracion imagenes
$migracionimg = "--\n-- Table structure for table `imagenes_".$plural."`\n--\n\nCREATE TABLE IF NOT EXISTS `imagenes_".$plural."` ( \n `id_imagen_".$singular."` int(".$longitudesimg[0].") NOT NULL AUTO_INCREMENT, \n";
$migracionimg .="`id_$singular` int(11) NOT NULL,\n";

foreach ($camposimg as $key => $value) {

 
 	if($key!=0){
 		if($tiposimg[$key] ==1){ $tipo = "varchar($longitudesimg[$key]) NOT NULL,\n";}
 		if($tiposimg[$key] ==2){ $tipo = "int($longitudesimg[$key]) NOT NULL,\n";}
 		if($tiposimg[$key] ==3){ $tipo = "text NOT NULL, \n";}
 		if($tiposimg[$key] ==4){ $tipo = "date NOT NULL, \n";}
 		$migracionimg .= "`$value` $tipo";
 	}
}


$migracionimg .= "PRIMARY KEY (`id_imagen_".$singular."`) \n ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; \n\n";


#verifico si existe la migracion de esta tabla
$tabla = @file_get_contents("./proyectos/".$proyecto."/migracion.txt",'r');
$buscar = "-- Table structure for table `imagenes_$plural`";
$resultado = strpos($tabla, $buscar);

if($resultado == FALSE){
	$path = fopen("./proyectos/".$proyecto."/migracion.txt","w+");
	fwrite($path, $tabla."\n\n".$migracionimg);
}


echo '<p>Migracion de imagenes: OK</p>';

?>