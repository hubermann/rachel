<?php  




/*************************************/
/**************** NUEVO **************/
/*************************************/
$inputs ="";
$campos_sin_key ="";
$formnew ='
<form method="post" action="c_categoria_'.$singular.'.php" class="formvalid" '.$enctype.'>
<fieldset>
<legend>Categorias '.$plural.'</legend>
';

foreach ($camposcat as $key => $value) {
	if($key !=0){
		$campos_sin_key[]= $value;
	}
}

#campos restantes sin id primario
foreach($campos_sin_key as $value){
	
	if($value=="descripcion" OR $value=="description" OR $value=="body"){
		$inputs[] ="\n<p><label for=\"$value\">$value</label>\n<p><textarea name=\"$value\" cols=\"10\"></textarea></p></p>\n";}
	else{
		$inputs[] = "\n<p><label for=\"$value\">$value</label><p>\n<input type=\"text\" name=\"$value\" id=\"$value\" /></p></p>\n";
	}
}

foreach ($inputs as $key => $value) {
	$formnew .= $value;
}

$formnew .='

<p>
<p><button type="submit">Aceptar</button> <button type="reset">Borrar</button> <button type="button" class="button" onClick="location.href=\'v_categoria_'.$plural.'.php\'">Cancelar</button></p>
</p>

</fieldset>
</form>
';

/*Creacion de archivos basicos*/
$fp = fopen("layout-control/base_admin1.php","r"); 
$base1 = fread($fp,90000); 
$fp2 = fopen("layout-control/base_admin2.php","r"); 
$base2 = fread($fp2,90000); 

$filenew = fopen("./proyectos/".$proyecto."/control/".$plural."/n_categoria_".$singular.".php", "w+");
fwrite($filenew, $base1.$formnew.$base2);


/*************************************/
/**************** EDITAR *************/
/*************************************/
$inputs ="";
$campos_sin_key ="";
$formedit="";
foreach ($camposcat as $key => $value) {
	if($key !=0){
		$campos_sin_key[]= $value;
	}
}

$formedit .= "<?php

$"."id =$"."_GET['id'];\n
/* SELECT */
include_once(\"classes/class.categorias_$plural.php\");
$"."$plural= new categorias_$plural();
$".$plural."->select($"."id);
";

foreach ($camposcat as $key => $value) {
	$formedit .= "$"."$value=$".$plural."->get".$value."();\n";
}

$formedit .="\n?>\n";

$formedit .='
<form method="post" action="u_categoria_'.$singular.'.php" class="formvalid" '.$enctype.'>
<fieldset>
<legend>'.$plural.'</legend>
';

$inputs[] ="\n<input type=\"hidden\" name=\"$camposcat[0]\" value=\"<?php echo $$camposcat[0]; ?>\" />\n";



foreach($campos_sin_key as $value){
	
	if($value=="descripcion" OR $value=="description" OR $value=="body"){
		$inputs[] ="\n<p><label for=\"$value\">$value</label>\n<p><textarea name=\"$value\" cols=\"10\"><?php echo $$value; ?></textarea></p></p>\n";}
	else{
		$inputs[] = "\n<p><label for=\"$value\">$value</label><p>\n<input type=\"text\" name=\"$value\" id=\"$value\" value=\"<?php echo $$value; ?>\"/></p></p>\n";
	}
}

foreach ($inputs as $key => $value) {
	$formedit .= $value;
}

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

$fileedit = fopen("./proyectos/".$proyecto."/control/".$plural."/e_categoria_".$singular.".php", "w+");
fwrite($fileedit, $base1.$formedit.$base2);

/*************************************/
/**************** CREAR *************/
/*************************************/
$inputs ="";
$campos_sin_key ="";
$formcreate ="";
foreach ($camposcat as $key => $value) {
	if($key !=0){
		$campos_sin_key[]= $value;
	}
}

$formcreate = "<?php \n";
foreach ($campos_sin_key as $key => $value) {
	$formcreate .= "$"."$value = $"."_POST['$value'];\n";
}



$formcreate .= "
/* INSERT */\n
include_once(\"classes/class.categorias_$plural.php\");
$"."$plural= new categorias_$plural();
";

foreach ($campos_sin_key as $key => $value) {
	$formcreate .= "$"."$plural->$value=$"."$value;\n";
}


$formcreate .= "$"."".$plural."->insert();\n

echo '<div class=\"notify\"><p>categoria $singular Creada!</p><p><a href=\"v_categorias_$plural.php\">Regresar</a></p></div>';

?>";
$fp = fopen("layout-control/base_admin1.php","r"); 
$base1 = fread($fp,90000); 
$fp2 = fopen("layout-control/base_admin2.php","r"); 
$base2 = fread($fp2,90000); 

$filecreate = fopen("./proyectos/".$proyecto."/control/".$plural."/c_categoria_".$singular.".php", "w+");
fwrite($filecreate, $base1.$formcreate.$base2);


/*************************************/
/************ ACTUALIZAR *************/
/*************************************/
$inputs ="";
$campos_sin_key ="";
$formupdate="";
foreach ($camposcat as $key => $value) {
	if($key !=0){
		$campos_sin_key[]= $value;
	}
}

$formupdate = "<?php\n";

$formupdate .= "$"."$camposcat[0] = $"."_POST['"."$camposcat[0]'];\n";
foreach ($campos_sin_key as $key => $value) {
	$formupdate .= "$"."$value = $"."_POST['$value'];\n";
}

$formupdate .="\n
/* UPDATE */
include_once(\"classes/class.categorias_$plural.php\");
$"."$plural= new categorias_$plural();\n
$"."".$plural."->select($"."$camposcat[0]);
";

foreach ($campos_sin_key as $key => $value) {
	$formupdate .= "$"."$plural->$value = $"."$value;\n";
}
$formupdate .= "$"."".$plural."->update($"."$camposcat[0]);


echo '<div class=\"notify\"><p>$singular actualizada!</p><p><a href=\"v_categorias_$plural.php\">Regresar</a></p></div>';

?>";

$fp = fopen("layout-control/base_admin1.php","r"); 
$base1 = fread($fp,90000); 
$fp2 = fopen("layout-control/base_admin2.php","r"); 
$base2 = fread($fp2,90000); 

$fileupdate = fopen("./proyectos/".$proyecto."/control/".$plural."/u_categoria_".$singular.".php", "w+");
fwrite($fileupdate, $base1.$formupdate.$base2);


/*************************************/
/************ ELIMINAR ***************/
/*************************************/
$inputs ="";
$campos_sin_key ="";
$formdelete="";
foreach ($camposcat as $key => $value) {
	if($key !=0){
		$campos_sin_key[]= $value;
	}
}

$formdelete = "<?php\n";


$formdelete .= "$"."id=$"."_GET['id'];\n";

$formdelete .= "if(!"."$"."_POST['confirm'] && $"."_POST['pulsado']){"."$"."msgpulsado ='<div class=\"notify\"><p>Debe marcar el campo de confirmacion para poder eliminar..</p></div>';}else{"."$"."msgpulsado=\"\";}
echo "."$"."msgpulsado;";



$formdelete .= "\n/* SELECT */
include_once(\"classes/class.categorias_$plural.php\");
$"."$plural= new categorias_$plural();
$"."".$plural."->select($"."id);\n";

foreach ($campos_sin_key as $key => $value) {
	$formdelete .= "$"."$value=$"."".$plural."->get"."$value();\n";

}



$formdelete .= "
if($"."_POST['confirm']){
$"."id=$"."_POST['id_".$singular."'];\n";





$formdelete .="
include_once(\"classes/class.categorias_$plural.php\");
$"."$plural= new categorias_$plural();
$"."".$plural."->select($"."id);
$"."".$plural."->delete($"."id);

echo '<div class=\"notify\"><p>Categoria, eliminada!</p><p><a href=\"v_categorias_$plural.php\">Regresar</a></p></div>';

}
else{
echo '<div class=\"dividerclean\"><form action=\"d_categoria_".$singular.".php?id='.$"."id.'\" class=\"formvalid\" method=\"post\">
		<fieldset>
			<legend><span>Eliminar Categoria</span></legend>
	
			<p>
				<label for=\"confirmacion\"></label>
				<p>Confirma Eliminar esta categoria? <input type=\"checkbox\" name=\"confirm\" id=\"confirm\" class=\"checkbox\" /></p>
			</p> <input type=\"hidden\" name=\"id_".$singular."\" name=\"id_".$singular."\" value=\"'.$"."id.'\" />
			<input type=\"hidden\" name=\"pulsado\" value=\"1\" />
	
<p><button name=\"btnborrar\" class=\"button\">Aceptar</button> <button type=\"button\" class=\"button\" onClick=\"location.href=\'v_categorias_".$plural.".php\'\">Cancelar</button></p>
	
		</fieldset>
	</form></div>';\n
}";

$formdelete .= "?>";


$fp = fopen("layout-control/base_admin1.php","r"); 
$base1 = fread($fp,90000); 
$fp2 = fopen("layout-control/base_admin2.php","r"); 
$base2 = fread($fp2,90000); 

$filedelete = fopen("./proyectos/".$proyecto."/control/".$plural."/d_categoria_".$singular.".php", "w+");
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
$"."orden = \"$camposcat[0] DESC\";
}
if($"."orden==2){
$"."orden = \"$camposcat[0] ASC\";
}
if($"."orden==3){
$"."orden = \"$camposcat[0] ASC\";
}
if($"."orden==\"\"){
$"."orden = \"$camposcat[0] ASC\";
}

echo '<div class=\"menuorden\"><a href=\"v_$plural.php?orden=1\"><img src=\"../layout/btn-orden1.jpg\" alt=\"desc\"/></a><a href=\"v_$plural.php?orden=2\"><img src=\"../layout/btn-orden2.jpg\" alt=\"desc\"/></a></div>';
/* SELECT */
include_once(\"classes/class.categorias_$plural.php\");
$"."$plural= new categorias_$plural();
$"."".$plural."->select_all($"."pagina, $"."orden);

?>";

$fileviewall = fopen("./proyectos/".$proyecto."/control/".$plural."/v_categorias_$plural.php", "w+");
fwrite($fileviewall, $base1.$formviewall.$base2);

/*
/*************************************/
/********* HELPER TITULOS ************/
/*************************************/
/*
$formhelpertitulos ="<?php $"."singular ='$singular'; $"."plural='$plural'; ?>";

$filehelpertitulos = fopen("./proyectos/".$proyecto."/control/".$plural."/helper_titulos.php", "w+");
fwrite($filehelpertitulos,$formhelpertitulos);
*/
/*************************************/
/*********** MENU INTERNO ************/
/*************************************/
/*
$formmenu = " <li><a href=\"v_$plural.php\"> Ver $plural</a></li>";

$folder_inc = "./proyectos/".$proyecto."/control/".$plural."/inc/";
mkdir($folder_inc);


$filemenu = fopen("./proyectos/".$proyecto."/control/".$plural."/inc/menu_categorias_$plural.php", "w+");
fwrite($filemenu,$formmenu);
*/


?>

