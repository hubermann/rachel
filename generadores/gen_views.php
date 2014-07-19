<?php  
// Backend
@mkdir("proyectos/$proyecto/control/".$plural);
// Frontend
@mkdir("proyectos/$proyecto/".$plural);


$view_all = "<h2><?php echo $"."title; ?></h2>


<?php if(count($"."query->result())){
	foreach ($"."query->result() as $"."row):
\n
echo '<div class=\"well well-large well-transparent\">';
";


foreach($fields_clean as $field){

$view_all .="\n echo '<p>".ucfirst(str_replace('_',' ',$field)).": '.$"."row->$field.' </p>';";
	
}



$view_all .= "
\n
?>
<div class=\"btn-group\">
<a class=\"btn btn-small\" href=\"<?php echo base_url('control/$plural/delete_comfirm/'.$"."row->id.''); ?>\">Eliminar</a>
<a class=\"btn btn-small\" href=\"<?php echo base_url('control/$plural/editar/'.$"."row->id.''); ?>\">Editar</a>
<a class=\"btn btn-small\" href=\"<?php echo base_url('control/$plural/detail/'.$"."row->id.''); ?>\">detalle</a>
</div>
<?php 
	echo '</div>';
	endforeach; 

}else{
	echo 'No hay resultados.';
}
?>
<div>
<ul class=\"pagination pagination-small pagination-centered\">
	<?php echo $"."pagination_links;  ?>
</ul>
</div>
	
";

		
$file = fopen("proyectos/$proyecto/control/$plural/all.php", "w+");
fwrite($file, $view_all);

#DELETE COMFIRMATION

$comfirm_delete ="
<?php  
$"."attributes = array('class' => 'form-horizontal', 'id' => 'delete_$singular');
echo form_open(base_url().'control/$plural/delete/'.$"."query->id, $"."attributes);
echo '<fieldset>'.form_hidden('id', $"."query->id); 

?>
<legend><?php echo $"."title ?></legend>
<div class=\"well well-large well-transparent\">";

foreach($fields_clean as $field){

		
$comfirm_delete .="\n <p>".ucfirst(str_replace('_',' ',$field)).": <?php echo $"."query->$field; ?></p>";
		

}

$comfirm_delete .="
<!--  -->
<div class=\"control-group\">

<label class=\"checkbox inline\">

<input type=\"checkbox\" name=\"comfirm\" id=\"comfirm\" />
<p>Confirma eliminar?</p>
<?php echo form_error('comfirm','<p class=\"error\">', '</p>'); ?>
 </label>
</div>
<!--  -->
<div class=\"control-group\">
<button class=\"btn btn-danger\" type=\"submit\"><i class=\"icon-trash icon-large\"></i> Eliminar</button>
</div>



</fieldset>

<?php echo form_close(); ?>


";

$file = fopen("proyectos/$proyecto/control/$plural/comfirm_delete.php", "w+");
fwrite($file, $comfirm_delete);


#DETAIL PAGE

$detail = "<h2><?php echo $"."title ?></h2>
<div class=\"well well-large well-transparent\">
<?php";

foreach($fields_clean as $field){
		
$detail .="\n echo '<p>".ucfirst(str_replace('_',' ',$field)).": '.$"."query->$field.' </p>';";

}

$detail .= "
?>
<div class=\"btn-group\">
<a class=\"btn btn-small\" href=\"<?php echo base_url('control/$plural/delete_comfirm/'.$"."query->id.''); ?>\">Eliminar</a>
<a class=\"btn btn-small\" href=\"<?php echo base_url('control/$plural/editar/'.$"."query->id.''); ?>\">Editar</a>
</div>
</div>
";
$file = fopen("proyectos/$proyecto/control/$plural/detail.php", "w+");
fwrite($file, $detail);


#######EDIT
$view_edit = "
<?php  
$"."attributes = array('class' => 'form-horizontal', 'id' => 'edit_$singular');
echo form_open(base_url().'control/$plural/update/',$"."attributes);

echo form_hidden('id', $"."query->id); 
?>
<legend><?php echo $"."title ?></legend>
<div class=\"well well-large well-transparent\">

 \n";

foreach($fields_clean as $field){


if($field == 'body' ||$field == 'description' || $field == 'descripcion' || $field == 'cuerpo'){
	
$view_edit .= "<!-- Textarea -->
<div class=\"control-group\">
	<label class=\"control-label\">".ucfirst(str_replace('_',' ',$field))."</label>
		<div class=\"controls\">
			<textarea name=\"$field\" ><?php echo $"."query->$field; ?></textarea>
			<?php echo form_error('$field','<p class=\"error\">', '</p>'); ?>
		</div>
</div>\n";	
	
}else{
	$view_edit .= "\n
<!-- Text input-->
<div class=\"control-group\">
<label class=\"control-label\">".ucfirst(str_replace('_',' ',$field))."</label>
	<div class=\"controls\">
		<input value=\"<?php echo $"."query->$field; ?>\" type=\"text\" name=\"$field\" />
		<?php echo form_error('$field','<p class=\"error\">', '</p>'); ?>
	</div>
</div>\n";
	
}


}


$view_edit .= "
<div class=\"control-group\">
<label class=\"control-label\"></label>
	<div class=\"controls\">
		<button class=\"btn\" type=\"submit\">Actualizar</button>
	</div>
</div>



</fieldset>

<?php echo form_close(); ?>

</div>

";

$file = fopen("proyectos/$proyecto/control/$plural/edit_$singular.php", "w+");
fwrite($file, $view_edit);

#MAIN MENU
$menu ="<div class=\"well sidebar-nav\">
	<ul class=\"nav nav-list\">
		<li class=\"nav-header\">Opciones</li>
		<li><a href=\"<?php echo base_url('control/$plural/');?>\">Ver ".ucfirst($plural)."</a></li>
		<li><a href=\"<?php echo base_url('control/$plural/form_new'); ?>\">Nuevo $singular</a></li>
	</ul>
</div><!--/.well -->
";
$file = fopen("proyectos/$proyecto/control/$plural/menu_$singular.php", "w+");
fwrite($file, $menu);




#NEW FORM

$new = "
<?php  

$"."attributes = array('class' => 'form-horizontal', 'id' => 'new_$singular');
echo form_open(base_url().'control/$plural/create/',$"."attributes);

echo form_hidden('$singular"."[id]');

?>
<legend><?php echo $"."title ?></legend>
<div class=\"well well-large well-transparent\">
";


foreach($fields_clean as $field){



if($field == 'body' ||$field == 'description' || $field == 'descripcion' || $field == 'cuerpo'){
	
$new .= "<!-- Textarea -->
<div class=\"control-group\">
	<label class=\"control-label\">".ucfirst(str_replace('_',' ',$field))."</label>
		<div class=\"controls\">
			<textarea name=\"$field\" ><?php echo set_value('$field'); ?></textarea>
			<?php echo form_error('$field','<p class=\"error\">', '</p>'); ?>
		</div>
</div>\n";	
	
}else{
$new .= "\n
<!-- Text input-->
<div class=\"control-group\">
<label class=\"control-label\">".ucfirst(str_replace('_',' ',$field))."</label>
	<div class=\"controls\">
		<input value=\"<?php echo set_value('$field'); ?>\" type=\"text\" name=\"$field\" />
		<?php echo form_error('$field','<p class=\"error\">', '</p>'); ?>
	</div>
</div>\n";
	
}


}

$new .= "<div class=\"control-group\">
<label class=\"control-label\"></label>
	<div class=\"controls\">
		<button class=\"btn\" type=\"submit\">Crear</button>
	</div>
</div>



</fieldset>

<?php echo form_close(); ?>

</div>
";

$file = fopen("proyectos/$proyecto/control/$plural/new_$singular.php", "w+");
fwrite($file, $new);


###
###
###
###

			//vistas front_end

###
###
###
###
###

$view_all_front = "<h2><?php echo $"."title; ?></h2>


<?php foreach ($"."query->result() as $"."row):?>
\n
<?php";


foreach($fields_clean as $field){

$view_all .="\n echo '<p>".ucfirst(str_replace('_',' ',$field)).": '.$"."row->$field.' </p>';";
	
}



$view_all_front  .= "
$avatar_vista
\n

<?php endforeach; ?>";

		
$file = fopen("proyectos/$proyecto/$plural/$plural.php", "w+");
fwrite($file, $view_all_front );

$detail_front = "<h2><?php echo $"."title ?></h2>

<?php";


foreach($fields_clean as $field){

		
$detail_front .="\n echo '<p>".ucfirst(str_replace('_',' ',$field)).": '.$"."query->$field.' </p>';";
		

}


$detail_front .= "


";
$file = fopen("proyectos/$proyecto/$plural/detail_$singular.php", "w+");
fwrite($file, $detail);

?>
