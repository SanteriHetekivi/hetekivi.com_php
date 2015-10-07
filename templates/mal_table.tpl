{* $entries AND $parts (chapters OR episodes)*}
<table>
	<tr>
		<th rowspan="2">#</th>
		<th rowspan="2">Image</th>
		<th rowspan="2">Title</th>
		<th rowspan="2">Score</th>
		<th colspan="2">{$parts}</th>
		<th colspan="2">Status</th>
		<th rowspan="2">Last Updated</th>
	</tr>
	<tr>
		<th col="6">USER</th>
		<th col="7">MAl</th>
		<th col="8">USER</th>
		<th col="9">MAl</th>
	</tr>
	{if $entries|is_array}
		{foreach from=$entries key=id item=entry}
			<tr>
				<td id="mal_id{$id}" >{$entry->getValue("mal_id")}</td>
				<td><img id="image{$id}" style='width:100px;height:150px;' src='{$entry->getValue("image")}'></td>
				<td id="title{$id}" >{$entry->getValue("title")}</td>
				<td id="manga_anime_score{$id}" >{$entry->getLinkedValue("manga_anime_score")}</td>
				<td id="manga_anime_parts{$id}" >{$entry->getLinkedValue("manga_anime_parts")}</td>
				<td id="{$parts}{$id}" >{$entry->getValue($parts)}</td>
				<td id="manga_anime_status{$id}" >{$entry->getStatus("user")}</td>
				<td id="status{$id}" >{$entry->getStatus("mal")}</td>
				<td id="manga_anime_last_updated{$id}" >{$entry->getLinkedValue("manga_anime_last_updated")}</td>
			</tr>
		{/foreach}
	{/if}
</table>
<button onclick="xajax_getMALTable('{$userid}', '{$manga_or_anime}', '{$MALUser}', '{$page-1})';">LAST</button><button onclick="xajax_getMALTable('{$userid}', '{$manga_or_anime}', '{$MALUser}', '{$page+1}');">NEXT</button>
