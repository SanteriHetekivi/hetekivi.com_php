<div id="column-left">
	<form action="" method="post" enctype="multipart/form-data">
		Upload Myanimelist export XML:
		<input type="hidden" value="{$page}" name="action">
		<input type="file" name="MyAnimelistXML" id="MyAnimelistXML">
		<input type="submit" name="UploadXML">
	</form>
	<form action="" method="get">
	<input type="hidden" value="{$page}" name="page">
	{foreach from=$mangaPages item=mPage}
		<input type="submit" class="button" name="mangaPage" value="{$mPage}" />
	{/foreach}
	</form>
	{if !empty($genres)}
		<section>
		<div id="searchValues">
			<form action="" method="get">
				<input type="hidden" value="{$page}" name="page">
				<input type="hidden" value="{$mangaPage}" name="mangaPage">
				User: <select name="user">
					{foreach from=$users item=user}
							<option {($user==$myAnimelistUser)?'selected':''} value="{$user}">{$user}</option>
					{/foreach}
				</select>
				{if $mangaPage == "MangaFox"}
					<p>Chapters: <input type="number" id="chapterMin" value='1'/> - <input type="number" id="chapterMax" value='50'/>
				{/if}
				<table>
					<tr>
						<td>Include</td><td>Exclude</td><td>Genre</td>
					</tr>
					{foreach from=$genres key=genre item=value}
						<tr>
							<td><input type='checkbox' name='include[]' {if $genre|in_array:$included} checked {/if} value='{$value}'></td>
							<td><input type='checkbox' name='exclude[]' {if $genre|in_array:$exluded} checked {/if} value='{$value}' ></td>
							<td>{$genre}</td>
						</tr>
					{/foreach}
				</table>
				<input type="submit" name="search" value="Search"/>
			</form>
		</div>
	</div>
	<div id="column-right">
		<div id="searchResults"></div>
		</section>
		{if $searchOn == true}
			<script>searchManga()</script>
		{/if}
	{/if}
	</div>

