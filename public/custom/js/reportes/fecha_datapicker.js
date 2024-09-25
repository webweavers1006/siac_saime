
$(document).ready(function() {
    $("#fecha").datepicker({
	dateFormat: 'dd/mm/yy',
    language: "es",
   
    })//.//datepicker("setDate", new Date());
});

$(document).ready(function() {
    $("#fecha1").datepicker({
	dateFormat: 'dd/mm/yy',
    language:"es",
    }).datepicker("setDate", new Date());
});
