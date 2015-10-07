<tr {if $hide}style="display: none;"{/if} {if $rowID}id="{$rowID}"{/if} >
	<td id="giftPosition{$id}" >{$gift->getPosition()}</td>
	<td><img id="giftImage{$id}" style='width:100px;height:150px;' src='{$gift->getValue("image")}'></td>
	<td><a id="giftTitle{$id}" href='{$gift->getValue("url")}'>{$gift->getValue("title")}</a></td>
	<td>{$gift->getTypeTitle()}<input id="giftType{$id}"  type='hidden' value='{$gift->getValue("gifts_types_id")}'/></td>
	<td id="giftPrice{$id}" >{$gift->getValue("price")|euro}&euro;</td>
	<td>
		{if $gift->hasChildren()}
			<button type='button' onclick="row_toggle('children{$id}')">CHILDREN</button><BR>
		{/if}
		{if $edit}
				<button type='button' onclick='editGiftList({$id})'>EDIT</button><BR>
				<form action='' method='post'>
					<input type='hidden' value='giftList' name='action'>
					<input type='hidden' value='{$gift->getLinkedID()}' name='linkedID'>
					<input type='submit' name='Delete' value='DELETE'>
				</form>
			</td>
		{/if}
	</td>
</tr>