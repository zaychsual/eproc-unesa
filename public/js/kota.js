$('#provinsi_id').on('change', function (e) {
    var provinsi = e.target.value;
    var request = $.ajax({
        url: urlKota + "/" + provinsi,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        type: "GET",
        dataType: "html"
    });

    request.done(function (output) {
        $('#kota_id').empty();
        $('#kota_id').html(output);
    });
})