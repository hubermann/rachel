<?php  
$clase = "<?php\ninclude_once(\"control/resources/class.database.php\");\n\nclass categorias_$plural{ \n\n/* ATTRIBUTE DECLARATION */\n";

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
include('control/resources/paginator.class.php');
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



#final de la clase categorias
$clase .="\n\n
} // class : end\n?>";

#fin clase categoria
$file="";
$file = fopen("./proyectos/".$proyecto."/classes_f/class.categorias_".$plural.".php", "w+");
fwrite($file, $clase);



?>