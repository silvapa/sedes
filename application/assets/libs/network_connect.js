app = {};
app.network = {};
app.network.facebook = {};
app.network.twitter = {};
app.network.gplus = {};
app.network.oauth = {};
app.network.form = {};

app.network.oauth.init = function (){
    $.oauthpopup = function(options)
    {
        if (!options || !options.path) {
            throw new Error("options.path must not be empty");
        }
        options = $.extend({
            windowName: 'ConnectWithOAuth' // should not include space for IE
            , 
            windowOptions: 'location=0,status=0,width=800,height=400'
            , 
            callback: function(){
                window.location.reload();
            }
        }, options);

        var oauthWindow   = window.open(options.path, options.windowName, options.windowOptions);
        var oauthInterval = window.setInterval(function(){
            if (oauthWindow.closed) {
                window.clearInterval(oauthInterval);
                options.callback();
            }
        }, 1000);
    };    
}


/*Conexion Oauth*/
app.network.facebook.connect = function() {
    app.network.oauth.init();
    $.oauthpopup({
        path: baseurl+'facebook_connect/connect',
        callback: function() {
            $.getJSON(baseurl+'facebook_connect/user/', function(data) {
                app.network.form.complete(data,'facebook');
            });
        }
    });
}
/*Conexion twitter*/
app.network.twitter.connect = function() {
    app.network.oauth.init();
    $.oauthpopup({
        path: baseurl+'twitter_connect/connect',
        callback: function(data) {
            $.getJSON(baseurl+'twitter_connect/get_user/', function(data) {
                app.network.form.complete(data.user,'twitter');
            });
        }
    });
}
/*Conexion gplus*/
app.network.gplus.connect = function() {
    app.network.oauth.init();
    $.oauthpopup({
        path: baseurl+'gplus_connect/connect',
        callback: function() {
        }
    });
}

app.network.form.complete = function (data,red){
    $form = $('.form-fields-left');
    $formprofile = $('.form-profile');
    if (red == 'facebook'){
        $('.form-checkin').slideToggle(function (){
            /*Name*/
            $form.find('#nameInput').val(data.first_name);
            /*Apellido*/
            $form.find('#surnameInput').val(data.last_name);
            /*Email*/
            $form.find('#emailInput').val(data.email);
            /*Avatar*/
            $formprofile.find('.img-profile').attr('src',data.picture);            
        });
    }else if (red == 'twitter'){
        /*Name*/
        $form.find('#nameInput').val(data.nombre);
        /*Avatar*/
        $formprofile.find('.img-profile').attr('src',data.picture);        
    }
    $('.form-checkin').slideToggle();
}

