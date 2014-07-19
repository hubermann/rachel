<?php  


//function gen_crud_modulo($proyecto, $singular, $plural, $campos, $enctype){

/*************************************/
/**************** NUEVO **************/
/*************************************/
$inputs ="";
$campos_sin_key ="";
$formnew ='
<form method="post" action="c_'.$singular.'.php" class="formvalid" '.$enctype.'>
<fieldset>
<legend>'.$plural.'</legend>
';

foreach ($campos as $key => $value) {
	if($key !=0){
		$campos_sin_key[]= $value;
	}
}

#campos restantes sin id primario
foreach($campos_sin_key as $value){
	#verifico si necesita textarea
	if($value=="descripcion" OR $value=="description" OR $value=="body"){
		$inputs[] ="\n<p><label for=\"$value\">$value</label>\n<p><textarea name=\"$value\" cols=\"10\"></textarea></p></p>\n";}
	else{
		if($value=="id_categoria"){
#select dinamico para categorias
$inputs[] = "<p><label for=\"categoria\">Categoria</label><p><select name=\"id_categoria\" id=\"\">
<?php $"."selected = \"\"; \n
include_once('classes/class.categorias_".$plural.".php');
$"."sdin = new categorias_".$plural."();
$"."sdin->categorias_".$singular."_drop_list($"."selected);
?>
</select></p></p>";
		}else{
		$inputs[] = "\n<p><label for=\"$value\">$value</label><p>\n<input type=\"text\" name=\"$value\" id=\"$value\" /></p></p>\n";
		}	
	}
}


foreach ($inputs as $key => $value) {
	$formnew .= $value;
}

#si requiere una imagen
$formnew .= '<p>
<label for="avatar">Avatar</label>
<p><input type="file" name="avatar" id="avatar" /></p>
</p>';



$formnew .='

<p>
<p><button type="submit">Aceptar</button> <button type="reset">Borrar</button> <button type="button" class="button" onClick="location.href=\'v_'.$plural.'.php\'">Cancelar</button></p>
</p>

</fieldset>
</form>
';

/*Creacion de archivos basicos*/
$fp = fopen("layout-control/base_admin1.php","r"); 
$base1 = fread($fp,90000); 
$fp2 = fopen("layout-control/base_admin2.php","r"); 
$base2 = fread($fp2,90000); 

$filenew = fopen("./proyectos/".$proyecto."/control/".$plural."/n_".$singular.".php", "w+");
fwrite($filenew, $base1.$formnew.$base2);


/*************************************/
/**************** EDITAR *************/
/*************************************/
$inputs ="";
$campos_sin_key ="";

foreach ($campos as $key => $value) {
	if($key !=0){
		$campos_sin_key[]= $value;
	}
}

$formedit .= "<?php

$"."id =$"."_GET['id'];\n
/* SELECT */
include_once(\"classes/class.$plural.php\");
$"."$plural= new $plural();
$".$plural."->select($"."id);
";

foreach ($campos as $key => $value) {
	$formedit .= "$"."$value=$".$plural."->get".$value."();\n";
}

#si requiere una imagen
if($_POST['require_image']){$formedit .= "$"."avatar=$".$plural."->getavatar();\n";}

$formedit .="\n?>\n";

$formedit .='
<form method="post" action="u_'.$singular.'.php" class="formvalid" '.$enctype.'>
<fieldset>
<legend>'.$plural.'</legend>
';

$inputs[] ="\n<input type=\"hidden\" name=\"$campos[0]\" value=\"<?php echo $$campos[0]; ?>\" />\n";



foreach($campos_sin_key as $value){
	
	if($value=="descripcion" OR $value=="description" OR $value=="body"){
		$inputs[] ="\n<p><label for=\"$value\">$value</label>\n<p><textarea name=\"$value\" cols=\"10\"><?php echo $$value; ?></textarea></p></p>\n";}
	else{
		if($value=="id_categoria"){
#select dinamico para categorias
$inputs[] = "<p><label for=\"categoria\">Categoria</label><p><select name=\"id_categoria\" id=\"\">
<?php $"."selected = \"$"."id_categoria\"; \n
include_once('classes/class.categorias_".$plural.".php');
$"."sdin = new categorias_".$plural."();
$"."sdin->categorias_".$singular."_drop_list($"."selected);
?>
</select></p></p>";
		}else{
		$inputs[] = "\n<p><label for=\"$value\">$value</label><p>\n<input type=\"text\" name=\"$value\" id=\"$value\" value=\"<?php echo $$value; ?>\"/></p></p>\n";
		}
	}
}

foreach ($inputs as $key => $value) {
	$formedit .= $value;
}


#si requiere una imagen
$formedit .= '<p>
<label for="cavatar">Avatar actual</label>
<p>
        <?php 
        if(strlen($avatar) != 0){
          echo \'<img src="../../avatar_'.$singular.'/tn_\'.$avatar.\'" alt="" width="140"/>\';
        }else{
          echo \'Sin imagen\';
        }


        ?>
</p>
<p>Reemplazar:</p>
<p><input type="file" name="avatar" id="avatar" value="" /></p>
</p>

<br />';

$formedit .='

<p>
<p><button type="submit">Aceptar</button> <button type="reset">Borrar</button> <button type="button" class="button" onClick="location.href=\'v_'.$plural.'.php\'">Cancelar</button></p>
</p>

</fieldset>
</form>
';

/*Creacion de archivos basicos*/
$fp = fopen("layout-control/base_admin1.php","r"); 
$base1 = fread($fp,90000); 
$fp2 = fopen("layout-control/base_admin2.php","r"); 
$base2 = fread($fp2,90000); 

$fileedit = fopen("./proyectos/".$proyecto."/control/".$plural."/e_".$singular.".php", "w+");
fwrite($fileedit, $base1.$formedit.$base2);

/*************************************/
/**************** CREAR *************/
/*************************************/
$inputs ="";
$campos_sin_key ="";

foreach ($campos as $key => $value) {
	if($key !=0){
		$campos_sin_key[]= $value;
	}
}

$formcreate = "<?php \n";
foreach ($campos_sin_key as $key => $value) {
	$formcreate .= "$"."$value = $"."_POST['$value'];\n";
}

#Si requiere una imagen
if($_POST['require_image']){
$formcreate .= '

if($_FILES[\'avatar\'][\'name\']!=""){
include_once(\'../resources/class.upload.php\');
      $yukle = new upload;
      $yukle->set_max_size(99999999);
      $yukle->set_directory(\'../../avatar_'.$singular.'\');
      $yukle->set_tmp_name($_FILES[\'avatar\'][\'tmp_name\']);
      $yukle->set_file_size($_FILES[\'avatar\'][\'size\']);
      $yukle->set_file_type($_FILES[\'avatar\'][\'type\']);
      //random
      $random = substr(md5(rand()),0,6);
      $avatarname= $random.\'_\'.$_FILES[\'avatar\'][\'name\'];
      $nombre_final = str_replace(\' \',\'-\',$avatarname);
      $yukle->set_file_name($nombre_final);
      $yukle->start_copy();
      $yukle->resize(600,0);
      $yukle->set_thumbnail_name(\'tn_\'.$nombre_final);
      $yukle->create_thumbnail();
      $yukle->set_thumbnail_size(300, 0);
      if($yukle->is_ok()){

      $nombre_final =$nombre_final;
      }else{
      //si hay error cargo sin imagen
      $nombre_final ="";

      }



}

';
}

$formcreate .= "
/* INSERT */\n
include_once(\"classes/class.$plural.php\");
$"."$plural= new $plural();
";

foreach ($campos_sin_key as $key => $value) {
	$formcreate .= "$"."$plural->$value=$"."$value;\n";
}

#Si requiere una imagen
if($_POST['require_image']){$formcreate .= "$".$plural."->avatar=$"."nombre_final;\n"; }


$formcreate .= "$"."".$plural."->insert();\n

echo '<div class=\"notify\"><p>$sincular Creada!</p><p><a href=\"v_$plural.php\">Regresar</a></p></div>';

?>";
$fp = fopen("layout-control/base_admin1.php","r"); 
$base1 = fread($fp,90000); 
$fp2 = fopen("layout-control/base_admin2.php","r"); 
$base2 = fread($fp2,90000); 

$filecreate = fopen("./proyectos/".$proyecto."/control/".$plural."/c_".$singular.".php", "w+");
fwrite($filecreate, $base1.$formcreate.$base2);


/*************************************/
/************ ACTUALIZAR *************/
/*************************************/
$inputs ="";
$campos_sin_key ="";

foreach ($campos as $key => $value) {
	if($key !=0){
		$campos_sin_key[]= $value;
	}
}

$formupdate = "<?php\n";
$formupdate .= "$"."id_"."$singular = $"."_POST['"."id_$singular'];\n";
foreach ($campos_sin_key as $key => $value) {
	$formupdate .= "$"."$value = $"."_POST['$value'];\n";
}



$formupdate .="\n
/* UPDATE */
include_once(\"classes/class.$plural.php\");
";
#si requiere una sola imagen
if($_POST['require_image']){
$formupdate .="

if($"."_FILES['avatar']['name']!=\"\"){

      include_once(\"classes/class."."$plural.php\");
      $"."plural= new "."$plural"."();
      $"."plural->select($"."id_"."$singular);
      $"."imagen=$"."plural->getavatar();

      if($"."imagen!=\"\"){
      unlink('../../avatar_$singular/'.$"."imagen);
      unlink('../../avatar_$singular/tn_'.$"."imagen);
      }
      include_once('../resources/class.upload.php');
      $"."yukle = new upload;
      $"."yukle->set_max_size(99999999);
      $"."yukle->set_directory('../../avatar_$singular');
      $"."yukle->set_tmp_name($"."_FILES['avatar']['tmp_name']);
      $"."yukle->set_file_size($"."_FILES['avatar']['size']);
      $"."yukle->set_file_type($"."_FILES['avatar']['type']);
      //random
      $"."random = substr(md5(rand()),0,6);
      $"."avatarname= $"."random.'_'.$"."_FILES['avatar']['name'];
      $"."nombre_final = str_replace(' ','-',$"."avatarname);
      $"."yukle->set_file_name($"."nombre_final);
      $"."yukle->start_copy();
      $"."yukle->resize(600,0);
      $"."yukle->set_thumbnail_name('tn_'.$"."nombre_final);
      $"."yukle->create_thumbnail();
      $"."yukle->set_thumbnail_size(300, 0);
      if($"."yukle->is_ok()){
      /* INSERT */

      /* UPDATE */
			include_once(\"classes/class."."$plural.php\");
			$"."plural= new "."$plural();

			$"."plural->select($"."id_"."$singular);
			$"."plural->avatar=$"."nombre_final;
			$"."plural->update($"."id_"."$singular);


      }else{
      echo '<div class=\"notify\"><p>Ocurrio un error al actualizar la imagen. Imagen no actualizada!</p></div>';
      }



}



";

}//en if require_image - update

$formupdate .= "
$"."$plural= new $plural();\n
$"."".$plural."->select($"."id_".$singular.");
";

foreach ($campos_sin_key as $key => $value) {
	$formupdate .= "$"."$plural->$value = $"."$value;\n";
}


$formupdate .= "$"."".$plural."->update($"."id_$singular);


echo '<div class=\"notify\"><p>$singular actualizada!</p><p><a href=\"v_$plural.php\">Regresar</a></p></div>';

?>";

$fp = fopen("layout-control/base_admin1.php","r"); 
$base1 = fread($fp,90000); 
$fp2 = fopen("layout-control/base_admin2.php","r"); 
$base2 = fread($fp2,90000); 

$fileupdate = fopen("./proyectos/".$proyecto."/control/".$plural."/u_".$singular.".php", "w+");
fwrite($fileupdate, $base1.$formupdate.$base2);


/*************************************/
/************ ELIMINAR ***************/
/*************************************/
$inputs ="";
$campos_sin_key ="";

foreach ($campos as $key => $value) {
	if($key !=0){
		$campos_sin_key[]= $value;
	}
}

$formdelete = "<?php\n";


$formdelete .= "$"."id=$"."_GET['id'];\n";

$formdelete .= "if(!"."$"."_POST['confirm'] && $"."_POST['pulsado']){"."$"."msgpulsado ='<div class=\"notify\"><p>Debe marcar el campo de confirmacion para poder eliminar..</p></div>';}else{"."$"."msgpulsado=\"\";}
echo "."$"."msgpulsado;";



$formdelete .= "\n/* SELECT */
include_once(\"classes/class.$plural.php\");
$"."$plural= new $plural();
$"."".$plural."->select($"."id);\n";

foreach ($campos_sin_key as $key => $value) {
	$formdelete .= "$"."$value=$"."".$plural."->get"."$value();\n";
}
#si requiere una imagen
if($_POST['require_image']){$formdelete .= "$"."imagen=$"."".$plural."->getavatar();\n"; }

$formdelete .= "
if($"."_POST['confirm']){
$"."id=$"."_POST['id_".$singular."'];\n";


#si requiere una imagen
if($_POST['require_image']){$formdelete .= "\n if($"."imagen!=\"\"){
	unlink('../../avatar_$singular/'.$"."imagen);
	unlink('../../avatar_$singular/tn_'.$"."imagen);
}"; }



if($enctype!=""){ $formdelete .="
	/* DELETE */

//borrar imagenes
///
include_once(\"classes/class.imagenes_$plural.php\");
$"."imagenes_$plural= new imagenes_$plural();
$"."files=$"."imagenes_".$plural."->bring_images($"."id);

foreach($"."files as $"."value){

$"."imagenes_$singular= new imagenes_$plural();
$"."imagenes_".$singular."->select($"."value);
$"."id_image=$"."imagenes_".$singular."->getid_imagen_$singular();
$"."titulo=$"."imagenes_".$singular."->gettitulo();
$"."filename=$"."imagenes_".$singular."->getfilename();

$"."link1='../../images-$plural/'.$"."filename;
unlink($"."link1);
$"."link2='../../images-$plural/tn_'.$"."filename;
unlink($"."link2);

$"."imagenes_".$singular."->delete($"."value);
}

//borrar imagenes
";}



$formdelete .="
include_once(\"classes/class.$plural.php\");
$"."$plural= new $plural();
$"."".$plural."->select($"."id);
$"."".$plural."->delete($"."id);

echo '<div class=\"notify\"><p>$singular, eliminado!</p><p><a href=\"v_$plural.php\">Regresar</a></p></div>';

}
else{
echo '<div class=\"dividerclean\"><form action=\"d_".$singular.".php?id='.$"."id.'\" class=\"formvalid\" method=\"post\">
		<fieldset>
			<legend><span>Eliminar $singular</span></legend>
	
			<p>
				<label for=\"confirmacion\"></label>
				<p>Confirma Eliminar este ".$singular."? <input type=\"checkbox\" name=\"confirm\" id=\"confirm\" class=\"checkbox\" /></p>
			</p> <input type=\"hidden\" name=\"id_".$singular."\" name=\"id_".$singular."\" value=\"'.$"."id.'\" />
			<input type=\"hidden\" name=\"pulsado\" value=\"1\" />
	
<p><button name=\"btnborrar\" class=\"button\">Aceptar</button> <button type=\"button\" class=\"button\" onClick=\"location.href=\'v_".$plural.".php\'\">Cancelar</button></p>
	
		</fieldset>
	</form></div>';\n
}";

$formdelete .= "?>";


$fp = fopen("layout-control/base_admin1.php","r"); 
$base1 = fread($fp,90000); 
$fp2 = fopen("layout-control/base_admin2.php","r"); 
$base2 = fread($fp2,90000); 

$filedelete = fopen("./proyectos/".$proyecto."/control/".$plural."/d_".$singular.".php", "w+");
fwrite($filedelete, $base1.$formdelete.$base2);

/*************************************/
/************** INDEX ****************/
/*************************************/

$formindex = "<?php header(\"Location: v_$plural.php\"); ?>";

$fileindex = fopen("./proyectos/".$proyecto."/control/".$plural."/index.php", "w+");
fwrite($fileindex, $formindex);


/*************************************/
/************ VIEW ALL ***************/
/*************************************/

$formviewall = "<?php
 
$"."pagina=$"."_GET['page'];
$"."ipp=$"."_GET['ipp'];
if(!$"."pagina){
$"."pagina==0;
}
$"."orden= $"."_GET['orden'];

if($"."orden==1){
$"."orden = \"id_$singular DESC\";
}
if($"."orden==2){
$"."orden = \"id_$singular ASC\";
}
if($"."orden==3){
$"."orden = \"id_$singular ASC\";
}
if($"."orden==\"\"){
$"."orden = \"id_$singular ASC\";
}

echo '<div class=\"menuorden\"><a href=\"v_$plural.php?orden=1\"><img src=\"../layout/btn-orden1.jpg\" alt=\"desc\"/></a><a href=\"v_$plural.php?orden=2\"><img src=\"../layout/btn-orden2.jpg\" alt=\"desc\"/></a></div>';
/* SELECT */
include_once(\"classes/class.$plural.php\");
$"."$plural= new $plural();
$"."".$plural."->select_all($"."pagina, $"."orden);

?>";

$fileviewall = fopen("./proyectos/".$proyecto."/control/".$plural."/v_$plural.php", "w+");
fwrite($fileviewall, $base1.$formviewall.$base2);

/*************************************/
/********* HELPER TITULOS ************/
/*************************************/

$formhelpertitulos ="<?php $"."singular ='$singular'; $"."plural='$plural'; ?>";

$filehelpertitulos = fopen("./proyectos/".$proyecto."/control/".$plural."/helper_titulos.php", "w+");
fwrite($filehelpertitulos,$formhelpertitulos);


/* copy paste  de codigos */
$helpercode .= "
/* UPDATE */
include_once(\"classes/class.$plural.php\");
$"."$plural= new $plural();
$"."".$plural."->select($"."id_".$singular.");
";

foreach ($campos_sin_key as $key => $value) {
	$helpercode .= "$"."$plural->$value = $"."$value;\n";
}


$helpercode .= "$"."".$plural."->update($"."id_$singular);";

$helpercode .= "\n
/* INSERT */
include_once(\"classes/class.$plural.php\");
$"."$plural= new $plural();
";

foreach ($campos_sin_key as $key => $value) {
	$helpercode .= "$"."$plural->$value=$"."$value;\n";
}




$helpercode .= "$"."".$plural."->insert();";


$filehelpercode = fopen("./proyectos/".$proyecto."/control/".$plural."/helper_code.php", "w+");
fwrite($filehelpercode,$helpercode);



/*************************************/
/*********** MENU INTERNO ************/
/*************************************/

$formmenu = " <li><a href=\"v_$plural.php\"> Ver $plural</a></li>";

$folder_inc = "./proyectos/".$proyecto."/control/".$plural."/inc/";
mkdir($folder_inc);


$filemenu = fopen("./proyectos/".$proyecto."/control/".$plural."/inc/menu_$plural.php", "w+");
fwrite($filemenu,$formmenu);





//}

?>

