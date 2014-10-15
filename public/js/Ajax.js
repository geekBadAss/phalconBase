//Browser Support Code
function removeItem(id, page){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var queryString = "?id=" + id + "&action=remove";
	ajaxRequest.open("GET", page + ".php" + queryString, true);
	ajaxRequest.send(null); 
	FadeOut(id);
}

function makeCurrent(id, page){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var queryString = "?id=" + id + "&action=current";
	ajaxRequest.open("GET", page + ".php" + queryString, true);
	ajaxRequest.send(null); 
	setTimeout("location.reload(true)",1000);
}

function LowAction(id, action){
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	var queryString = "?id=" + id + "&action=" + action;
	ajaxRequest.open("GET", "ajax_links.php" + queryString, true);
	ajaxRequest.send(null); 
	FadeOut(id);
}



function FadeOut(id) {
	$(document).ready(function(){
		$('#Event' + id).click(function () {
		$('#Event' + id).fadeOut("slow");
	});
	});
}

function openIntranet() {
	var url = document.getElementById('admIntranets').value;
	if(url != "")
		window.open(url);
}

function updatePreview(field, name) {
	data = updateData(field);
	document.getElementById(name + '_Preview').innerHTML=data;
}

function updateData(data) {
	var txt = data.value;
	return txt.replace(/(\r\n|[\r\n])/g, "<br />");
	
}

/*
 *	Not currently being used.
 */
function textCounter(field, name, maxlimit) {
	if (field.value.length > maxlimit) { // if too long...trim it!
		field.value = field.value.substring(0, maxlimit);
		// otherwise, update 'characters left' counter
	} else {
		cntfield = maxlimit - field.value.length;
		document.getElementById(name).innerHTML=cntfield;
		document.getElementById(name + '_Preview').innerHTML=field.value;
	}
		
}
