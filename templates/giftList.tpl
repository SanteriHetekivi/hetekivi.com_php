<form action="" method="post">
		Add new type:
		<input type="hidden" value="{$page}" name="action">
		<input type="text" name="title">
		<input type="submit" name="addNewType">
	</form>
<div id="column">
	<div id="giftListTable">{$table->HTML()}</div>
</div>
{*<div id="popup_giftListEdit" class="popup_content">
	<form action="" method="post">
		Select From Old: {html_options name="not_on_list" id="not_on_list" options=$giftsUserDoesNotHave }<BR>
		<input type="hidden" value="{$page}" name="action">
		<input id="id" name="gift[id]" type="hidden" value="0"/>
		<input id="users_id" name="gift[users_id]" type="hidden" value="{($userid)?$userid:0}"/>
		<img id="prevImg" name="prevImg" style='width:100px;height:150px;' /><BR>
		Position {html_options id="position" name="gift[position]" options=$giftPositions selected=$giftPositionsSelected }<BR>
		Title: <input id="title" name="gift[title]" type="text"><BR>
		Type: {html_options id="gifts_types_id" name="gift[gifts_types_id]" options=$giftTypes}<BR>
		Price: <input id="price" name="gift[price]" type="number" min="0" max="9999" step="0.01" size="4">&euro;<BR>
		Url: <input id="url" name="gift[url]" type="url"><BR>
		Image: <input id="image" name="gift[image]" onchange="$('#prevImg').attr('src',$('#image').val())" type="url"><BR>
		<input type="submit" name="Save">
	</form>
</div>
<script>
	xajax_getGiftList({($userid)?$userid:0});
	if($('#image').val()=="")$('#image').val("http://www.");
	if($('#url').val()=="")$('#url').val("http://www.");
	$("#not_on_list").change(function() 
	{
		xajax_setGiftUserDoesNotHave(this.value);
	});
</script>*}