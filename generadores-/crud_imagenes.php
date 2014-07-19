<?php 
echo $singular.'--'.$plural.'<br />';
foreach ($camposimg as $key => $value) {
	if($key !=0){
	echo ':::'.$key.''.$value;
	}
}

$formadd ="<?php\n
$"."id_$singular= $"."_GET['id'];
include_once(\"classes/class.$plural.php\");
$".$plural."= new $plural();
$".$plural."->select($"."id_$singular);\n";

foreach ($campos as $key => $value) {
	
	$formadd .= "$$id_$value=$".$plural."->get$value();\n";
	
}


$formadd .="
echo '<div class=\"divider\">
<div class=\"contentProduct\">\n";

foreach ($campos as $key => $value) {
	if($key!=0){
	$formadd .= "<p><strong>$value: </strong>'.$$value.'</p>\n";
	}
}

$formadd .="';";
$formadd .="

echo '</div>

<div class=\"productOptions\">
<a href=\"e_$singular.php?id='.$"."id_$singular.'\">Editar</a>
<a href=\"d_$singular.php?id='.$"."id_$singular.'\">Borrar $singular</a>
<a href=\"add_image.php?in='.$"."id_$singular.'\" >Agregar imagenes</a>
<a href=\"del_images.php?in='.$"."id_$singular.'\" >Eliminar imagenes</a>
<a href=\"m_avatar.php?in='.$"."id_$singular.'\" >Cambiar principal</a>

</div>

</div>';


?>
<div class=\"dividerclean\">
<p>Si este item no tiene imagenes asociadas la primer imagen cargada sera marcada como la principal.</p>
<form method=\"post\" action=\"u_image.php\" class=\"formvalid\" enctype=\"multipart/form-data\">
<fieldset>
<legend>Agregar imagenes</legend>
<input type=\"hidden\" name=\"id_$singular\" id=\"id_$singular\" value=\"<?php echo $"."id_$singular; ?>\"/>



<p>
<label for=\"cImagen\">Imagen 1</label>
<p><input type=\"file\" name=\"image_field[]\" id=\"image_field\" /></p>
</p>

<p>
<label for=\"cImagen\">Imagen 2</label>
<p><input type=\"file\" name=\"image_field[]\" id=\"image_field\" /></p>
</p>

<p>
<label for=\"cImagen\">Imagen 3</label>
<p><input type=\"file\" name=\"image_field[]\" id=\"image_field\" /></p>
</p>

<p>
<label for=\"cImagen\">Imagen 4</label>
<p><input type=\"file\" name=\"image_field[]\" id=\"image_field\" /></p>
</p>

<p>
<label for=\"cImagen\">Imagen 5</label>
<p><input type=\"file\" name=\"image_field[]\" id=\"image_field\" /></p>
</p>


<p><button type=\"submit\">Aceptar</button></p>

</fieldset>
</form>

</div>";

$fp = fopen("layout-control/base_admin1.php","r"); 
$base1 = fread($fp,90000); 
$fp2 = fopen("layout-control/base_admin2.php","r"); 
$base2 = fread($fp2,90000); 

$fileadd = fopen("./proyectos/".$proyecto."/control/".$plural."/add_image.php", "w+");
fwrite($fileadd, $base1.$formadd.$base2);

/***************************************/
/********* UPLOAD IMAGE ****************/
/***************************************/

$formuploadimg ="

<?php 
$"."id_$singular=$"."_POST['id_$singular'];

include('../resources/class.upload.php');

include_once(\"classes/class.imagenes_$plural.php\");";

$formuploadimg .="	
for($"."i=0;$"."i<count($"."_FILES['image_field']);$"."i++) {



	
if($"."_FILES['image_field']['size'][$"."i]>0){	
$"."yukle = new upload;
$"."yukle->set_max_size(1900000);
$"."yukle->set_directory('../../images-$plural/');
$"."yukle->set_tmp_name($"."_FILES['image_field']['tmp_name'][$"."i]);
$"."yukle->set_file_size($"."_FILES['image_field']['size'][$"."i]);
$"."yukle->set_file_type($"."_FILES['image_field']['type'][$"."i]);
$"."random = substr(md5(rand()),0,6);
$"."imagname=''.$"."random.'_'.$"."_FILES['image_field']['name'][$"."i];
$"."thumbname='tn_'.$"."imagname;
$"."yukle->set_file_name($"."imagname);
$"."yukle->start_copy();
$"."yukle->resize(600,0);
if($"."yukle->is_ok()){
echo '<div class=\"notify\"><p>Imagen cargada! </p></div>';
$"."error=0;
}
else{
echo $"."yukle->error().'<div class=\"notify\">Image Error! - '.$"."_FILES['image_field']['name'][$"."i].' </div>';
$"."error=1;
}
$"."yukle->set_thumbnail_name('tn_'.$"."random.'_'.$"."_FILES['image_field']['name'][$"."i]);
$"."yukle->create_thumbnail();
$"."yukle->set_thumbnail_size(180, 0);


if($"."error==0){
$"."images_".$plural."= new imagenes_$plural();";
#imagefile es imagname (nombre final de la imagen)
$formuploadimg .= "\n$"."images_".$plural."->filename=$"."imagname;";
foreach ($camposimg as $key => $value) {
	if($key!=0){
		if($value !="filename"){
			$formuploadimg .= "\n$"."images_".$plural."->$value=$"."$value;";
		}
	}
}

$formuploadimg .= "\n$"."images_".$plural."->".$campos[0]."=$".$campos[0].";";

$formuploadimg .="
$"."images_".$plural."->insert();
}


//end if
}	
	
//end for		
}
echo '<a href=\"details_$singular.php?id='.$"."id_$singular.'\">Regresar</a>';

?>";


$fileuploadimg = fopen("./proyectos/".$proyecto."/control/".$plural."/u_image.php", "w+");
fwrite($fileuploadimg, $base1.$formuploadimg.$base2);






#include detalle

$form_inc_detalle = "

<?php\n
$"."id_$singular= $"."_GET['id'];
include_once(\"classes/class.$plural.php\");
$".$plural."= new $plural();
$".$plural."->select($"."id_$singular);\n";

foreach ($campos as $key => $value) {
	
	$form_inc_detalle .= "$$id_$value=$".$plural."->get$value();\n";
	
}

$categoria_item ="";
foreach ($campos as $key => $value) {
	if($value!="id_categoria" && $value != "id_$singular"){
			$items .= "<p><strong>$value: </strong>'.$$value.'</p>\n";
		}else{
			#si necesito traer nombre de categoria
			$form_inc_detalle .= "include_once('classes/class.categorias_".$plural.".php'); 
			$"."namecat = new categorias_".$plural."();
			$"."namecat->select($"."$camposcat[0]);
			$"."nombre_categoria = $"."namecat->getnombre();  ";
			#si nencesito mostrar nombre de categoria
			$categoria_item ="<p><strong>Categoria: </strong> '.$"."nombre_categoria.'</p>";
		}
}



$form_inc_detalle .="
echo '<div class=\"divider\">
<div class=\"contentProduct\">\n";


$form_inc_detalle .="
$categoria_item
$items';
echo '</div>

<div class=\"productOptions\">
<a href=\"e_$singular.php?id='.$"."id_$singular.'\">Editar</a>
<a href=\"d_$singular.php?id='.$"."id_$singular.'\">Borrar $singular</a>
<a href=\"add_image.php?id='.$"."id_$singular.'\" >Agregar imagenes</a>
<a href=\"del_images.php?id='.$"."id_$singular.'\" >Eliminar imagenes</a>
<a href=\"m_avatar.php?id='.$"."id_$singular.'\" >Cambiar principal</a>

</div>

</div>'; ?>";

$fileparcial_detalle = fopen("./proyectos/".$proyecto."/control/".$plural."/parcial_detalle.php", "w+");
fwrite($fileparcial_detalle, $form_inc_detalle);


/***************************************/
/************** DETAILS ****************/
/***************************************/


$formdetail = "

<?php 

include_once('parcial_detalle.php');";

$formdetail .= "
///
include_once(\"classes/class.imagenes_$plural.php\");
$"."imagenes_$plural= new imagenes_$plural();
$"."files=$"."imagenes_".$plural."->bring_images($"."id_$singular);

include_once(\"classes/class.$plural.php\");
$"."av = new $plural();
$"."av->select($"."id_$singular);
$"."avatar = $"."av->getmain_image();

if($"."files!=\"\"){
echo '<div class=\"divider\">';

foreach($"."files as $"."value){

$"."imagenes_$singular= new imagenes_$plural();
$"."imagenes_".$singular."->select($"."value);
$"."id_image=$"."imagenes_".$singular."->getid_imagen_$singular();
$"."titulo=$"."imagenes_".$singular."->gettitulo();
$"."filename=$"."imagenes_".$singular."->getfilename();


if($"."avatar== $"."value){
	"."$"."styleselected =\"style='background:#d7fcff; border:1px solid #00edff;'\";}else{"."$"."styleselected=\"\";
}


echo '

<div class=\"thumb\" '.$"."styleselected.' ><div class=\"contimg\"><img src=\"../../images-$plural/tn_'.$"."filename.'\" alt=\"'.$"."titulo.'\" /></div></div>


';
}
echo '</div>';
}else{
echo 'no hay imagenes adicionales en este item.';
}
?>";

$filedetail = fopen("./proyectos/".$proyecto."/control/".$plural."/details_$singular.php", "w+");
fwrite($filedetail, $base1.$formdetail.$base2);


/***************************************/
/********* MODIFICAR AVATAR ************/
/***************************************/

$formm_avatar ="<?php\n
include_once('parcial_detalle.php');

echo '<h3>Cambiar imagen principal</h3>';

include_once(\"classes/class.$plural.php\");
$"."av = new $plural();
$"."av->select($"."id_$singular);
$"."avatar = $"."av->getmain_image();

///
include_once(\"classes/class.imagenes_$plural.php\");
$"."imagenes_$plural= new imagenes_$plural();
$"."files=$"."imagenes_".$plural."->bring_images($"."id_$singular);
if($"."files!=\"\"){

echo '<div class=\"divider\"><form method=\"post\" action=\"u_avatar.php\" class=\"formvalid\">
<input type=\"hidden\" name=\"id_$singular\" id=\"id_$singular\" value=\"'.$"."id_$singular.'\" />';

foreach($"."files as $"."value){

$"."imagenes_$singular= new imagenes_$plural();
$"."imagenes_".$singular."->select($"."value);
$"."id_image=$"."imagenes_".$singular."->getid_imagen_$singular();
$"."titulo=$"."imagenes_".$singular."->gettitulo();
$"."filename=$"."imagenes_".$singular."->getfilename();

if($"."avatar== $"."value){
	"."$"."styleselected =\"style='background:#d7fcff; border:1px solid #00edff;'\";}else{"."$"."styleselected=\"\";
}


echo '<div class=\"thumb\" '.$"."styleselected.'><div class=\"contimg\">
<img src=\"../../images-$plural/tn_'.$"."filename.'\" alt=\"'.$"."titulo.'\"/>
</div><input type=\"radio\" name=\"idimage\" value=\"'.$"."value.'\"/></div>
';

}
echo '<div class=\"productOptions\"> 
<br /><button type=\"submit\">Aceptar</button></div>
</form></div>';
}else{
echo 'no hay imagenes adicionales en este item.';
}



?>";

$filem_avatar = fopen("./proyectos/".$proyecto."/control/".$plural."/m_avatar.php", "w+");
fwrite($filem_avatar, $base1.$formm_avatar.$base2);


/***************************************/
/*********** UPGRADE AVATAR ************/
/***************************************/
$formu_avatar = "<?php if($"."_POST['id_$singular']){
	$"."id_$singular = $"."_POST['id_$singular'];
	$"."idimage = $"."_POST['idimage'];
	
include_once(\"classes/class.$plural.php\");
$"."$plural= new $plural();

$"."".$plural."->select($"."id_$singular);
$"."".$plural."->main_image = $"."idimage;
$"."".$plural."->update_avatar($"."id_$singular);



header(\"Location: details_$singular.php?id=$"."id_$singular\");
}else{
	header(\"Location: details_$singular.php?id=$"."id_$singular\");
}?>";
$fileu_avatar = fopen("./proyectos/".$proyecto."/control/".$plural."/u_avatar.php", "w+");
fwrite($fileu_avatar, $formu_avatar);


/***************************************/
/*********IMAGENES A ELIMINAR **********/
/***************************************/
$formdelimages ="<?php\n
include_once('parcial_detalle.php');

echo '<h3>Eliminar imagenes</h3>';

include_once(\"classes/class.$plural.php\");
$"."av = new $plural();
$"."av->select($"."id_$singular);
$"."avatar = $"."av->getmain_image();

///
include_once(\"classes/class.imagenes_$plural.php\");
$"."imagenes_$plural= new imagenes_$plural();
$"."files=$"."imagenes_".$plural."->bring_images($"."id_$singular);
if($"."files!=\"\"){

echo '<div class=\"divider\">
<form method=\"post\" action=\"d_images.php\" class=\"formvalid\">

<input type=\"hidden\" name=\"id_$singular\" id=\"id_$singular\" value=\"'.$"."id_$singular".".'\" />
';

foreach($"."files as $"."value){

$"."imagenes_$singular= new imagenes_$plural();
$"."imagenes_".$singular."->select($"."value);
$"."id_image=$"."imagenes_".$singular."->getid_imagen_$singular();
$"."titulo=$"."imagenes_".$singular."->gettitulo();
$"."filename=$"."imagenes_".$singular."->getfilename();

if($"."avatar!= $"."value){
	echo '<div class=\"thumb\">
<div class=\"contimg\">
<img src=\"../../images-$plural/tn_'.$"."filename.'\" alt=\"'.$"."titulo.'\"/>
</div>
<input type=\"checkbox\" name=\"idimage['.$"."id_image.']\" value=\"'.$"."id_image.'\"/>
</div>

';
}




}
echo '<div class=\"productOptions\"> 
<br /><button type=\"submit\">Aceptar</button>
</div>
</form></div>';

}else{
echo 'no hay imagenes adicionales en este item.';
}



?>";

$filedelimages = fopen("./proyectos/".$proyecto."/control/".$plural."/del_images.php", "w+");
fwrite($filedelimages, $base1.$formdelimages.$base2);


/***************************************/
/********** BORRAR IMAGENES  ***********/
/***************************************/

$formdimages = " <?php 
$"."id_$singular = $"."_POST['id_$singular'];

$"."imagenes = $"."_POST['idimage'];

include_once(\"classes/class.imagenes_$plural.php\");




foreach($"."imagenes as $"."keyimg =>$"."imagen){


$"."images_app= new imagenes_$plural();
$"."images_app->select($"."imagen);
$"."id_image=$"."images_app->getid_imagen_$singular();
$"."image_file=$"."images_app->getfilename();

$"."link1='../../images-$plural/'.$"."image_file;
unlink($"."link1);
$"."link2='../../images-$plural/tn_'.$"."image_file;
unlink($"."link2);
$"."images_app->delete($"."imagen);


//end foreach	
}
echo '<div class=\"notify\"><p>Imagenes eliminadas</p><a href=\"details_$singular.php?id='.$"."id_$singular.'\">Regresar</a></div>';

?>
";


$filedimages = fopen("./proyectos/".$proyecto."/control/".$plural."/d_images.php", "w+");
fwrite($filedimages, $base1.$formdimages.$base2);


?>