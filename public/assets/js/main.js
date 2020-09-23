import { initTable } from './modules/initTable.js';

$(function () {
  const resp = '#app';
  const tkn = $('#tkn').val();

  initTable(resp, tkn);
});
