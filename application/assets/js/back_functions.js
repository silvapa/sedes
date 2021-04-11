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

function load_section(a,url){
    $(a).parent().parent().find('li').removeClass('active');
    $(a).parent().addClass('active');
    $.ajax({
        url:url,
        type:'POST',
        dataType: 'json',
        beforeSend:function(){
            loading.show();
        },
        error:function(){
            alert('Transaction error, try again');
            loading.hide();
        },
        success:function(R){
            if(R.js != '') eval(R.js);
            $('.back_main_content').html(R.html);
            loading.hide();
        }
    });
}

function get_texts_ckeditor(form){
    if($(form).find('textarea')){
        $.each($(form).find('textarea'),function(){
            if(!$(this).hasClass('noeditor') && !$(this).is(':visible')){
                
                var editor =CKEDITOR.instances[$(this).attr('id')]
                if(editor){
                    $(this).html(CKEDITOR.instances[$(this).attr('id')].getData());
                }else{
                    $(this).html($('#'+$(this).attr('id')).html());
                }
            }
        //alert($(this).attr('name')+':'+$(this).html());
        });
    }
}

function change_lang(a,lang){
    $('.sections_sel').find('li').removeClass('active');
    $(a).parent().addClass('active');
    $('.section_edit').hide();
    $(lang).slideDown()
}

function load_edit(url){
    $.ajax({
        url:url,
        type:'POST',
        dataType: 'json',
        beforeSend:function(){
            loading.show();
        },
        error:function(){
            alert('Transaction error, try again');
            loading.hide();
        },
        success:function(R){
            if(R.js != '') eval(R.js);
            $('.back_main_content').html(R.html);
            loading.hide();
        }
    });
    return false;
}
function del(id,url, show){
    //$('table').find('reg_'+id);
    $.ajax({
        url:url,
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
            }else{
                $('table').find('.reg_'+id).remove();
                $(show).addClass('success').removeClass('error');
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


function request(url,data,show,execute_at_end){
    $.ajax({
        url:url,
        type:'POST',
        data: '&'+(data == undefined ? data : ''),
        dataType: 'json',
        success:function(R){
            if(R.js != '') eval(R.js);
            if(show == undefined) alert(R.html);
            else $(show).html(R.html);
            
            if(R.error==1 && show != undefined){
                $(show).addClass('error');
            }
            if(R.success==1){
                $(show).addClass('success').removeClass('error');
            }  
            if(execute_at_end != undefined) eval(execute_at_end);
        }
    });
    return false;
}
function request_post(url,form,show){
    get_texts_ckeditor(form);
    $.ajax({
        url:url,
        type:'POST',
        data: '&'+$(form).serialize(),
        dataType: 'json',
        success:function(R){
            if(R.js != '') eval(R.js);
            if(R.error==1){
                $('.msg_display').html(R.html).addClass('error');
            }else{
                $(show).html(R.html);
                $('.msg_display').addClass('success').removeClass('error');
            }            
        }
    });
    return false;
}

function video_refresh(link,where,w,h){
    if(trim(link)!=''){
        $(where).html('');
        $(where).append('<p id="message_flash">Please install the Flash Plugin</p>');
        var flashvars = {
            file:link,
            autostart:'false',
            screencolor:'#333333'
        };
        var params = {
            allowfullscreen:'true',
            allowscriptaccess:'always'
        };
        var attributes = {
            id:'player1',
            name:'player1'
        };

        if(w == undefined || h == undefined){
            swfobject.embedSWF(BASE_URL+'plugins/mediaplayer/player.swf','message_flash','480','270','9.0.115','false',flashvars, params, attributes);
        }else{
            swfobject.embedSWF(BASE_URL+'plugins/mediaplayer/player.swf','message_flash',w,h,'9.0.115','false',flashvars, params, attributes);
        }
    }
}
