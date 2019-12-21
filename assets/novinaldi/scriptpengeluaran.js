function tambahdata() {
    $.ajax({
        url: './tambahdata',
        success: function (data) {
            alert(data);
        }
    });
}