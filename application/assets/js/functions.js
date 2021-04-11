var loading={
    show:function(){
        $('#loading').fadeIn()
    },
    hide:function(){
        $('#loading').hide()
    }
};
$(document).ready(function(){
    $('body').append(LOADING_HTML);
    loading.hide();
});
    

function request(url, data, show){
    $.ajax({
        url:url,
        type:'POST',
        data: '&'+(data != undefined ? data : ''),
        dataType: 'json',
        beforeSend:function(){
            loading.show();
        },
        error:function(){
            alert('Network fail, try again.');
            loading.hide();
        },
        success:function(R){
            if(R.js != '') eval(R.js);
            if(R.html != ''){
                if(show == undefined) alert(R.html);
                else $(show).html(R.html);
            }
            if(R.error==1 && show != undefined){
                $(show).addClass('error');
            }
            else{
                $(show).addClass('success').removeClass('error');
            }            
            loading.hide();
        }
    });
    return false;
}
function ajax(url,show){
    $.ajax({
        url:url,
        type:'GET',
        dataType: 'json',
        beforeSend:function(){
            loading.show();
        },
        error:function(){
            alert('Ocurrió un error enviando su solicitud, por favor intente de nuevo');
            loading.hide();
        },
        success:function(R){
            if(R.js != '') eval(R.js);
            if(show == undefined) alert(R.html);
            else $(show).html(R.html);
            
            if(R.error==1 && show != undefined){
                $(show).addClass('error');
            }
            if(R.error==1 && show != undefined){
                $(show).addClass('error');
            }        
            loading.hide();
        }
    });
    return false;
}

/*
     * Remove empty spaces from a string (like php trim function)
     */
function trim(text) {
    text= text.replace(/ /g,""); //elimina espacios a izquierda y derecha
    text= text.replace(/\n\r/g,"");
    text= text.replace(/\n/g,"");
    return text;
}
