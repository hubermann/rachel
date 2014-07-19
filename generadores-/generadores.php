<?php


/**************************************************************************/
/**************************** Clase modulo ********************************/
/**************************************************************************/

function gen_class_modulo($proyecto, $plural, $singular,$campos,$imagenes){

$clase = "<?php\ninclude_once(\"../resources/class.database.php\");\n\nclass $plural{ \n\n/* ATTRIBUTE DECLARATION */\n";

#variables
foreach ($campos as $key => $value) {
	$clase .= "var $$value ;\n";
}

$clase .= "\nfunction $plural(){\n";
$clase .= "$"."this->database = new Database();\n}\n";

#get methods
$clase .= "\n/* GETTER METHODS */\n";
foreach ($campos as $key => $value) {
	$clase .= "function get$value(){return $"."this->$value;}\n";
}
#set methods
$clase .= "\n/* SETTER METHODS */\n";
foreach ($campos as $key => $value) {
	$clase .= "function set$value($"."val){ $"."this->$value =  $"."val;}\n";
}


$clase .= "\n/* SELECT METHOD / LOAD */\nfunction select($"."id){\n";

$clase .= "$"."sql =  \"SELECT * FROM $plural WHERE ".$campos[0]." = $"."id;\";\n";

$clase .= "$"."result =  $"."this->database->query($"."sql);\n";
$clase .= "$"."result = $"."this->database->result;\n";
$clase .= "$"."row = mysql_fetch_object($"."result);\n";

foreach ($campos as $key => $value) {
	$clase .="$"."this->$value = $"."row->$value;\n";
}

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
}

if($imagenes=="1"){$linkdetails ="<a href=\"details_$singular.php?id='.$"."$campos[0].'\">Detalle</a>";}else{$linkdetails="DDDDDDDDDDDD".$imagenes;}

$clase.="
echo '<div class=\"divider\">
<div class=\"contentProduct\">

<h4>[ Poner aca titulo o nombre ]</h4>
<p><strong>Descripcion: </strong><p></p>[ poner aca descripcion u otro campo ]</p>

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
$clase .= "\n\n/* INSERT */

function insert(){
$"."this->$campos[0] = \"\"; // clear key for autoincrement

$"."sql = \"INSERT INTO $plural (";

foreach ($campos as $key => $value) {
	if($key!=0){
	$list_campos .= " $value,";
	}
}
#remuevo ultima coma
$clase .= substr($list_campos, 0, -1);
$list_campos =NULL;
$clase .=") VALUES (";

foreach ($campos as $key => $value) {
	if($key!=0){
	$list_campos .= " '$"."this->$value',";
	}
}
#remuevo ultima coma
$clase .= substr($list_campos, 0, -1);
$list_campos =NULL;
$clase .= ")\"; \n $"."result = $"."this->database->query($"."sql);
$"."this->$campos[0] = mysql_insert_id($"."this->database->link);
}";

$clase .="\n\n/* UPDATE */

function update($"."id){

$"."sql = \" UPDATE $plural SET  ";

#id_lenguaje = '$this->id_lenguaje',titulo = '$this->titulo',descripcion = '$this->descripcion',slug = '$this->slug',link = '$this->link'  ";

foreach ($campos as $key => $value) {
	if($key!=0){
		$list_campos .= " $value = '$"."this->$value',";
	}
}
$clase .= substr($list_campos, 0, -1);
$list_campos =NULL;
$clase .= "WHERE $campos[0] = $"."id \"; \n $"."result = $"."this->database->query($"."sql);
}";


#final de la clase
$clase .="\n\n
} // class : end\n?>";



#fin clase

	$path_dir_classes_modulo = './proyectos/'.$proyecto.'/control/'.$plural.'/classes';
	mkdir($path_dir_classes_modulo);

	$file_classe_modulo = $path_dir_classes_modulo."/class." . $plural . ".php";
	$file_classe_modulo = fopen($file_classe_modulo, "w+");
	fwrite($file_classe_modulo, $clase);




}//end function



/**************************************************************************/
/**************************** Categorias **********************************/
/**************************************************************************/



#categorias
function gen_class_cat_modulo($proyecto, $plural, $singular,$campos){

$clase = "<?php\ninclude_once(\"../resources/class.database.php\");\n\nclass categorias_$plural{ \n\n/* ATTRIBUTE DECLARATION */\n";

#variables
foreach ($campos as $key => $value) {
	$clase .= "var $$value \n";
}

$clase .= "\nfunction $plural(){\n";
$clase .= "$"."this->database = new Database();\n}\n";

#get methods
$clase .= "\n/* GETTER METHODS */\n";
foreach ($campos as $key => $value) {
	$clase .= "function get$value(){return $"."this->$value;}\n";
}
#set methods
$clase .= "\n/* SETTER METHODS */\n";
foreach ($campos as $key => $value) {
	$clase .= "function set$value($"."val){ $"."this->$value =  $"."val;}\n";
}


$clase .= "\n/* SELECT METHOD / LOAD */\nfunction select($"."id){\n";

$clase .= "$"."sql =  \"SELECT * FROM categorias_$plural WHERE ".$campos[0]." = $"."id;\";\n";

$clase .= "$"."result =  $"."this->database->query($"."sql);\n";
$clase .= "$"."result = $"."this->database->result;\n";
$clase .= "$"."row = mysql_fetch_object($"."result);\n";

foreach ($campos as $key => $value) {
	$clase .="$"."this->$value = $"."row->$value;\n";
}
$clase .="}";

$clase .="
/* SELECT ALL */
function select_all($"."pagina, $"."orden){
include('../resources/paginator.class.php');
$"."sql =\"SELECT * FROM $table ;\";
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

"."$"."sql =\"SELECT * FROM $table ORDER BY $"."orden $"."pages->limit;\";
"."$"."result = "."$"."this->"."database"."->"."query($"."sql);
";
$clase .="$"."result = $"."this"."->"."database"."->"."result;
";
$clase .="while($"."row = mysql_fetch_array("."$"."result)){
";

$clase .= "\n/* GETTER METHODS */\n";
foreach ($campos as $key => $value) {
	$clase .= "$"."$value = $"."row['$value'];\n";
}



$clase.="
echo '<div class=\"item\">

<h4>[ Poner aca titulo o nombre ]</h4>
<p><strong>Descripcion: </strong><p></p>[ poner aca descripcion u otro campo ]</p>

<p>
<a href=\"e_$singular.php?id='.$"."$campos[0].'\">Editar</a>
<a href=\"d_$singular.php?id='.$"."$campos[0].'\">Borrar</a>
</p>

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


$clase .="
/* SELECT DROP LIST */
function ".$plural."_drop_list($"."id_selected){

"."$"."sql =\"SELECT * FROM categorias_$plural ;\";
"."$"."result = "."$"."this->"."database"."->"."query($"."sql);
";
$clase .="$"."result = $"."this"."->"."database"."->"."result;
";
$clase .="while($"."row = mysql_fetch_array("."$"."result)){
";

$clase .="$"."id= "."$"."row['".$campos[0]."'];
";
$clase .="$"."name= "."$"."row['".$campos[1]."'];\n";

$clase .= 'if($id == $id_selected){$selected="selected";}else{$selected="";}';

$clase .="\necho '<option value=\"'.$"."id.'\" $"."selected>'.$"."name.'</option>';";

$clase .="
}\n}
";

#delete
$clase .= "/* DELETE */
function delete($"."id){
$"."sql = \"DELETE FROM categorias_$plural WHERE id_categoria_$plural = $"."id;\";
$"."result = $"."this->database->query($"."sql);

}";


#insert 
$clase .= "\n\n/* INSERT */

function insert(){
$"."this->$campos[0] = \"\"; // clear key for autoincrement

$"."sql = \"INSERT INTO categorias_$plural (";

foreach ($campos as $key => $value) {
	if($key!=0){
	$list_campos .= " $value,";
	}
}
#remuevo ultima coma
$clase .= substr($list_campos, 0, -1);
$list_campos =NULL;
$clase .=") VALUES (";

foreach ($campos as $key => $value) {
	if($key!=0){
	$list_campos .= " '$"."this->$value',";
	}
}
#remuevo ultima coma
$clase .= substr($list_campos, 0, -1);
$list_campos =NULL;
$clase .= ")\"; \n $"."result = $"."this->database->query($"."sql);
$"."this->$campos[0] = mysql_insert_id($"."this->database->link);

}";

$clase .="\n\n/* UPDATE */

function update($"."id){

$"."sql = \" UPDATE categorias_$plural SET  ";

#id_lenguaje = '$this->id_lenguaje',titulo = '$this->titulo',descripcion = '$this->descripcion',slug = '$this->slug',link = '$this->link'  ";

foreach ($campos as $key => $value) {
	if($key!=0){
		$list_campos .= " $value = '$"."this->$value',";
	}
}
$clase .= substr($list_campos, 0, -1);
$list_campos =NULL;
$clase .= "WHERE $campos[0] = $"."id \"; \n $"."result = $"."this->database->query($"."sql);

}";

#final de la clase categorias
$clase .="\n\n
} // class : end\n?>";

#fin clase categoria

	$path_dir_classes_modulo = './proyectos/'.$proyecto.'/control/'.$plural.'/classes';
	mkdir($path_dir_classes_modulo);

	$file_classe_modulo = $path_dir_classes_modulo."/class.categorias_" . $plural . ".php";
	$file_classe_modulo = fopen($file_classe_modulo, "w+");
	fwrite($file_classe_modulo, $clase);




}//end function

?>
