<?php  

foreach($fields as $field){

		
$helperdoc .= "$field, ";

}





$file = fopen("helper.php", "w+");
fwrite($file, $helperdoc);



?>