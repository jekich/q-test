var uploadFile = function (uploadUrl, deleteUrl, list) {

    var fileList = JSON.parse(list);

    $("#fileZone").dropzone({
        url: uploadUrl,
        addRemoveLinks: true,
        init: function () {
            var thisDropzone = this;

            $.each(fileList, function (key, value) {

                var mockFile = {name: value.name, size: value.size, file_id: value.id};
                var test = thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                if (value.thumb) {
                    thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.thumb);
                }
                thisDropzone.options.complete.call(thisDropzone, mockFile);

            });
        },
        removedfile: function (file) {
            var _ref;
            var removeLink = $(file._removeLink);
            if (file.file_id) {
                $.ajax({
                    url: deleteUrl,
                    type: "POST",
                    data: {id: file.file_id},
                    dataType: "json",
                    success: function (data) {
                        if (data.status == "success") {
                            (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                        }
                    }
                });
            }
        },
        success: function (obj, data) {
            var response = JSON.parse(data);
            var removeLink = $(obj._removeLink);
            if (response.status == "success" && response.data) {
                obj.file_id = response.data.id;
            }
        }
    });

};