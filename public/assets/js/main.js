$(document).ready(function(){
    const resp = '#app';
    const tkn = $('#tkn').val();
    
    $('.nav-link').on('click', function(){
        
        let url_controller = `/controller/${atob($(this).data('module'))}.php?token=${tkn}`;
        $.post( url_controller, {module: $(this).data('module'), controller: $(this).data('controller'), token: btoa(tkn)}, response => { 
            $(resp).html(response);
            $('.table').DataTable();
        });
    });
});