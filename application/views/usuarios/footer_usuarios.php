 
 </div>
 
</body>
</html>

<script type="text/javascript">
/*$(document).ready(function(){
//    $.mobile.ajaxEnabled = false;
    // other options to enable on intialization
});*/
// Para moverse con enter entre campos
$(".press").keypress(function(event){
if(event.which == 13){
cb = parseInt($(this).attr('tabindex'));
if ( $(':input[tabindex=\'' + (cb + 1) + '\']') != null) {
	// Then prevent the default [Enter] key behaviour from submitting the form
	event.preventDefault();
	$(':input[tabindex=\'' + (cb + 1) + '\']').focus();
	$(':input[tabindex=\'' + (cb + 1) + '\']').select();
return false;
}
}
});

</script> 