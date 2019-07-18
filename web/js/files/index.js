function getDataByUrl(url, showOnModal) {
    $.ajax({
        url: url,
        type: 'GET',
        data: {},
        dataType: "JSON",
        async: false,
        success: function(data) {
            if(showOnModal) {
                // apply user model window
                $('#modal').modal('show');
                //insert form into modal body
                $('.modal-body').html(data);
            } else {
                return true;
            }
        }
    });
}