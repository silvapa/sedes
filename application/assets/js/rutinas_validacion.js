
  function validarMail(a,permite_nulo) {
    var emailRegex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;  
	
	if ((a.value == '') && permite_nulo) {
       return true;
    }

	if ((a.value == '') && (!permite_nulo)) {
	alert('Ingrese el email');		
       return false;
    }
	
    if (emailRegex.test(a.value)) {
       return true;
    }else{
       alert('El email '+a.value+' ingresado no es valido!');
       return false;
    }
  }

  function capitalize(a) {
    var item = a.value;
    a.value = item.replace(/\w\S*/g, function(txt){
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
  }
  
  function toUpperCase(a) {
    a.value = a.value.toUpperCase();
  }

  function validaCuit(a) {
    var strCuit = a.value;
    if (strCuit.length == 13){ 
      return true;
    }else { 
//      a.focus();
      alert('CUIT invalido');
      return false;
    }
  }

  function validarCuit(a) {
    var strCuit = a.value;

    if(strCuit.length != 13) {
        alert('El cuit ingresado debe respetar el formato XX-XXXXXXXX-X');
        return false;
    }
    if ((strCuit.substr(2,1) != '-') || (strCuit.substr(11,1) != '-')){
        alert('El cuit ingresado debe respetar el formato XX-XXXXXXXX-X');
        return false;
    }

    strCuit = strCuit.replace(/-/g, "");

    cuit = strCuit;  //parseInt(strCuit);

    if(cuit.length != 11) {
        return false;
    }

    var acumulado   = 0;
    var digitos     = cuit.split("");
    var digito      = digitos.pop();

    for(var i = 0; i < digitos.length; i++) {
        acumulado += digitos[9 - i] * (2 + (i % 6));
    }

    var verif = 11 - (acumulado % 11);
    if(verif == 11) {
        verif = 0;
    } else if(verif == 10) {
        verif = 9;
    }
    if (digito != verif) {
      alert('CUIT invalido');
    }
    return (digito == verif);
  }


  function CompletoDato(field, nombre) {
    if (field == null){
      alert('Campo inexistente '+nombre);
      return false;
    }
    if (field.length == 0) {
      alert('Campo inexistente '+nombre);
      return false;
    }
	var fieldData = field.value;
      fieldData = fieldData.trim();
      if (fieldData.length == 0 || fieldData == "") {
          alert('Complete el campo "'+nombre+'"');
          return false;
      } else {
          return true; 
      }
  }   
 
  function getAsDate(day, time)
{
 var hours = Number(time.match(/^(\d+)/)[1]);
 var minutes = Number(time.match(/:(\d+)/)[1]);
 var AMPM = time.match(/\s(.*)$/)[1];
 if(AMPM == "pm" && hours<12) hours = hours+12;
 if(AMPM == "am" && hours==12) hours = hours-12;
 var sHours = hours.toString();
 var sMinutes = minutes.toString();
 if(hours<10) sHours = "0" + sHours;
 if(minutes<10) sMinutes = "0" + sMinutes;
 time = sHours + ":" + sMinutes + ":00";
  var d = new Date(day);
 var n = d.toISOString().substring(0,10);
 var newDate = new Date(n+"T"+time);
 return newDate;
}

   function RangoValido(field, nombre, min, max, permite_nulo) {
    if (field.length == 0) {
      alert('Campo inexistente '+nombre);
    }
    var fieldData = field.value;
    fieldData = fieldData.trim();
    if (fieldData.length == 0 || fieldData == "") {
      if (permite_nulo) {
        return true;
      } else {
        alert('Complete el campo "'+nombre+'"');
        return false;
      }
    }
    n = parseFloat(fieldData);
    if (!(!isNaN(n) && n >= min && n <= max)) {
        alert('El campo "'+nombre+'" debe estar entre '+min+' y ' +max);
        return false;
    }
    return true;    
  }

  function validarFecha(a, permite_nulo, campo) {

    var fecha = a.value;
	
    if ((fecha == '') || (fecha == '00/00/0000')  || (fecha == '00/00/00')  || 
        (fecha == 'dd/mm/yyyy') || (fecha == '  /  /    ') ) {
		if (permite_nulo) {
			return true;
		} else {
			alert('Ingrese la fecha de "'+campo+'"');		
			return false;
		}
    }
    // regular expression to match required date format
    re = /^\d{1,2}\/\d{1,2}\/\d{4}$/;

    re = /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[13-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/;

    if(fecha != '' && !fecha.match(re)) {
  //    a.focus();
      alert('Fecha "'+campo+'" invalida');
      return false;
    }
    return true;
  }

  function f_estandarizar_anio(a){
    var hoy = new Date();
    aniohoy= hoy.getFullYear();
  
    n = parseFloat(a.value);
  
    if (isNaN(n)) {
        alert('Revise el campo año');
        n = 0;
        a.value = 0;
    }
  
    if (n < 85) {
      n = 2000 + n;
    } 
    else 
    {
        if ((n >= 85) && (n < 100)) {
          n = 1900 + n;
        }
    }  
  
    if (n > aniohoy + 1) {
      alert('El campo "año" debe ser menor que ' +max);
    }
    a.value = n;
  }
  
function validar_fecha_futura(dia) {

    var dateParts = dia.split("/");
    var dateObject = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]);
    var fyyyymmdd = dateObject.toString();
    var hoy = new Date();

    diahoy = hoy.getDate();
    meshoy = hoy.getMonth();
    aniohoy= hoy.getFullYear();
    fecha_actual = new Date(aniohoy,meshoy,diahoy);
    var hoyyyyymmdd = fecha_actual.toString();

    if (Date.parse(fyyyymmdd) < Date.parse(hoyyyyymmdd)){
          alert('La fecha no puede ser anterior al dia de hoy');
        return false;
    }
    return true;
  }

  function validarHora(a, permite_nulo, campo) {

    var hora = a.value;
	
    if ((hora == '') || (hora == '00:00')  || (hora == ':')  || (hora == '  :  ') ) {
		if (permite_nulo) {
			return true;
		} else {
			alert('Ingrese la hora de "'+campo+'"');		
			return false;
		}
    }
    // regular expression to match required date format
    re = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;

    if(hora != '' && !hora.match(re)) {
  //    a.focus();
      alert('Hora "'+campo+'" invalida');
      return false;
    }

    return true;
  }

function ahora_en_string() {
  let date = new Date();

  let day = date.getDate();
  let month = date.getMonth() + 1;
  let year = date.getFullYear();
  let hour = date.getHours();
  let minutes = date.getMinutes();

  var ahora = ''
  if (day < 10){
    ahora = '0'+day+'/';
  }
  else {
    ahora = day+'/';
  }   
  if(month < 10){
      ahora = ahora + '0';
  }
  return ahora + month + '/'+year+' '+hour+':'+minutes;
}

function diahora2datetime(dia, hora){
  return dia + ' ' + hora+ ':00';
}


function DisableInputs(bDisabled){
  var inputs = document.getElementsByTagName("input"); 
  for (var i = 0; i < inputs.length; i++) { 
      if (inputs[i].type != "hidden") {
      inputs[i].disabled = bDisabled;
    }
  }    
  var selects = document.getElementsByTagName("select");
  for (var i = 0; i < selects.length; i++) {
      selects[i].disabled = bDisabled;
  }   
  var selects2 = document.getElementsByClassName("select_styled");
  for (var i = 0; i < selects2.length; i++) {
      selects2[i].disabled = bDisabled;
  }   
  var memos = document.getElementsByTagName("textarea"); 
  for (var i = 0; i < memos.length; i++) { 
      if (memos[i].type != "hidden") {
        memos[i].disabled = bDisabled;
    }
  }    
    
}  
function DefaultInputs(){
  var inputs = document.getElementsByTagName("input"); 
  for (var i = 0; i < inputs.length; i++) { 
      inputs[i].val(inputs[i].prop('defaultValue'));
  }    
/*  var selects = document.getElementsByTagName("select");
  for (var i = 0; i < selects.length; i++) {
      selects[i].val(selects[i]).prop('selected', true);
  }     */
}  
function DisableButtons(bDisabled){
  var buttons = document.getElementsByTagName("button");
  for (var i = 0; i < buttons.length; i++) {
      buttons[i].disabled = bDisabled;
  }
} 