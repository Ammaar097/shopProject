//email
function check_email(elm) {
    var regex_email = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*\@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.([a-zA-Z]){2,4})$/
    if (!elm.value.match(regex_email)) {
        alert('รูปแบบ email ไม่ถูกต้อง');
    }
}

//password
function check_num(elm) {
    var regex_num = /^\s*\S+(\s?\S)*\s*$/
    if (elm.value.length < 6 || elm.value.length > 15 && !elm.value.match(regex_num)) {
        alert("จำนวนตัวอักษรหรือตัวเลขอยู่ช่วง 6-15 ตัวเท่านั้น");
    }
}

async function readEmail() {
    const id = document.getElementById('employee_id').value
    const employee = await (await fetch(`./controller/LoadEmail.php?id=${id}`)).json()
    const email = employee.employee_email
    document.getElementById('account_username').value = email
}

$("#form1").submit(async function (event) {
    event.preventDefault();
    Swal.fire({
        title: 'คำเตือน',
        text: "คุณต้องการเพิ่มบัญชีผู้ใช้หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    })
});