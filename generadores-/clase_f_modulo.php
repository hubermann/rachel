<?php  $clase = "<?php\ninclude_once(\"control/resources/class.database.php\");\n\nclass $plural{ \n\n/* ATTRIBUTE DECLARATION */\n";

#variables
foreach ($campos as $key => $value) {
	$clase .= "var $$value ;\n";
}
#si tiene varias iamgenes
if($_POST['campo_img']){$clase .= "var $"."main_image;\n";}
#si tiene una sola imagen
if($_POST['require_image']){$clase .= "var $"."avatar;\n";}

#conexion
$clase .= "\nfunction $plural(){\n";
$clase .= "$"."this->database = new Database();\n}\n";

#get methods
$clase .= "\n/* GETTER METHODS */\n";
foreach ($campos as $key => $value) {
	$clase .= "function get$value(){return $"."this->$value;}\n";
}
#si tiene imagenes agrego campo para guardar la imagen por defecto
if($_POST['campo_img']){$clase .= "function getmain_image(){return $"."this->main_image;}\n";}

#si tiene una sola imagen agrego el campo para guardar el path de la imagen  (avatar)
if($_POST['require_image']){$clase .= "function getavatar(){return $"."this->avatar;}\n";}

#set methods
$clase .= "\n/* SETTER METHODS */\n";
foreach ($campos as $key => $value) {
	$clase .= "function set$value($"."val){ $"."this->$value =  $"."val;}\n";
}
#si tiene imagenes agrego campo para guardar la imagen por defecto
if($_POST['campo_img']){$clase .= "function setmain_image($"."val){ $"."this->main_image =  $"."val;}\n";}

#si tiene una sola imagen agrego campo para guardar path de la iamgen
if($_POST['require_image']){$clase .= "function setavatar($"."val){ $"."this->avatar =  $"."val;}\n";}
		
		
$clase .= "\n/* SELECT METHOD / LOAD */\nfunction select($"."id){\n";

$clase .= "$"."sql =  \"SELECT * FROM $plural WHERE ".$campos[0]." = $"."id;\";\n";

$clase .= "$"."result =  $"."this->database->query($"."sql);\n";
$clase .= "$"."result = $"."this->database->result;\n";
$clase .= "$"."row = mysql_fetch_object($"."result);\n";

foreach ($campos as $key => $value) {

	$clase .="$"."this->$value = $"."row->$value;\n";
}
#varias imagens
if($_POST['campo_img']){$clase .="$"."this->main_image = $"."row->main_image;\n";}
#una imagen
if($_POST['require_image']){$clase .="$"."this->avatar = $"."row->avatar;\n";}
$clase .="}";
$clase .="
/* SELECT ALL */
function select_all($"."pagina, $"."orden){
include('control/resources/paginator.class.php');
$"."sql =\"SELECT * FROM $plural ;\";
$"."result = $"."this->database->query($"."sql);
$"."result = $"."this->database->result;
$"."quantity= mysql_num_rows($"."result);
		if($"."quantity < 1)
		{echo '<div class=\"notify\">
			<p>No hay $singular en el sistema!</p>
		</div>';}
		else{
$"."count=0;
while($"."row = mysql_fetch_array($"."result)){
$"."count++;
}

$"."pages = new Paginator;
$"."pages->items_total = $"."count;
$"."pages->mid_range = 10;
$"."pages->paginate();
$"."pages->display_pages();

"."$"."sql =\"SELECT * FROM $plural ORDER BY $"."orden $"."pages->limit;\";
"."$"."result = "."$"."this->"."database"."->"."query($"."sql);
";
$clase .="$"."result = $"."this"."->"."database"."->"."result;
";
$clase .="while($"."row = mysql_fetch_array("."$"."result)){
";


foreach ($campos as $key => $value) {
	$clase .= "$"."$value = $"."row['$value'];\n";

	if($key!=0){
		if($value!="id_categoria"){
			$detalle_item .= "<p><strong>$value: </strong>'.$$value.'</p>\n";
		}else{
			#si necesito traer nombre de categoria
			$adicionalnombre_cat = "
			include_once('classes_f/class.categorias_".$plural.".php'); 
			$"."namecat = new categorias_".$plural."();
			$"."namecat->select($"."id_categoria);
			$"."nombre_categoria = $"."namecat->getnombre();  ";
		}

	}

}
#si una sola imagen
if($_POST['require_image']){$clase .="$"."avatar = $"."row['avatar'];\n";}

if($_POST['campo_img']){$linkdetails ="<a href=\"details_$singular.php?id='.$"."$campos[0].'\">Detalle</a>";}else{$linkdetails="";}
#si necesito mostrar nombre de categoria en el detalle del item
$clase .="$adicionalnombre_cat";
$categoria_item ="<p><strong>Categoria: </strong> '.$"."nombre_categoria.'</p>";
$clase.="
echo '
$categoria_item
$detalle_item

".$linkdetails."
<p><a href=\"$singular_detail.php?id='.$"."$campos[0].'\">VER + </a></p>


';
}

echo '<p>';
echo $"."pages->display_pages();


 // Optional call which will display the page numbers after the results.
//$"."pages->display_jump_menu(); // Optional – displays the page jump menu
//echo $"."pages->display_items_per_page(); //Optional – displays the items per
//echo  $"."pages->current_page . ' of ' .$"."pages->num_pages.'';
echo '</p>';
}

}
";






#final de la clase
$clase .="\n\n
} // class : end\n?>";



#fin clase
$file="";
$file = fopen("./proyectos/".$proyecto."/classes_f/class.".$plural.".php", "w+");
fwrite($file, $clase);
?>
