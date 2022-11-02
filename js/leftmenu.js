// JavaScript Documentvar preUlElement = "";
/*var preUlElement = "";
function toggle(id)
{
	ul = "ul_" + id;   
    ulElement = document.getElementById(ul);
	
	if(preUlElement != "")
		if(preUlElement != ulElement)			
   		preUlElement.className = 'closed';
	
    if (ulElement)
	{
		if (ulElement.className == 'closed')
			ulElement.className = "open";
		else
			ulElement.className = "closed";
	}
	preUlElement = ulElement;
}*/
function toggle(id){
	//var className = $('#ul_'+id).attr("class");
	if($('#ul_'+id).hasClass('closed')){
		$('#ul_'+id).removeClass('closed');
		$('#ul_'+id).addClass('open');
	}else{
		$('#ul_'+id).addClass('closed');
		$('#ul_'+id).removeClass('open');
	}
}
