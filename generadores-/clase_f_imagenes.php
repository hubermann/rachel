<?php 

foreach ($camposimg as $key => $value) {
	if($key !=0){
	echo ':::'.$key.''.$value;
	}
}

$claseimagenes = "<?php

include_once(\"control/resources/class.database.php\");

/* CLASS DECLARATION */


class imagenes_$plural{ 
// class : begin
/* ATTRIBUTES DECLARATION */
\n";


foreach ($camposimg as $key => $value) {
	$claseimagenes .= "var $$value;   // (Attribute)\n";
}

$claseimagenes .= "

var $"."database; // Instance of class database


/* CONSTRUCTOR METHOD */

function imagenes_$plural(){

$"."this->database = new Database();

}\n /* GETTER METHODS */\n";


foreach ($camposimg as $key => $value) {
	$claseimagenes .= "function get$value(){return $"."this->$value;}\n";
}

$claseimagenes .= "\n /* SETTER METHODS */\n";

foreach ($camposimg as $key => $value) {
	$claseimagenes .= "function set".$value."($"."val){"."$"."this->$value =  $"."val;}\n";
}


$claseimagenes .= "
/* SELECT METHOD / LOAD */
function select($"."id){
$"."sql =  \"SELECT * FROM imagenes_$plural WHERE id_imagen_$singular = $"."id;\";
$"."result =  $"."this->database->query($"."sql);
$"."result = $"."this->database->result;
$"."row = mysql_fetch_object($"."result);\n";
foreach ($camposimg as $key => $value) {
	$claseimagenes .= "$"."this->$value = $"."row->$value;\n";
}


$claseimagenes .= "}";

$claseimagenes .="\n\nfunction bring_images($"."id_$singular){
$"."sql =  \"SELECT * FROM imagenes_$plural WHERE id_$singular = $"."id_$singular;\";
$"."result =  $"."this->database->query($"."sql);
$"."result = $"."this->database->result;
while($"."row = mysql_fetch_array($"."result)){
\n";

$claseimagenes .= "$$camposimg[0][] = $"."row['$camposimg[0]'];\n";

$claseimagenes .="
}
return $$camposimg[0];
}";






#final de la clase
$claseimagenes .="}\n?>";

$file="";
$file = fopen("./proyectos/".$proyecto."/classes_f/class.imagenes_".$plural.".php", "w+");
fwrite($file, $claseimagenes);


?>