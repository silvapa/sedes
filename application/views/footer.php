 </div>
<!--  <nav class="navbar navbar-new  navbar-fixed-bottom navbar-bottom hidden-xs" role="navigation"> -->
  <div id = "row"><div id = "col" class="Lines3 hidden-xs"></div></div>
  <div id = "row"><div id = "col" class="Lines1 hidden-xs"></div></div>
  <nav class="navbar navbar-new navbar-bottom hidden-xs footer" role="navigation">
    <div class="container-fluid">
        <div class="navbar-footer">
           <a class="navbar-brand navbar-centrado-sombreado" href="http://www.cbc.uba.ar">Subsecretaria de Planificacion - C.B.C.</C></a>
        </div>
        <?php echo '<div class="navbar-footer pull-right" id="accesos">'?>
            <?php echo '<p class="clase_t_accesos">'.$this->session->userdata('nombre').'</p>' ?> 
            <?php echo '</div>'?> 

    </div>
  </nav>
  <script src="<?php echo base_url() ?>application/assets/js/bootstrap.min.js">

$(".nav li").on("click", function(){
   $(".nav").find(".active").removeClass("active");
   $(this).addClass("active");
});
  </script>
</body>
</html>