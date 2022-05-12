function _cas_submit()
{
	if(document.cas_form.cas_text.value=="")
	{
		alert(cas_adminscripts.cas_text);
		document.cas_form.cas_text.focus();
		return false;
	}
	else if(document.cas_form.cas_link.value=="")
	{
		alert(cas_adminscripts.cas_link);
		document.cas_form.cas_link.focus();
		return false;
	}
	else if(document.cas_form.cas_status.value=="")
	{
		alert(cas_adminscripts.cas_status);
		document.cas_form.cas_status.focus();
		return false;
	}
	else if(document.cas_form.cas_order.value=="")
	{
		alert(cas_adminscripts.cas_order);
		document.cas_form.cas_order.focus();
		return false;
	}
	else if(isNaN(document.cas_form.cas_order.value))
	{
		alert(cas_adminscripts.cas_order);
		document.cas_form.cas_order.focus();
		return false;
	}
	_cas_escapeVal(document.cas_form.cas_text,'<br>');
}

function _cas_delete(id)
{
	if(confirm(cas_adminscripts.cas_delete))
	{
		document.frm_cas_display.action="options-general.php?page=continuous-announcement-scroller&ac=del&did="+id;
		document.frm_cas_display.submit();
	}
}	

function _cas_redirect()
{
	window.location = "options-general.php?page=continuous-announcement-scroller";
}

function _cas_escapeVal(textarea,replaceWith)
{
	textarea.value = escape(textarea.value) //encode textarea strings carriage returns
	for(i=0; i<textarea.value.length; i++)
	{
		//loop through string, replacing carriage return encoding with HTML break tag
		if(textarea.value.indexOf("%0D%0A") > -1)
		{
			//Windows encodes returns as \r\n hex
			textarea.value=textarea.value.replace("%0D%0A",replaceWith)
		}
		else if(textarea.value.indexOf("%0A") > -1)
		{
			//Unix encodes returns as \n hex
			textarea.value=textarea.value.replace("%0A",replaceWith)
		}
		else if(textarea.value.indexOf("%0D") > -1)
		{
			//Macintosh encodes returns as \r hex
			textarea.value=textarea.value.replace("%0D",replaceWith)
		}
	}
	textarea.value=unescape(textarea.value) //unescape all other encoded characters
}

function _cas_help()
{
	window.open("http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/");
}

function _casNoEnterKey(e)
{
    var pK = e ? e.which : window.event.keyCode;
    return pK != 13;
}
document.onkeypress = _casNoEnterKey;
if (document.layers) document.captureEvents(Event.KEYPRESS);