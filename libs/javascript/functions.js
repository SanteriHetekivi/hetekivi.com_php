


$(document).mouseup(function (e)
{
    var container = $('[id^="popup_"]');

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide();
    }
});

function searchManga(page)
{
	var parametres = [
		getUrlParameter("mangaPage")[0],
		getUrlParameter("user")[0],
		getUrlParameter("include"+"%5B%5D"),
		getUrlParameter("exclude"+"%5B%5D")];
	runCallAjax("searchResults", "AJAX_searchManga", parametres);
	/*var ajaxurl = 'index.php', data =  {"action": "ajax","ajax_action": "mangaSearch" ,"mangaPage":mangaPage,"user":user, "included" : included, "excluded" : excluded};
	$.post(ajaxurl, data, function (response) 
	{
		$('#searchResults').html(response);
		spinner.stop();
	});*/
}

function getUrlParameter(name)
{
	var values = [];
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == name) 
        {
            values.push(sParameterName[1]);
        }
    }
	return values;
}

function runCallAjax(_div, _function, _parametres)
{
	var spinner = makeSpinner(_div);
	par = "";
	if(Array.isArray(_parametres))
	{
		for (index = 0; index < _parametres.length; index++) 
		{ 
			par += "&value" + index + "=" + _parametres[index];
		}
	}
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
		{
			if(typeof xmlhttp !== "undefined")
			{
				var text = xmlhttp.responseText;
				if(_div) document.getElementById(_div).innerHTML = text;
				else return xmlhttp.responseText;
				
			}
			if(typeof spinner !== "undefined") spinner.stop();
		}
	}
	xmlhttp.open("POST","index.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("action=ajax&function="+_function+par);
}

function makeSpinner(divId)
{
	var opts = {
	  lines: 13, // The number of lines to draw
	  length: 20, // The length of each line
	  width: 10, // The line thickness
	  radius: 30, // The radius of the inner circle
	  corners: 1, // Corner roundness (0..1)
	  rotate: 0, // The rotation offset
	  direction: 1, // 1: clockwise, -1: counterclockwise
	  color: '#000', // #rgb or #rrggbb or array of colors
	  speed: 1, // Rounds per second
	  trail: 60, // Afterglow percentage
	  shadow: false, // Whether to render a shadow
	  hwaccel: false, // Whether to use hardware acceleration
	  className: 'spinner', // The CSS class to assign to the spinner
	  zIndex: 2e9, // The z-index (defaults to 2000000000)
	  top: '50%', // Top position relative to parent
	  left: '50%' // Left position relative to parent
	};
	var target = document.getElementById(divId);
	return new Spinner(opts).spin(target);
}

//Function To Display Popup
function div_show(div) {
	var y = event.pageY - 90;
	var x = event.pageX - 200;
$("#"+div).css( {display:"block",position:"absolute", top: y, left: x});
}
//Function to Hide Popup
function div_hide(div){
$("#"+div).css( {display:"none"});
}
//Function To Toggle Popup
function div_toggle(div) {
var display = document.getElementById(div).style.display;
if(display == "none" || display == "")div_show(div);
else div_hide(div);
}

//Function To Toggle row
function row_toggle(id) {
var style = document.getElementById(id).style;
if(style.display == "none" || style.display == "") style.display = 'table-row';
else style.display = "none";
}
/*
*GIFT LIST
*
*/
function getGiftList(userid)
{
	var parametres = [userid];
	runCallAjax("giftListTable", "AJAX_getGiftList", parametres);
}
function editGiftList(giftid)
{
	var image = 	$("#giftImage"+giftid).attr('src');
	var title = 	$("#giftTitle"+giftid).text();
	var url = 		$("#giftTitle"+giftid).attr('href');
	var position = 	$("#giftPosition"+giftid).text();
	var type = 		$("#giftType"+giftid).val();
	var price = 	parseFloat($("#giftPrice"+giftid).text());
	
	$("#id").val(giftid);
	$("#image").val(image);
	$('#prevImg').attr('src',image);
	$("#title").val(title);
	$("#url").val(url);
	$("#position").val(position);
	$("#type").val(type);
	$("#price").val(price);
	div_hide("popup_giftListEdit");
	div_show("popup_giftListEdit");
}

function setGiftUserDoesNotHave(giftid)
{
	$("#id").val(giftid);
	var parametres = ["gifts","image",giftid];
	var image = runCallAjax(false, "AJAX_getValue", parametres);
	var parametres = ["gifts","title",giftid];
	runCallAjax("title", "AJAX_getValue", parametres);
	var parametres = ["gifts","url",giftid];
	runCallAjax("url", "AJAX_getValue", parametres);
	var parametres = ["gifts","price",giftid];
	runCallAjax("price", "AJAX_getValue", parametres);
}

function myTrimNewlines(string){ return string.replace(/(\r\n|\n|\r)/gm,""); }

function myTrim(string){ return myTrimNewlines(string).replace(/\s/g, ""); }
