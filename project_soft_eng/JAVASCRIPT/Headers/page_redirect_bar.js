$(document).ready(function(){

	var current_url = (window.location.href).toString().split("/"), url = current_url[current_url.length-1].split(".")[0];

	var colored_button = "style=\"background-color: #04DC77; border: 2px solid #4CD7D0;\"";

	var redirect = 
	(
		"<div id=\"switch_pages\">"+
			"<table>"+
				"<tr>"+
					"<td>"+
						"<button id=\"b_home\""+(("homepage" == url) ? colored_button : "")+">"+
							"<table>"+
								"<tr>"+
									"<td><img src=\"../../IMAGES/Switch_Pages_Icons/home.PNG\"></td>"+
									"<td><p class=\"myIdName\"> Home </p></td>"+
								"</tr>"+
							"</table>"+
						"</button>"+
					"</td>"+
					"<td>"+
						"<button id=\"b_training\""+(("training" == url || "my_training" == url || "create_event_training" == url) ? colored_button : "")+">"+
							"<table>"+
								"<tr>"+
									"<td><img src=\"../../IMAGES/Switch_Pages_Icons/pencil.PNG\"></td>"+
									"<td><p class=\"myIdName\"> Training </p></td>"+
								"</tr>"+
							"</table>"+
						"</button>"+
					"</td>"+
					"<td>"+
						"<button id=\"b_chits\""+(("chits" == url || "cmd_mgmt_chits" == url || "create_chits" == url) ? colored_button : "")+">"+
							"<table>"+
								"<tr>"+
									"<td><img src=\"../../IMAGES/Switch_Pages_Icons/chits.PNG\"></td>"+
									"<td><p class=\"myIdName\"> Chits </p></td>"+
								"</tr>"+
							"</table>"+
						"</button>"+
					"</td>"+
					"<td>"+
						"<button id=\"b_leadership\""+(("leadership" == url || "my_cmd_leadership" == url) ? colored_button : "")+">"+
							"<table>"+
								"<tr>"+
									"<td><img src=\"../../IMAGES/Switch_Pages_Icons/people.PNG\"></td>"+
									"<td><p class=\"myIdName\"> Leadership </p></td>"+
								"</tr>"+
							"</table>"+
						"</button>"+
					"</td>"+
					"<td>"+
						"<button id=\"b_communication\""+(("communication" == url) ? colored_button : "")+">"+
							"<table>"+
								"<tr>"+
									"<td><img src=\"../../IMAGES/Switch_Pages_Icons/chat.PNG\"></td>"+
									"<td><p class=\"myIdName\"> Communication </p></td>"+
								"</tr>"+
							"</table>"+
						"</button>"+
					"</td>"+
					"<td>"+
						"<button id=\"b_watchbill\""+(("watchbill" == url || "watchbill_edit" == url) ? colored_button : "")+">"+
							"<table>"+
								"<tr>"+
									"<td><img src=\"../../IMAGES/Switch_Pages_Icons/eye.PNG\"></td>"+
									"<td><p class=\"myIdName\"> Watchbill </p></td>"+
								"</tr>"+
							"</table>"+
						"</button>"+
					"</td>"+
					"<td>"+
						"<button id=\"b_calendar\""+(("calendar" == url) ? colored_button : "")+">"+
							"<table>"+
								"<tr>"+
									"<td><img src=\"../../IMAGES/Switch_Pages_Icons/calendar.PNG\"></td>"+
									"<td><p class=\"myIdName\"> Calendar </p></td>"+
								"</tr>"+
							"</table>"+
						"</button>"+
					"</td>"+
					"<td>"+
						"<button id=\"b_documents\""+(("documents" == url || "documents_edit" == url) ? colored_button : "")+">"+
							"<table>"+
								"<tr>"+
									"<td><img src=\"../../IMAGES/Switch_Pages_Icons/cloud.PNG\"></td>"+
									"<td><p class=\"myIdName\"> Documents </p></td>"+
								"</tr>"+
							"</table>"+
						"</button>"+
					"</td>"+
				"</tr>"+
			"</table>"+
			"<br>"+
		"</div>"

	);

	$("body").append(redirect);

	// -------------------------------------------------------------------------------------------------------

	var redirect = "";

	if(("training" == url || "my_training" == url || "create_event_training" == url)){

		redirect = 
		(
			
			"<div id=\"b_training_options\">"+
				"<table>"+
					"<tr>"+
						"<td>"+
							"<button id=\"b_my_training\""+(("my_training" == url) ? colored_button : "")+">My Training</button>"+
						"</td>"+
						"<td>"+
							"<button id=\"b_cmd_mgmt\""+(("training" == url) ? colored_button : "")+">Command Management</button>"+
						"</td>"+
						"<td>"+
							"<button id=\"b_create_event\""+(("create_event_training" == url) ? colored_button : "")+">Create Event</button>"+
						"</td>"+
					"</tr>"+
				"</table>"+
				"<br>"+
			"</div>"
			
		);
		
	}

	// -------------------------------------------------------------------------------------------------------

	else if(("chits" == url || "cmd_mgmt_chits" == url || "create_chits" == url)){

		redirect = 
		(
			
			"<div id=\"b_chits_options\">"+
				"<table>"+
					"<tr>"+
						"<td>"+
							"<button id=\"b_my_chits\""+(("chits" == url) ? colored_button : "")+">My Chits</button>"+
						"</td>"+
						"<td>"+
							"<button id=\"b_cmd_mgmt\""+(("cmd_mgmt_chits" == url) ? colored_button : "")+">Command Management</button>"+
						"</td>"+
						"<td>"+
							"<button id=\"b_create_chit\""+(("create_chits" == url) ? colored_button : "")+">Create Chit</button>"+
						"</td>"+
					"</tr>"+
				"</table>"+
				"<br>"+
			"</div>"

		);

	}

	// -------------------------------------------------------------------------------------------------------

	else if(("leadership" == url ||  "my_cmd_leadership" == url)){

		redirect = 
		(

			"<div id=\"b_leadership_options\">"+
				"<table>"+
					"<tr>"+
						"<td>"+
							"<button id=\"b_personnel_assignments\""+(("leadership" == url) ? colored_button : "")+">Personnel Assignments</button>"+
						"</td>"+
						"<td>"+
							"<button id=\"b_my_cmd\""+(("my_cmd_leadership" == url) ? colored_button : "")+">My Command </button>"+
						"</td>"+
					"</tr>"+
				"</table>"+
				"<br>"+
			"</div>"

		);

	}

	// -------------------------------------------------------------------------------------------------------

	else if(("watchbill" == url || "watchbill_edit" == url)){

		redirect = 
		(

			"<div id=\"b_watchbill_options\">"+
				"<table>"+
					"<tr>"+
						"<td>"+
							"<button id=\"b_view\""+(("watchbill" == url) ? colored_button : "")+">View</button>"+
						"</td>"+
						"<td>"+
							"<button id=\"b_edit\""+(("watchbill_edit" == url) ? colored_button : "")+">Edit</button>"+
						"</td>"+
					"</tr>"+
				"</table>"+
				"<br>"+
			"</div>"

		);

	}

	// -------------------------------------------------------------------------------------------------------

	else if(("documents" == url || "documents_edit" == url)){

		redirect = 
		(

			"<div id=\"b_documents_options\">"+
				"<table>"+
					"<tr>"+
						"<td>"+
							"<button id=\"b_view\""+(("documents" == url) ? colored_button : "")+">View</button>"+
						"</td>"+
						"<td>"+
							"<button id=\"b_edit\""+(("documents_edit" == url) ? colored_button : "")+">Edit</button>"+
						"</td>"+
					"</tr>"+
				"</table>"+
				"<br>"+
			"</div>"

		);

	}

	$("body").append(redirect);

})