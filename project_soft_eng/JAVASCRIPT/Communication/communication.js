document.addEventListener('DOMContentLoaded', function () {
    function AppViewModel() {
        var self = this;
        this.to = ko.observable();
        this.subject = ko.observable();
        this.message = ko.observable();

        this.currentMessage = ko.observable();

        this.entries = [
        ];

        //Retrieve Messages
        $.ajax({
			type: "POST",
			dataType: "JSON",
			url: "../../PHP/Communication/retrieve.php",
            async: false,
            success: function(result) {
                self.entries = result;
            }
        });

        this.userList = [];

        //Retrieve Users
        $.ajax({
			type: "POST",
			dataType: "JSON",
			url: "../../PHP/Database/retrieveUserList.php",
            async: false,
            success: function(result) {
                self.userList = result;
            }
        });

        this.viewMessage = function(e) {
            self.currentMessage(e.message);
        }

        this.sendMessage = function() {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "../../PHP/Communication/send.php",
                async: false,
                data: {
                    'to': self.to().id,
                    'subject': self.subject(),
                    'message': self.message()
                },
                success: function(result) {
                    alert("Your message has been sent!");
                    location.reload();
                }
            });
        }
    }

    ko.applyBindings(new AppViewModel());
});