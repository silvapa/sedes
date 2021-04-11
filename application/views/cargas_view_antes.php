<link type="text/css" rel="stylesheet" href="<?php echo base_url().'application/assets/css/style.css'; ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url().'application/assets/css/table.css'; ?>" />

<div data-role="content"> 

<form class="form-signin-mediano" name = 'form_cargas' id = 'form_cargas' action="<?php echo base_url() ?>Archivos/cargas_post" method='POST'>
        <h4 class="form-signin-heading">Seleccione los archivos a subir</h4> 
        <hr class="colorgraph">

<?php echo form_open_multipart('upload/do_upload_multi');?>

<h2>For Multiple Upload Codeigniter 3.X</h2>
<div style="border: 1px dotted #000;margin:10px 0;padding:10px;">
<input type="file" name="images[]" />
</div>

<br /><br />

<input type="submit" value="upload" name="upload" />

</form>