<?php /* Smarty version 3.1.27, created on 2015-09-02 10:14:01
         compiled from "templates/top.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:201001814955e6a1b9229c01_41016992%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '642a9ab7073c3baa88ad2d72da6cf540b380b868' => 
    array (
      0 => 'templates/top.tpl',
      1 => 1438523514,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '201001814955e6a1b9229c01_41016992',
  'variables' => 
  array (
    'pages' => 0,
    'site' => 0,
    'name' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55e6a1b92d68d3_29579943',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55e6a1b92d68d3_29579943')) {
function content_55e6a1b92d68d3_29579943 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '201001814955e6a1b9229c01_41016992';
?>
<body>
<div id="wrapper">
	<div id="header">
		<ul>
			<?php
$_from = $_smarty_tpl->tpl_vars['pages']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['site'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['site']->_loop = false;
$_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['name']->value => $_smarty_tpl->tpl_vars['site']->value) {
$_smarty_tpl->tpl_vars['site']->_loop = true;
$foreach_site_Sav = $_smarty_tpl->tpl_vars['site'];
?>
				<?php if ($_smarty_tpl->tpl_vars['site']->value == "login") {?><li><a onclick='div_toggle("popup_login")' ><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a></li>
				<?php } else { ?>  <li><a href="index.php?page=<?php echo $_smarty_tpl->tpl_vars['site']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</a></li>
				<?php }?>
			<?php
$_smarty_tpl->tpl_vars['site'] = $foreach_site_Sav;
}
?>
		</ul>
	</div>
	<div id="<?php echo $_smarty_tpl->tpl_vars['page']->value ? $_smarty_tpl->tpl_vars['page']->value : 'container';?>
">
		<div id="popup_login" class="popup_content">
		Login:
		<form action="" method="post">
			<input type="hidden" value="login" name="action">
			<input type="text" name="username" id="username"><BR>
			<input type="password" name="password" id="password"><BR>
			<input type="submit" name="login">
		</form>
	</div>
			
<?php }
}
?>