document.addEventListener('DOMContentLoaded', function () {
    function AppViewModel() {
        var self = this;
        this.currentDirectory = ko.observable();
        this.currentDirectoryID = ko.observable();
        this.currentFiles = ko.observableArray();

        this.newFileName = ko.observable();
        this.newDirectoryName = ko.observable();

        this.uploadFile = function() {
            //Stream File Data
            var fileInput = document.getElementById('file');

            var reader = new FileReader();

            reader.onload = function() {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "../../PHP/Documents/upload.php",
                    async: false,
                    data: {
                        'name': self.newFileName(), 'folder': self.currentDirectoryID(), 'data': reader.result
                    },
                    success: function(result) {
                        location.reload();
                    }
                });
            }

            reader.readAsDataURL(fileInput.files[0]);
        }

        this.createDirectory = function() {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "../../PHP/Documents/create.php",
                async: false,
                data: {
                    'name': self.newDirectoryName(), 'parent': self.currentDirectoryID() 
                },
                success: function(result) {
                    location.reload();
                }
            });
        }

        this.deleteFile = function(file) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "../../PHP/Documents/delete.php",
                async: false,
                data: {
                    'id': file.id
                },
                success: function(result) {
                    location.reload();
                }
            });
        }

        this.entries = {
            directories: [
            ]
        };

        $.ajax({
			type: "POST",
			dataType: "JSON",
			url: "../../PHP/Documents/retrieve.php",
            async: false,
            success: function(result) {
                self.entries = result;
            }
        });

        this.changeDirectory = function (e) {
            self.currentDirectory(e.fullPath);
            self.currentDirectoryID(e.id);
            self.currentFiles(e.files);
        }

        //Set a default Directory
        this.changeDirectory(this.entries.directories[0]);

    }

    ko.applyBindings(new AppViewModel());
});