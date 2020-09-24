function initTable(e, resp, tkn) {
  "use strict";

  let url_controller = `/controller/${e.data('module').substr(0,1).toUpperCase()+e.data('module').substr(1)}.php?token=${tkn}`;
  $.post(url_controller, { module: btoa(e.data('module')), method: btoa(e.data('method')), token: btoa(tkn) }, response => {
    $(resp).html(response);
    $('.table').DataTable({
      dom: 'B<"clear">lfrtip',
      buttons: {
        name: 'primary',
        buttons: ['copy', 'csv', 'excel', 'pdf']
      }
    });
  });
}

export { initTable };
