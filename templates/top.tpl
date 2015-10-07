<body>
<div id="wrapper">
	<div id="header">
		<ul>
			{foreach from=$pages key=name item=site}
				{if $site == "login"}<li><a onclick='div_toggle("popup_login")' >{$name}</a></li>
				{else}  <li><a href="index.php?page={$site}">{$name}</a></li>
				{/if}
			{/foreach}
		</ul>
	</div>
	<div id="{($page)?$page:'container'}">
		<div id="popup_login" class="popup_content">
		Login:
		<form action="" method="post">
			<input type="hidden" value="login" name="action">
			<input type="text" name="username" id="username"><BR>
			<input type="password" name="password" id="password"><BR>
			<input type="submit" name="login">
		</form>
	</div>
			
