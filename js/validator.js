toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

$(document).ready(function() {
    $(".pr-password").passwordRequirements({
        numCharacters: 8,
        useLowercase: true,
        useUppercase: true,
        useNumbers: true,
        useSpecial: false,
        style: "light",
        fadeTime: 500
    });
    $(document).ready(function() {
        $('form').on('submit', function(event) {
            var thisVal = $('.pr-password').val();
            var isValid = true;
            if (thisVal.length < 8 || !/[a-z]/.test(thisVal) || !/[A-Z]/.test(thisVal) || !/[0-9]/.test(thisVal)) isValid = false;
            if (!isValid) {
                event.preventDefault();
                toastr.error('Nem teljesülnek a jelszókövetelmények!', 'Validációs hiba!');
            }
        });
    });

});

document.addEventListener('DOMContentLoaded', function () {
    var today = new Date();
    var minAge = 18;
    var maxDate = new Date(today.getFullYear() - minAge, today.getMonth(), today.getDate()).toISOString().split('T')[0];
    document.getElementById('szuldatum').setAttribute('max', maxDate);
});