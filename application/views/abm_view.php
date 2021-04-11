<?php 
foreach($css_files as $file): ?>
   <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" /> 
<?php endforeach; ?>
<?php foreach($js_files as $file): ?> 
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
</head> 
<body> 
    <div id="contenido_pagina_admin">
        <?php echo $output; ?>
    </div> 
