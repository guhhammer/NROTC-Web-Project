$(document).ready(function(){

	// Cookies extraction:
	var cookies = document.cookie.toString().split(";"), username = "", password = "", id = "", rank_ = "";
	for(var i = 0; i < cookies.length; i++){
		if(cookies[i].split("=")[0].trim() == "username"){ username = cookies[i].split("=")[1].trim();}
		if(cookies[i].split("=")[0].trim() == "password"){ password = cookies[i].split("=")[1].trim();}
		if(cookies[i].split("=")[0].trim() == "id"){ id = cookies[i].split("=")[1].trim();}
	}

	// Gets the page header.
	$.ajax({

		type: "POST",
		dataType: "json",
		url: "../../PHP/Header/get_page_rank.php",
		async: false,
		
		data: {
			"id": id
		},

		success: function(rank){
			rank_ = rank;
		}

	});

	var header = 
	(

		"<div id=\"header\">"+	
		 	"<table>"+
		 		"<tr>"+
		 			"<td><p id=\"p_name\">NROTC San Diego Web Management</p></td>"+
		 			"<td><p id=\"p_rank\">"+rank_+"</p></td>"+
		 		"</tr>"+
		 	"</table>"+
		 	"<br>"+
	 	"</div>"

	);

	$("body").append(header);

});