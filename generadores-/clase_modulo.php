<?php  $clase = "<?php\ninclude_once(\"../resources/class.database.php\");\n\nclass $plural{ \n\n/* ATTRIBUTE DECLARATION */\n";

#variables de la clase (campos)
foreach ($campos as $key => $value) {
	$clase .= "var $$value ;\n";
}
#si tiene varias imagenes
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

#si tiene varias imagenes
if($_POST['campo_img']){$clase .="$"."this->main_image = $"."row->main_image;\n";}

#si una sola imagen
if($_POST['require_image']){$clase .="$"."this->avatar = $"."row->avatar;\n";}


$clase .="}";
$clase .="
/* SELECT ALL */
function select_all($"."pagina, $"."orden){
include('../resources/paginator.class.php');
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
			$adicionalnombre_cat .= "include_once('classes/class.categorias_".$plural.".php'); 
			$"."namecat = new categorias_".$plural."();
			$"."namecat->select($"."id_categoria);
			$"."nombre_categoria = $"."namecat->getnombre();  ";
		}

	}

}
#si requiere una imagen
if($_POST['require_image']){$clase .= "$"."avatar = $"."row['avatar'];\n";}

if($_POST['campo_img']){$linkdetails ="<a href=\"details_$singular.php?id='.$"."$campos[0].'\">Detalle</a>";}else{$linkdetails="";}
#si necesito mostrar nombre de categoria en el detalle del item
$clase .="$adicionalnombre_cat";
$categoria_item ="<p><strong>Categoria: </strong> '.$"."nombre_categoria.'</p>";
if($_POST['require_image']){$img_item .= "<p><strong>Avatar: </strong> '.$"."avatar.'</p>";}
$clase.="
echo '<div class=\"divider\">
<div class=\"contentProduct\">
$categoria_item
$img_item
$detalle_item

<div class=\"productOptions\">
".$linkdetails."
<a href=\"e_$singular.php?id='.$"."$campos[0].'\">Editar</a>
<a href=\"d_$singular.php?id='.$"."$campos[0].'\">Borrar</a>
</p>
</div>
</div>
</div>';
}

echo '<div class=\"navigate\">';
echo $"."pages->display_pages();


 // Optional call which will display the page numbers after the results.
//$"."pages->display_jump_menu(); // Optional – displays the page jump menu
//echo $"."pages->display_items_per_page(); //Optional – displays the items per
//echo  $"."pages->current_page . ' of ' .$"."pages->num_pages.'';
echo '</div>';
}

}
";



#delete
$clase .= "\n/* DELETE */
function delete($"."id){
$"."sql = \"DELETE FROM $plural WHERE id_$singular = $"."id;\";
$"."result = $"."this->database->query($"."sql);
}";

#insert 

#si require una imagen
if($_POST['require_image']){$campo_una_imagen = " avatar,";}

$clase .= "\n\n/* INSERT */

function insert(){
$"."this->$campos[0] = \"\"; // clear key for autoincrement

$"."sql = \"INSERT INTO $plural (";

foreach ($campos as $key => $value) {
	if($key!=0){
	$list_campos .= " $value,";
	}
}
$list_campos .= $campo_una_imagen;
#remuevo ultima coma
$clase .= substr($list_campos, 0, -1);
$list_campos =NULL;
$clase .=") VALUES (";

#si require una imagen
if($_POST['require_image']){$campo_una_imagen = "'$"."this->avatar',";}

foreach ($campos as $key => $value) {
	if($key!=0){
	$list_campos .= " '$"."this->$value',";
	}
}
$list_campos .= $campo_una_imagen;
#remuevo ultima coma
$clase .= substr($list_campos, 0, -1);
$list_campos =NULL;
$clase .= ")\"; \n $"."result = $"."this->database->query($"."sql);
$"."this->$campos[0] = mysql_insert_id($"."this->database->link);
}";

$clase .="\n\n/* UPDATE */

function update($"."id){

$"."sql = \" UPDATE $plural SET  ";


foreach ($campos as $key => $value) {
	if($key!=0){
		$list_campos .= " $value = '$"."this->$value',";
	}
}

#si require una imagen
if($_POST['require_image']){$list_campos .= " avatar = '$"."this->avatar',";}


$clase .= substr($list_campos, 0, -1);
$list_campos =NULL;
$clase .= " WHERE $campos[0] = $"."id \"; \n $"."result = $"."this->database->query($"."sql);
}";

if($_POST['campo_img']){
$clase .="\n\n/* UPDATE AVATAR */

function update_avatar($"."id){

$"."sql = \" UPDATE $plural SET  ";



$clase .="main_image = '$"."this->main_image' WHERE id_".$singular." = $"."id \"; \n $"."result = $"."this->database->query($"."sql); \n}";


}


#final de la clase
$clase .="\n\n
} // class : end\n?>";



#fin clase

	$path_dir_classes_modulo = './proyectos/'.$proyecto.'/control/'.$plural.'/classes';
	mkdir($path_dir_classes_modulo);

	$file_classe_modulo = $path_dir_classes_modulo."/class." . $plural . ".php";
	$file_classe_modulo = fopen($file_classe_modulo, "w+");
	fwrite($file_classe_modulo, $clase);
?>
