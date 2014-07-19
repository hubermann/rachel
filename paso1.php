<?php error_reporting(0); ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!--<link rel="stylesheet" type="text/css" media="all" href="assets/base.css" />-->
	

	<!-- charset -->
	<meta charset="utf-8">
	<!-- Mobile Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<!-- Description -->
	<meta name="description" content="">

<style type="text/css">
	body{width:500px; margin:0 auto; font-family:arial; font-size:.8em}
	form, label{width:500px; float:left; margin-top:10px;}
	input{padding:2px 3px;}
	label{font-weight:bold;}
	button{margin-top:15px; float:right}
	span{width:120px; float:left; margin:5px; display:block}
	.link{float:left; background:#222; padding:3px 5px;color:#fff; cursor: pointer;}
	.row{width:100%; float:left;}
	select{width:120px;}

</style>

<script type="text/javascript" src="base_admin/jquery.1.6.js"></script>


<script type="text/javascript">
	var valinput = 1;
	function agregar_campo(){
		valinput++;

		variable = "<p><span>Campo</span><span>tipo</span><span>longitud</span></p><p><input type=\"text\" name=\"campo["+valinput+"]\"><select name=\"campo_tipo["+valinput+"]\" id=\"\"><option value=\"1\">varchar</option><option value=\"2\">int</option><option value=\"3\">text</option><option value=\"4\">date</option></select><input type=\"text\" name=\"longitud["+valinput+"]\" id=\"\"></p>";
		$('#campos').append(variable);
	}

	var valinputcat = 1;
	function agregar_campo_categoria(){
		valinputcat++;

		variablecat = "<p><span>Campo</span><span>tipo</span><span>longitud</span></p><p><input type=\"text\" name=\"campo_cat["+valinputcat+"]\"><select name=\"campo_tipo_cat["+valinputcat+"]\" id=\"\"><option value=\"1\">varchar</option><option value=\"2\">int</option><option value=\"3\">text</option><option value=\"4\">date</option></select><input type=\"text\" name=\"longitud_cat["+valinputcat+"]\" id=\"\"></p>";
		$('#campos_categoria').append(variablecat);
	}

	var valinputimg = 2;
	function agregar_campo_imagen(){
		valinputimg++;

		variableimg = "<p><span>Campo</span><span>tipo</span><span>longitud</span></p><p><input type=\"text\" name=\"campo_img["+valinputimg+"]\"><select name=\"campo_tipo_img["+valinputimg+"]\" id=\"\"><option value=\"1\">varchar</option><option value=\"2\">int</option><option value=\"3\">text</option><option value=\"4\">date</option></select><input type=\"text\" name=\"longitud_img["+valinputimg+"]\" id=\"\"></p>";
		$('#campos_imagenes').append(variableimg);
	}

</script>
</head>
<body>
<div class="block">
	<header>
		
		
	</header>
</div>


<div class="block">

<h3>Standares para nombres</h3>
<p><strong>Archivos:</strong> file</p>
<p><strong>Imagenes:</strong> imagefile</p>
<p><strong>slugs:</strong> slug</p>
<hr>
	<?php 

	$proyecto_inicial = $_POST['proyecto'];
	$singular = $_POST['singular'];
	$plural = $_POST['plural'];
	$imagen = $_POST['imagen'];
	$imagenes = $_POST['imagenes'];
	$categoria = $_POST['categoria'];



	if($proyecto_inicial==""){$proyecto_inicial="vacio";}

	if($categoria!=""){echo 'Hay que crear categorias!';}

	$proyecto = str_replace(" ", "-", $proyecto_inicial);

	


echo '<h3>Proyecto: '.$proyecto_inicial.' (nombre carpeta: '.$proyecto.')</h3>
<p><strong>Nombres en singular: </strong> '.$singular.'</p>
<p><strong>Nombres en plural: </strong> '.$plural.'</p>';



/********   verifico si el proyecto existe o no y creo la estructura inicial ********/
	if(@chdir('./proyectos/'.$proyecto)){ 
   echo '<p>Este modulo se creara en un proyecto existente</p>'; 

   #verifico si el modulo existe en este proyecto.
  if(@chdir('./'.$plural)){ 
  	echo 'Modulo existente.';
  }else{
  	$path = './'.$plural.'/';
	
		mkdir($path);
		
  }
 	#creo carpeta coontrol y lo necesario del admin
  


	}else{ 
	echo '<p>Este modulo se creara en un proyecto nuevo</p>';  
	#mkdir('./proyectos/'.$proyecto.'/classes_f');
	mkdir('./proyectos/'.$proyecto);
	mkdir('./proyectos/'.$proyecto.'/controllers');
	mkdir('./proyectos/'.$proyecto.'/models');
	mkdir('./proyectos/'.$proyecto.'/controllers/control');
	
	
	//carpeta para vistas del proyecto
	mkdir('./proyectos/'.$proyecto.'/control');
		//copio archivos basicos del backend
		$destino = './proyectos/'.$proyecto.'/control';
		if (is_dir('./base_admin/control/')) {
			$origen_path = './base_admin/control';
			if ($origen = opendir('./base_admin/control')) {
			while ($file = readdir($origen)) {
				if ($file != '.' && $file != '..' && $file != '.DS_Store'){
					copy($origen_path.'/'.$file, $destino.'/'.$file);
				}
		}
		//close folder
		closedir($origen);
		}
		$origen="";
		}
	
	
	
	
	
	
	
	#controller Backend
	include_once('generadores/gen_dashboard.php');
	#Model Admin
	include_once('generadores/gen_model_admin.php');
	
	
   if($imagenes=="on"){mkdir('./proyectos/'.$proyecto.'/images-'.$plural);}
   #mkdir('./proyectos/'.$proyecto.'/control');
   
   
   /*
   #RESOURCES
   #mkdir('./proyectos/'.$proyecto.'/control/resources');
   $destino = './proyectos/'.$proyecto.'/control/resources';
	if (is_dir('./base_admin/resources/')) {
		$origen_path = 'base_admin/resources';
		if ($origen = opendir('./base_admin/resources/')) {
		while ($file = readdir($origen)) {
			if ($file != '.' && $file != '..' && $file != '.DS_Store'){
				copy($origen_path.'/'.$file, $destino.'/'.$file);
			}
	}
	//close folder
	closedir($origen);
	}
	$origen="";
	}
	
	*/
	
	/*
	#LAYOUT
	mkdir('./proyectos/'.$proyecto.'/control/layout');
	$destino = './proyectos/'.$proyecto.'/control/layout';
	if (is_dir('./base_admin/layout/')) {
		$origen_path = 'base_admin/layout';
		if ($origen = opendir('./base_admin/layout/')) {
		while ($file = readdir($origen)) {
			if ($file != '.' && $file != '..' && $file != '.DS_Store'){
				copy($origen_path.'/'.$file, $destino.'/'.$file);
			}
	}
	//close folder
	closedir($origen);
	}
	$origen="";
	}

	#JS
  */
  /*
  mkdir('./proyectos/'.$proyecto.'/control/js');
  $destino = './proyectos/'.$proyecto.'/control/js';
	if (is_dir('./base_admin/js/')) {
		$origen_path = 'base_admin/js';
		if ($origen = opendir('./base_admin/js/')) {
		while ($file = readdir($origen)) {
			if ($file != '.' && $file != '..' && $file != '.DS_Store'){
				copy($origen_path.'/'.$file, $destino.'/'.$file);
			}
	}
	//close folder
	closedir($origen);
	}
	$origen="";
	}
	
	*/
	
	/*
	#INC
	mkdir('./proyectos/'.$proyecto.'/control/inc');
	$destino = './proyectos/'.$proyecto.'/control/inc';
	if (is_dir('./base_admin/inc/')) {
		$origen_path = 'base_admin/inc';
		if ($origen = opendir('./base_admin/inc')) {
		while ($file = readdir($origen)) {
			if ($file != '.' && $file != '..' && $file != '.DS_Store'){
				#echo '<p>File:'.$origen.'/'.$file.' --->'. $destino.'/'.$file.'</p>';
				copy($origen_path.'/'.$file, $destino.'/'.$file);
			}
	}
	//close folder
	closedir($origen);
	}
	$origen="";
	}
  */
  
  /*
	#ARCHIVOS SIMPLES
	$destino = './proyectos/'.$proyecto.'/control';
	if (is_dir('./base_admin')) {
		$origen_path = 'base_admin';
		if ($origen = opendir('./base_admin/inc')) {
		while ($file = readdir($origen)) {
			if ($file != '.' && $file != '..' && $file != '.DS_Store'){
			
				copy($origen_path.'/index.php', $destino.'/index.php');
				copy($origen_path.'/secure.php', $destino.'/secure.php');
				copy($origen_path.'/logout.php', $destino.'/logout.php');
				copy($origen_path.'/verification.php', $destino.'/verification.php');
			}
	}

#archivo verificacion de login
$verifile = "<?php session_start(); ob_start('ob_gzhandler'); 
if(!$"."_SESSION['admin_logged']){
header('Location:http://'.$"."_SERVER['HTTP_HOST'].'/control/index.php');
}
else{
header('Location:http://'.$"."_SERVER['HTTP_HOST'].'/control/$plural/v_$plural.php');
}
?>";
#$buscar = "/control/$plural/";
#$resultado = strpos($readmenu, $buscar);

#if($resultado == FALSE){
#$menuupdate = str_replace("<!-- additem-->", $nuevoitem."<!-- additem-->", $readmenu);
	#$path = fopen("./proyectos/".$proyecto."/control/secure.php","w+");
	#fwrite($path, $verifile);
#}



	//close folder
	closedir($origen);
	}
	$origen="";
	}

	#CARPETAS DEL PROYECTO
	
	$path = './proyectos/'.$proyecto.'/control/'.$plural;
	mkdir($path);
	$path = './proyectos/'.$proyecto.'/classes_f';
	mkdir($path);

*/

	#archivo migracion 
	$migracion_admin ="--\n-- Table structure for table `admin`\n--\n\n
CREATE TABLE `admin` ( 
  `id_admin` int(11) NOT NULL AUTO_INCREMENT, 
  `name_admin` varchar(30) NOT NULL, 
  `pass_admin` varchar(20) NOT NULL, 
  PRIMARY KEY (`id_admin`) \n
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;\n
	
	INSERT INTO `admin` VALUES(1, 'admin', 'admin'); \n "; 

	$migration=fopen('proyectos/'.$proyecto.'/migracion.txt',"w+");
	fputs($migration,$migracion_admin);
   
	}//fin else proyecto nuevo

	

	

	#$migracion_adicional = "\n Este es un agregado :)";
	#$migration=fopen("migracion.txt","a+");
	#fputs($migration,$migracion_adicional);

	#crear archivo index.php vacio en classes_f 


	?>
<form action="paso2.php" method="post" >
	<div id="campos">
	<h3><?php echo $plural; ?></h3>
	<p><span>campo</span><span>tipo</span><span>longitud</span> </p>
	<input type="hidden" name="singular" value="<?php echo $singular; ?>">
	<input type="hidden" name="plural" value="<?php echo $plural; ?>">
	<input type="hidden" name="proyecto" value="<?php echo $proyecto; ?>">
	<p><input type="text" name="campo[0]" value="<?php echo 'id'; ?>">
	<select name="campo_tipo[0]" id="">
		<option value="1">varchar</option>
		<option value="2" selected="selected">int</option>
		<option value="3">text</option>
		<option value="4">date</option>
	</select>
	<input type="text" name="longitud[0]" id="" value="11"> (* key - auto++)</p>
	
	<!-- si lleva imagen agrego el campo avatar a la tabla singular -->
	<?php if($imagen!=""){ ?>
		<input type="hidden" name="require_image" value="1">
	<?php } ?>



	<!-- si lleva categoria creo el campo dentro de la tablas -->
	<?php if($categoria!=""){ ?>
	<p><input type="text" name="campo[1]" value="categoria_id">
	<select name="campo_tipo[1]" id="">
		<option value="1">varchar</option>
		<option value="2" selected="selected">int</option>
		<option value="3">text</option>
		<option value="4">date</option>
	</select>
	<input type="text" name="longitud[1]" id="" value="11"> (* key - auto++)</p>
	
	<?php }?>
	</div>
	<div class="row">
		<p class="link" onclick="agregar_campo()">+ campos a <?php echo $plural; ?></p>
	</div>
	
	<!-- si lleva categoria muestro opciones para crear la tabla de categoria -->
	<?php if($categoria!=""){ ?>
	<div id="campos_categoria">
		<h3>Categorias</h3>
		<p><input type="text" name="campo_cat[0]" value="<?php echo $singular.'_categoria_id'; ?>">
	<select name="campo_tipo_cat[0]" id="">
		<option value="1">varchar</option>
		<option value="2" selected="selected">int</option>
		<option value="3">text</option>
		<option value="4">date</option>
	</select>
	<input type="text" name="longitud_cat[0]" id="" value="11"> (* key - autoincrement)</p>

	<p><input type="text" name="campo_cat[1]" value="nombre">
	<select name="campo_tipo_cat[1]" id="">
		<option value="1" selected="selected">varchar</option>
		<option value="2" >int</option>
		<option value="3">text</option>
		<option value="4">date</option>
	</select>
	<input type="text" name="longitud_cat[1]" id="" value="40"></p>
	<p>Campo: nombre - Tipo: varchar - Long: 11</p>

	</div>

	<div class="row">
		<p class="link" onclick="agregar_campo_categoria()">+ campos a categoria</p>
	</div>
		<?php } ?>




		<!-- si lleva imagens muestro opciones para crear la tabla de imagenes -->
	<?php if($imagenes!=""){ ?>
		<div id="campos_imagenes">
			<h3>Imagenes</h3>
			<!-- ID -->
			<p><input type="text" name="campo_img[0]" value="<?php echo 'id_imagen_'.$singular; ?>">
		<select name="campo_tipo_img[0]" id="">
			<option value="1">varchar</option>
			<option value="2" selected="selected">int</option>
			<option value="3">text</option>
			<option value="4">date</option>
		</select>
		<input type="text" name="longitud_img[0]" id="" value="11"> (* key - autoincrement)</p>
		<!-- TITULO -->
		<p><input type="text" name="campo_img[1]" value="titulo">
		<select name="campo_tipo_img[1]" id="">
			<option value="1" selected="selected">varchar</option>
			<option value="2" >int</option>
			<option value="3">text</option>
			<option value="4">date</option>
		</select>
		<input type="text" name="longitud_img[1]" id="" value="60"></p>

		<!-- ARCHIVO -->
			<p><input type="text" name="campo_img[2]" value="filename">
		<select name="campo_tipo_img[2]" id="">
			<option value="1" selected="selected">varchar</option>
			<option value="2" >int</option>
			<option value="3">text</option>
			<option value="4">date</option>
		</select>
		<input type="text" name="longitud_img[2]" id="" value="100"></p>

		
		</div>

		<div class="row">
			<p class="link" onclick="agregar_campo_imagen()">+ campos a imagenes</p>
		</div>
	<?php } ?>
	
	
		



	<button type="submit">Crear modulo</button>
</form>



</div>

<div class="block">
	<footer>
		

	</footer>
</div>

<!-- JQuery -->
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->

</body>
</html>