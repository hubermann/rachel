<?php 
$listfront = "
<?php
 
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

echo '<p><a href=\"list.php?orden=1\"><img src=\"control/layout/btn-orden1.jpg\" alt=\"desc\"/></a><a href=\"$plural_list.php?orden=2\"><img src=\"control/layout/btn-orden2.jpg\" alt=\"desc\"/></a></p>';
/* SELECT */
include_once(\"classes_f/class.$plural.php\");
$".$plural."= new $plural();
$".$plural."->select_all($"."pagina, $"."orden);

?>

";


$filelist = fopen("./proyectos/".$proyecto."/$plural_list.php", "w+");
fwrite($filelist, $listfront);



$filedetail = "
<?php 
$"."id=$"."_GET['id'];

include_once(\"classes_f/class.$plural.php\");
$".$plural."= new $plural();
$".$plural."->select($"."id);";

foreach ($campos as $key => $value) {
	$filedetail .="echo '<br />'.$".$value."=$".$plural."->get$value();\n";
}


$filedetail .="
?>
<p><a href=\"$plural_list.php\">Regresar</a> </p>
";
$filedetailfront = fopen("./proyectos/".$proyecto."/$singular_detail.php", "w+");
fwrite($filedetailfront, $filedetail);



?>

