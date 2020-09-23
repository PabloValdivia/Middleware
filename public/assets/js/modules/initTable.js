function initTable(resp, tkn) {

  $('.nav-link').on('click', function () {

    let url_controller = `/controller/${atob($(this).data('module'))}.php?token=${tkn}`;
    $.post(url_controller, { module: $(this).data('module'), controller: $(this).data('controller'), token: btoa(tkn) }, response => {
      $(resp).html(response);
      $('.table').DataTable({
        dom: 'B<"clear">lfrtip',
        buttons: {
          name: 'primary',
          buttons: ['copy', 'csv', 'excel', 'pdf']
        }
      });
    });
  });
}

export { initTable };
