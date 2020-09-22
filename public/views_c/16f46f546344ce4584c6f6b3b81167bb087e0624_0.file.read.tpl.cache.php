<?php
/* Smarty version 3.1.32, created on 2020-09-22 11:42:27
  from '/home/totto/Projects/middleware.sumagroups.com/public/views/modules/order/read.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5f6a0d53375f88_15096287',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '16f46f546344ce4584c6f6b3b81167bb087e0624' => 
    array (
      0 => '/home/totto/Projects/middleware.sumagroups.com/public/views/modules/order/read.tpl',
      1 => 1600785742,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6a0d53375f88_15096287 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '14389549015f6a0d5336d3b4_35975712';
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title text-capitalize"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h4>
                <p class="card-category"><?php echo $_smarty_tpl->tpl_vars['description']->value;?>
</p>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="text-primary">
                        <tr>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['thead']->value, 'column');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['column']->value) {
?>
                            <th><?php echo $_smarty_tpl->tpl_vars['column']->value;?>
</th>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
                        <tr>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['row']->value, 'cell');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['cell']->key => $_smarty_tpl->tpl_vars['cell']->value) {
$__foreach_cell_2_saved = $_smarty_tpl->tpl_vars['cell'];
?>
                            <td class="<?php if ($_smarty_tpl->tpl_vars['cell']->key === 'total_paid') {?>text-primary<?php }?>"><?php echo $_smarty_tpl->tpl_vars['cell']->value;?>
</td>
                        <?php
$_smarty_tpl->tpl_vars['cell'] = $__foreach_cell_2_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </tr>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><?php }
}
