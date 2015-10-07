{assign var="columnCount" value=$table->getColumnCount()}
{assign var="add" value=$table->getAdd()}
{assign var="edit" value=$table->getEdit()}


<table>
	<tr>
		{foreach from=$table->getColumns() item=column}
			{if $column->getDataType() != "hidden"}
				<th id="{$column->getName()}" onclick="window.location.href = '{$table->getOrderUrl($column->getName())}';" > {$column->getTitle()}</th>
			{/if}
		{/foreach}
	</tr>
	{if $add}<tr><td td align='center' bgcolor='green' colspan="{$columnCount}"><button style='width:100%' onclick='this_edit(0)'>ADD</button></td></tr>{/if}
	{foreach from=$table->getElements() key=id item=element}
		<tr>
			{foreach from=$table->getColumns() item=column}
				{assign var="name" value=$column->getName()}
				{assign var="dataType" value=$column->getDataType()}
				{assign var="references" value=$column->getReferences()}
				{assign var="value" value=($column->IsLinkedValue())?$element->getLinkedValue($name):$element->getValue($name)}
				{if $dataType != "hidden"}
					<td id="{$name}{$id}" >
						{if $dataType == "image"}<img style="width:150px;height:200px;" src="{$value}">
						{elseif $dataType == "url"}<a href="{$value}"><div id=title{$id}>{$element->getValue("title")}</a>
						{elseif $dataType == "euro"}{$value|euro} &euro;
						{elseif $dataType == "reference" AND $references}{$references[$value]}<input type="hidden" id="reference_{$name}{$id}" value="{$value}">
						{else}{$value}
						{/if}
					</td>
				{/if}
			{/foreach}
			{if $edit}<td><button type='button' onclick='this_edit({$id})'>EDIT</button></td>{/if}
			{foreach from=$table->getExtrasByType("row_button") item=extra}
				<td>
					<button type='button' id="{$extra->getName()}" onclick='{$extra->getOnClick()}' onchange="{$extra->getOnChange()}">{$extra->getTitle()}"</button>
				</td>
			{/foreach}
		</tr>
	{/foreach}
	<tr>
		<td colspan="{$columnCount/2}"><button style='width:100%' onclick="window.location.href = '{$table->getLastUrl()}';">LAST</button></td>
		<td colspan="{$columnCount/2}"><button style='width:100%' onclick="window.location.href = '{$table->getNextUrl()}';">NEXT</button></td>
	</tr>
</table>

{if $add OR $edit}
	<div id="popup_Edit{$table->getCallPage()}" class="popup_content">
		{foreach from=$table->getExtrasByType("edit_input") item=extra}
			{assign var="type" value=$extra->getInputType()}
			{assign var="name" value=$extra->getName()}
			{assign var="onClick" value=$extra->getOnClick()}
			{assign var="onChange" value=$extra->getOnChange()}
			{$extra->getTitle()}: 
			{if $type == "select"}
				<select id="{$name}" {if $onClick}onclick="this_OnClick_{$name}(this)"{/if}  {if $onChange}onchange="this_OnChange_{$name}(this)"{/if}'>
					{foreach $extra->getValues() key=value item=text}
						<option value="{$value}" id="{$name}{$value}">{$text}</option>
					{/foreach}
				</select>
			{else} <input type="{$type}" id="{$name}" onclick="{$extra->getOnClick()}" onchange="{$extra->getOnChange()}" >
			{/if}
		{/foreach}
		<form action="" method="post">
			<input type="hidden" value="{$table->getCallPage()}" name="action">
			<input name="element[id]" type="hidden" value="0"/>
			{foreach from=$table->getColumns() item=column}
				{assign var="name" value=$column->getName()}
				{assign var="idName" value=$column->getIdName()}
				{assign var="dataType" value=$column->getDataType()}
				{$column->getTitle()}: 
				{if $dataType == "image"}
					<img name="prevImg_{$idName}" style='width:100px;height:150px;' /><BR>
					<input name="{$idName}" onchange="this_changePrevImg('{$idName}');" type="url" value="https://www.">
				{elseif  $dataType == "url"}
					<input name="{$idName}" type="url" value="https://www.">
				{elseif  $dataType == "euro"}
					<input name="{$idName}" type="number" min="0" max="9999" step="0.01" size="4">&euro;
				{elseif  $dataType == "number"}
					<input name="{$idName}" type="number">
				{elseif  $dataType == "reference" OR $dataType == "select"}
					{html_options name=$idName options=$column->getReferences() selected=$value}
				{else} <input name="{$idName}" type="text">
				{/if}
				<BR>
			{/foreach}
			<input type="submit" name="submit" value="Save">
		</form>
	</div>
	
	
	<script language="JavaScript" type="text/javascript">

		function this_changePrevImg(idName)
		{
			{literal}$(function(){$('[name="prevImg_'+idName+'"]').attr('src',$('[name="'+idName+'"]').val());});{/literal}
		}
		
		function this_edit(id, element)
		{
			element = typeof element !== 'undefined' ? element : false;
			var popupName = "popup_Edit{$table->getCallPage()}";
			
			if(element) id = element["id"];
			
			var isNew = !(id > 0);
			if(isNew) id = 0;
			
			div_hide(popupName);
			{literal}$("input[name='element[id]']").val(id);{/literal}
			
			{foreach from=$table->getColumns() item=column}
				var name = "{$column->getName()}";
				var idName = "{$column->getIdName()}";
				var dataType = "{($column->getDataType())?$column->getDataType():"FALSE"}";
				var Value = "";
				
				if(dataType == "image")
				{
					if(isNew) Value = "https://";
					else if(element) Value = element[name];
					else Value = {literal}$("#"+name+id).children("img").attr('src');{/literal}
				}
				else if (dataType == "url")
				{
					if(isNew) Value = "https://";
					else if(element) Value = element[name];
					else Value = {literal}$("#"+name+id).children("a").attr('href');{/literal}
				}
				else if (dataType == "euro")
				{
					if(isNew) Value = parseFloat(0);
					else if(element) Value = parseFloat(element[name]);
					else Value = parseFloat({literal}$("#"+name+id).text(){/literal}.replace(',', '.').trim());
				}
				else if (dataType == "number")
				{
					if(isNew) Value = parseInt(0);
					else if(element) Value = parseInt(element[name]);
					else Value = parseInt({literal}$("#"+name+id).text(){/literal}.trim());
				}
				else if(dataType == "reference")
				{
					if(isNew) Value = parseInt(0);
					else if(element) Value = parseInt(element[name]);
					else Value = {literal}$("#reference_"+name+id).val(){/literal};
				}
				else 
				{
					if(isNew) Value = "";
					else if(element) Value = element[name];
					else Value = {literal}$("#"+name+id).text(){/literal}.trim();
				}
				
				{literal}$(function(){$('[name="'+idName+'"]').val(Value);});{/literal}
				
				if (dataType == "image") this_changePrevImg(idName);
			{/foreach}
			
			div_show(popupName);
			
		}
		{foreach from=$table->getExtras() item=extra}
			{assign var="name" value=$extra->getName()}
			{assign var="onClick" value=$extra->getOnClick()}
			{assign var="onChange" value=$extra->getOnChange()}
			
			{if $onClick}
				function this_OnClick_{$name}(from)
				{
					{$onClick}
				}
			{/if}
			{if $onChange}
				function this_OnChange_{$name}(from)
				{
					{$onChange}
				}
			{/if}
		{/foreach}
	</script>
{/if}