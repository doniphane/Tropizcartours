
function checkPasswordStrength() {
    var strengthBar = document.getElementById("strengthBar");
    var password = document.getElementsByName("password")[0].value;
    var strength = 0;
    if (password.match(/[a-zA-Z0-9][a-zA-Z0-9]+/)) {
        strength += 1;
    }
    if (password.match(/[~<>?]+/)) {
        strength += 1;
    }
    if (password.match(/[!@#$%^&*()]+/)) {
        strength += 1;
    }
    if (password.length > 6) {
        strength += 1;
    }
    strengthBar.value = strength;
}

