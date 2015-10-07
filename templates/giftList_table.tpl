<table>
	<tr>
		<th>#</th>
		<th>Image</th>
		<th>Title</th>
		<th>Type</th>
		<th>Price</th>
	</tr>
	{if $edit}<tr><td td align='center' bgcolor='green' colspan='7'><button style='width:100%' onclick='editGiftList(0)'>ADD</button></td></tr>{/if}
	{if $gifts|is_array}
		{foreach from=$gifts key=id item=gift}
			{if $edit OR $gift->canShow()}
				{include file="giftList_table_row.tpl" gift=$gift id=$id}
				{if $gift->hasChildren()}
					{foreach from=$gift->getChildren() key=childrenId item=children}
						{include file="giftList_table_row.tpl" gift=$children id=$childrenId rowID="children{$id}" hide=true}
					{/foreach}
				{/if}
			{/if}
		{/foreach}
	{/if}
</table>