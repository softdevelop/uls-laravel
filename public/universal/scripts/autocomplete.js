// JavaScript Document

window.onload = init;
var xhr = false;
var search_terms_array = new Array();
var keydown = true;

function init() {
	
	document.getElementById("search_box").onkeyup = search_suggest;
	
	if (window.XMLHttpRequest) {
		xhr = new XMLHttpRequest();
	}
	
	else {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) { }
		}
	}
	
	if (xhr) {
		xhr.onreadystatechange = set_search_terms_array;
		xhr.open("GET", "/xml/search_terms.xml", true);
		xhr.send(null);
	}
	
	else {
		alert("Sorry but I couldn't create an XMLHttpRequest");
	}	
		

	
}

function set_search_terms_array() {
	if (xhr.readyState == 4) {
		if (xhr.status == 200) {
			var outMsg = xhr.responseText;
		}
		else {
			var outMsg = "There was a problem with the request " + xhr.status;
		}
		
		if (xhr.responseXML) {
			var all_terms = xhr.responseXML.getElementsByTagName("item");
			for(var i=0; i < all_terms.length; i++) {
				search_terms_array[i] = all_terms[i].getElementsByTagName("label")[0].firstChild;
			}
		}


	else {
		alert("There was a problem with the request " + xhr.status);
	}
}

}

function search_suggest() {
	
	var str = document.getElementById("search_box").value;
	
	document.getElementById("search_box").className ="";
	
	if (str != "") {
		document.getElementById("popups").innerHTML = "";
		
		if (keydown == false) {
			for (var i=0; i < search_terms_array.length; i++) {
				var this_term = search_terms_array[i].nodeValue;
				
				if (this_term.toLowerCase().indexOf(str.toLowerCase())==0) {
					var tempDiv = document.createElement("div");
					tempDiv.innerHTML = this_term;
					tempDiv.onClick = make_choice;
					tempDiv.className = "suggestions";
					document.getElementById("popups").appendChild(tempDiv);
				
				}
			}
		
		}
	}
	var foundCt = document.getElementById("popups").childNodes.length;
	
	if(foundCt == 0) {
	   document.getElementById("search_box").className="error2";
	}
	   
	if (foundCt == 1) {
		 document.getElementById("search_box").value = document.getElementById("popups").firstChild.innerHTML;
		 document.getElementById("popups").innerHTML = "";
	}
	
	
	
	
			
}

function make_choice(evt) {
	var thisDiv = (evt) ? evt.target : window.event.srcElement;
	document.getElementById("search_box").value = thisDiv.innerHTML;
	document.getElementById("popups").innerHTML = "";
	city.value = thisDiv.innerHTML;
	
}

document.onkeydown = checkKeycode;

function checkKeycode(e) {

	var keycode;

	if (window.event) {
		
		keycode = window.event.keyCode;
		
		if (keycode == 46) {
			keydown = true;
		
		}
		else {
			keydown = false;
		}
	}
	
}