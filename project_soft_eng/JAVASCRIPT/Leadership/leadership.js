document.addEventListener('DOMContentLoaded', function () {
  function AppViewModel() {
    var self = this;

    this.resetID = ko.observable();
    this.resetUsername = ko.observable();
    this.resetNewPassword = ko.observable();

    this.entries = [
    ];

    //Retrieve Users
    $.ajax({
      type: "POST",
      dataType: "JSON",
      url: "../../PHP/Leadership/retrieve.php",
      async: false,
      success: function (result) {
        self.entries = result;
      }
    });

    this.resetPassword = function (e) {
      self.resetID(e.id);
      self.resetUsername(e.name);
      self.resetNewPassword("");
      $("#dialog-message").dialog('open');
    }

    this.viewUser = function (e) {
      $("#imposture-iframe").attr('src', 'http://localhost:3000/HTML/Homepage/homepage.html#' + e.id);
      $("#dialog-imposture").dialog('open');
    }
  }

  var avm = new AppViewModel();

  $("#dialog-message").dialog({
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
          url: "../../PHP/Leadership/resetPassword.php",
          async: false,
          data: {
            'id': avm.resetID(), 'password': avm.resetNewPassword()
          },
          success: function (result) {
            location.reload();
          }
        });

        $(this).dialog("close");
      }
    }
  });

  $("#dialog-imposture").dialog({
    autoOpen: false,
    modal: true,
    width: 1600,
    height: 900,
  });

  ko.applyBindings(avm);
});