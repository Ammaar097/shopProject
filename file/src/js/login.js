document.getElementById("togglePassword").addEventListener('click', function (e) {
    // toggle the type attribute
    const type = document.getElementById("password").getAttribute('type') === 'password' ? 'text' : 'password';
    document.getElementById("password").setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('bi-eye');
});

//email
function check_email(elm) {
    var regex_email = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*\@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.([a-zA-Z]){2,4})$/
    if (!elm.value.match(regex_email)) {
        alert('รูปแบบ email ไม่ถูกต้อง');
    }
}

//password
function check_num(elm) {
    if (elm.value.length < 6 || elm.value.length > 15) {
        alert("จำนวนตัวอักษรหรือตัวเลขอยู่ช่วง 6-15 ตัวเท่านั้น");
    }
}
