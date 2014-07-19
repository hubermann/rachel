<?php error_reporting(0); ?>
<html>
<head>
	<style type="text/css">
	body{width:800px; margin:0 auto; font-family:arial; font-size:.8em}
</style>
</head>
<body>
		

<?php 

#modulo
$proyecto = $_POST['proyecto'];
$singular = $_POST['singular'];
$plural = $_POST['plural'];
$campos = $_POST['campo'];
$tipos = $_POST['campo_tipo'];
$longitudes = $_POST['longitud'];


foreach($campos as $field){
	$field = trim($field);
	#echo '['.$field.']';
	if($field!="id" AND $field != 'created_at' AND $field != 'updated_at'){
		
		$fields_clean[] = $field;
	}
}



#categorias
$camposcat = $_POST['campo_cat'];
$tiposcat = $_POST['campo_tipo_cat'];
$longitudescat = $_POST['longitud_cat'];

foreach($camposcat as $catfield){
	$catfield = trim($catfield);
	echo '['.$catfield.']';
	
	if($catfield!= $singular."_categoria_id" AND $catfield != 'created_at' AND $catfield != 'updated_at'){
		
		$catfields_clean[] = $catfield;
	}
}


var_dump($catfields_clean);





#imagenes 
$camposimg = $_POST['campo_img'];
$tiposimg = $_POST['campo_tipo_img'];
$longitudesimg = $_POST['longitud_img'];

#imagen
#Si requiere imagen viene por Post el campo [require_image] como hidden
#el archivo 'generadores/migracion_modulo.php' agrega el campo 'avatar' tipo varchar de 255 para guardar el path de la imagen

/********* MIGRACION ***********/

#escribo migracion del modulo al archivo de migracion del proyecto


#si necesita imagenes los formularios son multipart
if($_POST['campo_img']){
	$enctype='_multipart'; 
	
	}else{
	$enctype='';
	$field_avatar = "";
	$imagenes = "1";
	

}
#si necesita imagen los formularios son multipart
if($_POST['require_image']){ 	
#enctype del formulario
$enctype='_multipart'; 

#campo image para los formularios
$field_avatar = '
<p>
<label for="avatar">avatar</label>
<p><input type="file" name="avatar" id="avatar" /></p>
</p>';

#mostrar imagen en las vistas
$avatar_vista ='
?>
<?php if($row->avatar!=""): ?>
<img src="../images-'.$plural.'/<?php echo $row->avatar; ?>" alt="" width="150" />
<?php else: ?>
<p>No hay imagen</p>
<?php endif; ?>

';

echo '<h2>Recuerde crear la carpeta ./images-'.$plural.'/</h2>';
}else{
$enctype='';
$avatar_vista = '';
$field_avatar = '';
$avatar_vista ='
?>';
$imagenes = "1";
	}



	# Genero modulo
	
	#tablas para migracion de la BD del modulo
	include_once('generadores/migracion_modulo.php');
	
	include_once('generadores/gen_controller.php');
	include_once('generadores/gen_model.php');
	
	include_once('generadores/gen_views.php');
	
	
	
	
	
	
	#clase del modulo
	#include_once('generadores/clase_modulo.php');
	#include_once('generadores/clase_f_modulo.php');
	
	#include_once('generadores/generadores.php'); //?
	#gen_class_modulo($proyecto, $plural, $singular,$campos, $imagenes);
	#archivos del modulo
	#include_once('generadores/crud_modulo.php');
	#include_once('generadores/crud_front.php');
	#gen_crud_modulo($proyecto, $singular, $plural, $campos, $enctype);

$key="";
$value="";


#si necesita categoria
if($_POST['campo_cat']){
	echo "<h4> $plural</h4><h4>".$singular."_categoria_id</h4>";
	include_once('generadores/migracion_categorias.php');
	include_once('generadores/gen_controller_categoria.php');
	include_once('generadores/gen_views_categoria.php');
	include_once('generadores/gen_model_categoria.php');
	
	#include_once('generadores/clase_categoria_modulo.php');
	#include_once('generadores/clase_f_categoria_modulo.php');
	#include_once('generadores/crud_categoria_modulo.php');
	#include_once('generadores/menu_adicional_modulo.php');

}
$key="";
$value="";

#si necesita imagenes
if($_POST['campo_img']){
	include_once('generadores/migracion_imagenes.php');
	
	#CLASE PARA IMAGENES
	#include_once('generadores/clase_imagenes.php');
	#include_once('generadores/clase_f_imagenes.php');


	#CRUD PARA IMAGENES
	#include_once('generadores/crud_imagenes.php');


}
$key="";
$value="";

	


/*

#AGREGO ITEM A MENU PRINCIPAL
$nuevoitem = "<li><a href=\"http://'.$"."_SERVER['HTTP_HOST'].'/control/$plural/\">$plural</a></li>";

$readmenu = @file_get_contents("./proyectos/".$proyecto."/admin/main_menu.php",'r');
$buscar = "/control/$plural/";
$resultado = strpos($readmenu, $buscar);

if($resultado == FALSE){
    $menuupdate = str_replace("<!-- additem-->", $nuevoitem."<!-- additem-->", $readmenu);
	$path = fopen("./proyectos/".$proyecto."/control/inc/main_menu.php","w+");
	fwrite($path, $menuupdate);
}

*/
?>



</body>

</html>
