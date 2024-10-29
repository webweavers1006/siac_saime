$(document).ready(function() {
    $('#redirect').click(function() {
        var selectedYear = $('#year').val();
        window.location = '/citas_otorgadas/' + selectedYear;
    });
});