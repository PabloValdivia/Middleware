$(document).ready(function(){
    var resp = '#app';
    
    $('#search').on('submit', function(e){
        e.preventDefault();
        var f = $(this).serialize();

        var url_controller = '/controller/' + $(this).find('#module').val() + '.php' + '?token=' + token;
        console.log(url_controller);    

        /*$.ajax({
            url: url_controller,
            type: 'POST',
            dataType: 'json',
            data: {form: f},
            success: function(data) { 
                console.log(data);
            },
            error: function() {
                console.log(url_controller);
                console.error('No hay que mostrar');
            }
        });*/
    });
});