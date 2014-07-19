<?php 

$datamenuadd .="<li><a href=\"v_categorias_$plural.php\">Ver categorias</a></li><li><a href=\"n_categoria_$singular.php\">Nueva categoria</a></li>";



$menuadd = fopen("./proyectos/".$proyecto."/control/".$plural."/inc/menu_adicionales.php", "w+");
fwrite($menuadd, $datamenuadd);

?>
