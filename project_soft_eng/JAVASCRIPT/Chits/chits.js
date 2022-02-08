$(document).ready(function(){


	// Cookies extraction:
	var cookies = document.cookie.toString().split(";"), username = "", password = "", id = "";
	for(var i = 0; i < cookies.length; i++){
		if(cookies[i].split("=")[0].trim() == "username"){ username = cookies[i].split("=")[1].trim();}
		if(cookies[i].split("=")[0].trim() == "password"){ password = cookies[i].split("=")[1].trim();}
		if(cookies[i].split("=")[0].trim() == "id"){ id = cookies[i].split("=")[1].trim();}
	}
});

document.addEventListener('DOMContentLoaded', function() {

    function AppViewModel(){
        var self = this;
        this.entries = [];

    	// Retrieves Chits
    	$.ajax({

    		type: "POST",
    		dataType: "JSON",
    		url: "../../PHP/Chits/Chits/mychits.php",
    		async: false,
    		
            success: function(result){
                self.entries = result; }
    	});

        this.editChit = function (e) {
            //self.resetID(e.id);
            //self.resetUsername(e.name);
            //self.resetNewPassword("");
            $("#editChit-message").dialog('open');
        }

        this.viewChit = function (e) {
          $("#viewChit-message").dialog('open');
          //$("#imposture-iframe").attr('src', 'http://localhost:3000/HTML/Homepage/homepage.html#' + e.id);
          //$("#dialog-imposture").dialog('open');
        }
    }

    var avm = new AppViewModel();

    $("#editChit-message").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
          Close: function () {
            $(this).dialog("close");
          },
          Save: function () {
            $.ajax({
              type: "POST",
              dataType: "JSON",
              url: "../../PHP/Chits/editChit.php",
              async: false,
              data: {
                //'retrieve chit info here'//'id': avm.resetID(), 'password': avm.resetNewPassword()
              },
              success: function (result) {
                location.reload();
              }
            });

            $(this).dialog("close");
          }
        }
    });

    $("#viewChit-message").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
          Close: function () {
            $(this).dialog("close");
          },
          Save: function () {
            $.ajax({
              type: "POST",
              dataType: "JSON",
              url: "../../PHP/Chits/viewChit.php",
              async: false,
              data: {
                //'retrieve chit info here'//'id': avm.resetID(), 'password': avm.resetNewPassword()
              },
              success: function (result) {
                location.reload();
              }
            });

            $(this).dialog("close");
          }
        }
    });

  //  $("#dialog-imposture").dialog({
  //      autoOpen: false,
  //      modal: true,
  //      width: 1600,
  //      height: 900,
  //  });
    
    ko.applyBindings(new AppViewModel());

});
