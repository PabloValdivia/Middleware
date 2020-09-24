import { initTable } from './modules/datatable.js';

$(function () {
  const resp = '#app';
  const tkn = $('#tkn').val();

  $(document).on('click', '.nav-link', function () {
    initTable($(this), resp, tkn);
  });
});
