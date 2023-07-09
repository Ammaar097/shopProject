function validateForm() {
    if (document.getElementById('namecustomer').value == "") {
        alert('กรุณากรอกข้อมูล');
        return false;
    }
}

//บัตรประชาชน

function checkID(id) {
    if (id.length != 13) return false;
    for (i = 0, sum = 0; i < 12; i++)
        sum += parseFloat(id.charAt(i)) * (13 - i); if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12)))
        return false; return true;
}

$("#form1").submit(async function (event) {
    event.preventDefault();
    if (!checkID(document.form1.customer_img.value)) {
        alert('ระบุหมายเลขประจำตัวประชาชนไม่ถูกต้อง');
        return
    } else {
        event.preventDefault();
        let response = await fetch('controller/Contract.php', {
            method: 'POST',
            body: new FormData(document.form1)
        });
        console.log(response);
        if (!response.ok) {
            console.log(response);
        } else {
            await Swal.fire({
                icon: 'success',
                text: 'บันทึกข้อมูลเสร็จสิ้น',
            })
            console.log(await response.text());
            window.location.assign("contracthistory.php");
        }
    }
});