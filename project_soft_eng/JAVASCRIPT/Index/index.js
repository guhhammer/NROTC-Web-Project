$(document).ready(function(){

	$(document).keypress(function (e) {
	    if (e.which == 13) {
	    	
	        $("#b_login").click();

	    }
	});

	$("#Username").click(function(){
		
		if($("#Username").hasClass("incorrect")){
			
			$("#Username").removeClass("incorrect_text");
			$("#Username").removeClass("add_text");
			$("#Username").val("");
			$("#Username").addClass("add_text_type_again"); 
			$("#Username").addClass("incorrect_type_again"); 
		
		}
		else{
			$("#Username").addClass("add_text");
		}

	});


	$("#Password").click(function(){
		
		if($("#Password").hasClass("incorrect")){
			
			$("#Password").removeClass("incorrect_text");
			$("#Password").removeClass("add_text");
			$("#Password").val("");
			$("#Password").addClass("add_text_type_again"); 
			$("#Password").addClass("incorrect_type_again"); 
		
		}
		else{
			$("#Password").addClass("add_text");
		}

	});


	$("#b_login").click(function(){

		var username_ = $("#Username").val().toString(), password_ = $("#Password").val().toString();

		$.ajax({

			type: "POST",
			dataType: "JSON",
			url: "./PHP/Index/authenticate.php",

			async: false,

			data: {
				'username': username_, 'password': password_ 
			},

			success: function(authentication){

				if(authentication['connection'] == "not ok"){ alert("Server could not establish a connection. Please, try again!"); }
				else{

					if(authentication['username_found'] == "not ok" || username_ == ""){ 

						if($("#Password").hasClass("incorrect")){ $("#Password").removeClass("incorrect"); $("#Password").addClass("default"); }

						if($("#incorrect_password").hasClass("show_visible")){ 
							$("#incorrect_password").removeClass("show_visible");
							$("#incorrect_password").addClass("show_hidden");
						}

						$("#Username").removeClass("default");
						$("#Username").addClass("incorrect"); 
						
						if ($("#Username").hasClass("incorrect_type_again")){
							$("#Username").removeClass("incorrect_type_again");
						}						
						
						$("#Username").addClass("incorrect_text");

						if($("#incorrect_username").hasClass("show_hidden")){ 
							$("#incorrect_username").removeClass("show_hidden");
							$("#incorrect_username").addClass("show_visible");
						}

					}	
					else{

						if($("#Username").hasClass("incorrect")){ $("#Username").removeClass("incorrect"); }
						if(!$("#Username").hasClass("default")){ $("#Username").addClass("default"); }

						if($("#incorrect_username").hasClass("show_visible")){ 
							$("#incorrect_username").removeClass("show_visible");
							$("#incorrect_username").addClass("show_hidden");
						}

						if(authentication['match'] == "not ok" || password_ == ""){ 
							$("#Password").removeClass("default");
							$("#Password").addClass("incorrect"); 
							
							if ($("#Password").hasClass("incorrect_type_again")){
								$("#Password").removeClass("incorrect_type_again");
							}						
							
							$("#Password").addClass("incorrect_text");

							if($("#incorrect_password").hasClass("show_hidden")){ 
								$("#incorrect_password").removeClass("show_hidden");
								$("#incorrect_password").addClass("show_visible");
							}
						}
						else{

							if($("#Password").hasClass("incorrect")){ $("#Password").removeClass("incorrect"); }
							if(!$("#Password").hasClass("default")){ $("#Password").addClass("default"); }

							var time = 60*60*24*3;

							document.cookie = "username = "+username_+";expires = "+time.toString()+";path = /;";
							document.cookie = "password = "+password_+";expires = "+time.toString()+";path = /;";
							document.cookie = "id = "+authentication['id'].toString()+";expires = "+time.toString()+";path = /;";
							
							window.open("./HTML/Homepage/homepage.html", "_self");

						}

					}
					
				}

			}

		});


	});

})