$(document).ready(function(){


	// Cookies extraction:
	var cookies = document.cookie.toString().split(";"), username = "", password = "", id = "";
	for(var i = 0; i < cookies.length; i++){
		if(cookies[i].split("=")[0].trim() == "username"){ username = cookies[i].split("=")[1].trim();}
		if(cookies[i].split("=")[0].trim() == "password"){ password = cookies[i].split("=")[1].trim();}
		if(cookies[i].split("=")[0].trim() == "id"){ id = cookies[i].split("=")[1].trim();}
	}


	// Gets the divs of the homepage.
	$.ajax({

		type: "POST",
		dataType: "json",
		url: "../../PHP/Training/My_Training/get_page_divs.php",
		async: false,
		
		data: {
			'id': id
		},

		success: function(divs){
			$('body').append(divs['all']);
		}

	});



})