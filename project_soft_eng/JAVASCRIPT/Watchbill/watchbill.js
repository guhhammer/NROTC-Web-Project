document.addEventListener('DOMContentLoaded', function () {
    function AppViewModel() {
        this.week = ko.observable(moment().format('YYYY-[W]W'));
        this.week.subscribe(function(newValue) {
            //TODO: Use Ajax to dynamically update entries

            alert("The new week is " + newValue);
            //Warning!!
        });

        this.entries = [
            { duty: "PT Diver", shift: "Navy", monday: "", tuesday: "Rank LName", wednesday: "", thursday: "Rank LName", friday: "Rank LName", saturday: "", sunday: "" },
            { duty: "PT Diver", shift: "Marines", monday: "", tuesday: "Rank LName", wednesday: "", thursday: "Rank LName", friday: "Rank LName", saturday: "", sunday: "" },
            { duty: "PT Diver2", shift: "Navy", monday: "", tuesday: "Rank LName", wednesday: "", thursday: "Rank LName", friday: "Rank LName", saturday: "", sunday: "" },
            { duty: "PT Diver3", shift: "Navy", monday: "", tuesday: "Rank LName", wednesday: "", thursday: "Rank LName", friday: "Rank LName", saturday: "", sunday: "" },
            { duty: "PT Diver4", shift: "Navy", monday: "", tuesday: "Rank LName", wednesday: "", thursday: "Rank LName", friday: "Rank LName", saturday: "", sunday: "" },
            { duty: "PT Diver5", shift: "Navy", monday: "", tuesday: "Rank LName", wednesday: "", thursday: "Rank LName", friday: "Rank LName", saturday: "", sunday: "" },
        ];

        this.saveWatchbill = function() {
            alert("TODO: Use Ajax, to save this week");
        }

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
    }

    ko.applyBindings(new AppViewModel());
});