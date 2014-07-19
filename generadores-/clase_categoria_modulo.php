<?php  
$clase = "<?php\ninclude_once(\"../resources/class.database.php\");\n\nclass categorias_$plural{ \n\n/* ATTRIBUTE DECLARATION */\n";

#variables
$key="";
$value="";
foreach ($camposcat as $key => $value) {
	$clase .= "var $$value ;\n";
}

$clase .= "\nfunction categorias_$plural(){\n";
$clase .= "$"."this->database = new Database();\n}\n";

#get methods
$clase .= "\n/* GETTER METHODS */\n";

$key="";
$value="";
foreach ($camposcat as $key => $value) {
	$clase .= "function get$value(){return $"."this->$value;}\n";
}
#set methods
$clase .= "\n/* SETTER METHODS */\n";

$key="";
$value="";
foreach ($camposcat as $key => $value) {
	$clase .= "function set$value($"."val){ $"."this->$value =  $"."val;}\n";
}


$clase .= "\n/* SELECT METHOD / LOAD */\nfunction select($"."id){\n";

$clase .= "$"."sql =  \"SELECT * FROM categorias_$plural WHERE $camposcat[0] = $"."id;\";\n";

$clase .= "$"."result =  $"."this->database->query($"."sql);\n";
$clase .= "$"."result = $"."this->database->result;\n";
$clase .= "$"."row = mysql_fetch_object($"."result);\n";

$key="";
$value="";
foreach ($camposcat as $key => $value) {
	$clase .="$"."this->$value = $"."row->$value;\n";
}
$clase .="}";

$clase .="
/* SELECT ALL */
function select_all($"."pagina, $"."orden){
include('../resources/paginator.class.php');
$"."sql =\"SELECT * FROM categorias_$plural ;\";
$"."result = $"."this->database->query($"."sql);
$"."result = $"."this->database->result;
$"."quantity= mysql_num_rows($"."result);
		if($"."quantity < 1)
		{echo '<div class=\"notify\">
			<p>No hay categorias en el sistema!</p>
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

"."$"."sql =\"SELECT * FROM categorias_$plural ORDER BY $"."orden $"."pages->limit;\";
"."$"."result = "."$"."this->"."database"."->"."query($"."sql);
";
$clase .="$"."result = $"."this"."->"."database"."->"."result;
";
$clase .="while($"."row = mysql_fetch_array("."$"."result)){
";

$key="";
$value="";
$detalle_item="";
foreach ($camposcat as $key => $value) {
	$clase .= "$"."$value = $"."row['$value'];\n";

	if($key!=0){

			$detalle_item .= "<p><strong>$value: </strong>'.$$value.'</p>\n";
		

	}

}


$clase.="
echo '<div class=\"divider\">
<div class=\"contentProduct\">
$detalle_item

<div class=\"productOptions\">

<a href=\"e_categoria_$singular.php?id='.$"."$camposcat[0].'\">Editar</a>
<a href=\"d_categoria_$singular.php?id='.$"."$camposcat[0].'\">Borrar</a>
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



$clase .="
/* SELECT DROP LIST */
function categorias_".$singular."_drop_list($"."id_selected){

"."$"."sql =\"SELECT * FROM categorias_$plural ;\";
"."$"."result = "."$"."this->"."database"."->"."query($"."sql);
";
$clase .="$"."result = $"."this"."->"."database"."->"."result;
";
$clase .="while($"."row = mysql_fetch_array("."$"."result)){
";

$clase .="$"."id= "."$"."row['".$camposcat[0]."'];
";
$clase .="$"."name= "."$"."row['".$camposcat[1]."'];\n";

$clase .= 'if($id == $id_selected){$selected="selected";}else{$selected="";}';

$clase .="\necho '<option value=\"'.$"."id.'\" '.$"."selected.'>'.$"."name.'</option>';";

$clase .="
}\n}
";

#delete
$clase .= "/* DELETE */
function delete($"."id){
$"."sql = \"DELETE FROM categorias_$plural WHERE $camposcat[0] = $"."id;\";
$"."result = $"."this->database->query($"."sql);

}";


#insert 
$clase .= "\n\n/* INSERT */

function insert(){
$"."this->$camposcat[0] = \"\"; // clear key for autoincrement

$"."sql = \"INSERT INTO categorias_$plural (";

$key="";
$value="";
$list_campos="";
foreach ($camposcat as $key => $value) {
	if($key!=0){
	$list_campos .= " $value,";
	}
}
#remuevo ultima coma
$clase .= substr($list_campos, 0, -1);
$list_campos =NULL;
$clase .=") VALUES (";
$key="";
$value="";
$list_campos="";
foreach ($camposcat as $key => $value) {
	if($key!=0){
	$list_campos .= " '$"."this->$value',";
	}
}
#remuevo ultima coma
$clase .= substr($list_campos, 0, -1);
$list_campos =NULL;
$clase .= ")\"; \n $"."result = $"."this->database->query($"."sql);
$"."this->$camposcat[0] = mysql_insert_id($"."this->database->link);

}";

$clase .="\n\n/* UPDATE */

function update($"."id){

$"."sql = \" UPDATE categorias_$plural SET  ";

#id_lenguaje = '$this->id_lenguaje',titulo = '$this->titulo',descripcion = '$this->descripcion',slug = '$this->slug',link = '$this->link'  ";
$key="";
$value="";
$list_campos="";
foreach ($camposcat as $key => $value) {
	if($key!=0){
		$list_campos .= " $value = '$"."this->$value',";
	}
}
$clase .= substr($list_campos, 0, -1);
$list_campos =NULL;
$clase .= " WHERE $camposcat[0] = $"."id \"; \n $"."result = $"."this->database->query($"."sql);

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
?>