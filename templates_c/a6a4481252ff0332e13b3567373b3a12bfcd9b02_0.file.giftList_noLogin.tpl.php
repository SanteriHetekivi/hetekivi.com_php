<?php /* Smarty version 3.1.27, created on 2015-09-02 10:08:29
         compiled from "templates/giftList_noLogin.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:22619563155e6a06de14ea4_45286066%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a6a4481252ff0332e13b3567373b3a12bfcd9b02' => 
    array (
      0 => 'templates/giftList_noLogin.tpl',
      1 => 1438523188,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22619563155e6a06de14ea4_45286066',
  'variables' => 
  array (
    'giftListTable' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55e6a06de27186_45372637',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55e6a06de27186_45372637')) {
function content_55e6a06de27186_45372637 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '22619563155e6a06de14ea4_45286066';
?>
<div id="column">
	<div id="giftListTable"><?php echo $_smarty_tpl->tpl_vars['giftListTable']->value;?>
</div>
</div>

<?php }
}
?>