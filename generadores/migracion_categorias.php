<?php  


#migracion categoria
$migracioncat = "--\n-- Table structure for table `categorias_".$plural."`\n--\n\nCREATE TABLE IF NOT EXISTS `categorias_".$plural."` ( \n `$camposcat[0]` int(".$longitudescat[0].") NOT NULL AUTO_INCREMENT, \n";
foreach ($camposcat as $key => $value) {

 	
 	if($key!=0){
 		if($tiposcat[$key] ==1){ $tipo = "varchar($longitudescat[$key]) NOT NULL,\n";}
 		if($tiposcat[$key] ==2){ $tipo = "int($longitudescat[$key]) NOT NULL,\n";}
 		if($tiposcat[$key] ==3){ $tipo = "text NOT NULL, \n";}
 		if($tiposcat[$key] ==4){ $tipo = "date NOT NULL, \n";}
 		$migracioncat .= "`$value` $tipo";
 	}


} 
$migracioncat .= "PRIMARY KEY (`$camposcat[0]`) \n ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; \n\n";
#escribo migracion de categoria al archivo de migracion del proyecto
#$migration_file=fopen("./proyectos/".$proyecto."/migracion.txt","a+");
#fputs($migration_file,$migracioncat);

#verifico si existe la migracion de esta tabla
$tabla = @file_get_contents("./proyectos/".$proyecto."/migracion.txt",'r');
$buscar = "-- Table structure for table `categorias_$plural`";
$resultado = strpos($tabla, $buscar);

if($resultado == FALSE){
	$path = fopen("./proyectos/".$proyecto."/migracion.txt","w+");
	fwrite($path, $tabla."\n\n".$migracioncat);
}

echo '<p>Migracion de categoria: OK</p>';

?>