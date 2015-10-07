<?php /* Smarty version 3.1.27, created on 2015-09-02 10:14:01
         compiled from "templates/head.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:53232805855e6a1b9098400_90519788%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7219aedfef46ca98be08e95f488def87265787a5' => 
    array (
      0 => 'templates/head.tpl',
      1 => 1441177642,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '53232805855e6a1b9098400_90519788',
  'variables' => 
  array (
    'xajax_javascript' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55e6a1b920fd31_52950862',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55e6a1b920fd31_52950862')) {
function content_55e6a1b920fd31_52950862 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '53232805855e6a1b9098400_90519788';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>Hetekivi</title>
	<link rel="shortcut icon" href="https://www.hetekivi.com/favicon.ico" type="image/x-icon" />
	<?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"><?php echo '</script'; ?>
>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="https://www.hetekivi.com/libs/javascript/functions.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="https://www.hetekivi.com/libs/javascript/spin.js"><?php echo '</script'; ?>
>
	<link rel="stylesheet" type="text/css" href="https://www.hetekivi.com/libs/style.css">
	<?php echo $_smarty_tpl->tpl_vars['xajax_javascript']->value;?>

</head>
<?php }
}
?>