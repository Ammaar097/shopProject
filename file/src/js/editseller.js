//เบอร์โทรศัพท์
function autoTab2(obj) {
    var pattern = new String("___-_______");
    var pattern_ex = new String("-");
    var returnText = new String("");
    var obj_l = obj.value.length;
    var obj_l2 = obj_l - 1;
    for (i = 0; i < pattern.length; i++) {
        if (obj_l2 == i && pattern.charAt(i + 1) == pattern_ex) {
            returnText += obj.value + pattern_ex;
            obj.value = returnText;
        }
    }
    if (obj_l >= pattern.length) {
        obj.value = obj.value.substr(0, pattern.length);
    }
}

function autoTab2(obj) {
    var pattern = new String("___-_______");
    var pattern_ex = new String("-");
    var returnText = new String("");
    var obj_l = obj.value.length;
    var obj_l2 = obj_l - 1;
    for (i = 0; i < pattern.length; i++) {
        if (obj_l2 == i && pattern.charAt(i + 1) == pattern_ex) {
            returnText += obj.value + pattern_ex;
            obj.value = returnText;
        }
    }
    if (obj_l >= pattern.length) {
        obj.value = obj.value.substr(0, pattern.length);
    }
}

//เช็คอีเมล
function check_email(elm) {
    var regex_email = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*\@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.([a-zA-Z]){2,4})$/
    return elm.match(regex_email)
}

//เช็คจำนวนรหัสผ่าน
function check_num(elm) {
    var regex_num = /^\s*\S+(\s?\S)*\s*$/
    if (elm.value.length < 6 || elm.value.length > 15 && !elm.value.match(regex_num)) {
        alert("จำนวนตัวอักษรหรือตัวเลขอยู่ช่วง 6-15 ตัวเท่านั้น");
    }
}

//ตรวจสอบเบอร์โทรศัพท์
function telephone1(inputtxt) {
    var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    if (inputtxt.match(phoneno)) {
        return true;
    }
    return false;
}

function telephone2(inputtxt) {
    var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    if (inputtxt.match(phoneno)) {
        return true;
    }
    return false;
}


//เพิ่มบัญชี
$("#addbankaccount").submit(function (event) {
    event.preventDefault();
    let tableObj = JSON.parse(localStorage.getItem("tableBank"))
    const i = tableObj.data.length
    if ($('#bank_name').val() === "" || $('#bank_number').val() === "" || $('#bank_account').val() === "") {
        $('#addtable').blur()
        return
    }
    $('#banktable').append(`<tr id="rr${i + 1}">
    <th class="index-table-bank">${i + 1}</th>
    <th>${$('#bank_name').val()}</th>
    <th>${$('#bank_number').val()}</th>
    <th>${$('#bank_account').val()}</th>
    <th>
    <button type="button" class="bgs" data-bs-toggle="modal" data-bs-target="#exampleModal"><img src="./src/images/icon-delete.png" width="25" onclick="saveIndexDel(${i})"></button>
    <button type="button" class="bgs" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm"><img src="./src/images/icon-pencil.png" width="25" onclick="saveIndexEdit(${i})"></button>
    </th>
                </tr>`)
    $('#addclose').click()
    tableObj.data.push({
        bank: $('#bank_name').val(),
        number: $('#bank_number').val(),
        name: $('#bank_account').val(),
        id: -1
    })
    localStorage.setItem("tableBank", JSON.stringify(tableObj))
    $('#bank_name').val("")
    $('#bank_number').val("")
    $('#bank_account').val("")
});

//แก้ไขบัญชี
$("#editbankaccount").submit(function (event) {
    event.preventDefault();
    let tableObj = JSON.parse(localStorage.getItem("tableBank"))
    const index = localStorage.getItem('editIndex')
    tableObj.data[index] = {
        bank: $('#editbank_name').val(),
        number: $('#editbank_number').val(),
        name: $('#editbank_account').val(),
        id: tableObj.data[index].id
    }
    localStorage.setItem("tableBank", JSON.stringify(tableObj))
    let rows = tableObj.data
    $('#banktable').html("")
    rows.forEach((e, i) => {
        $('#banktable').append(`<tr id="rr${i + 1}">
                    <th class="index-table-bank">${i + 1}</th>
                    <th>${e.bank}</th>
                    <th>${e.number}</th>
                    <th>${e.name}</th>
                    <th>
                    <button type="button" class="bgs" data-bs-toggle="modal" data-bs-target="#exampleModal"><img src="./src/images/icon-delete.png" width="25" onclick="saveIndexDel(${i})"></button>
                    <button type="button" class="bgs" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm"><img src="./src/images/icon-pencil.png" width="25" onclick="saveIndexEdit(${i})"></button>
                    </th>
                </tr>`)
    });
    localStorage.setItem("tableBank", JSON.stringify(tableObj))
    localStorage.removeItem('editIndex')
    $('#editclose').click()


})

//กำหนดแถวที่จะลบ บัญชี
function saveIndexDel(i) {
    localStorage.setItem('deleteIndex', i)
}
//กำหนดแถวที่จะแก้ไข พร้อมข้อมูลเริ่มต้น บัญชี
function saveIndexEdit(i) {
    localStorage.setItem('editIndex', i)
    let rows = (JSON.parse(localStorage.getItem("tableBank"))).data
    $('#editbank_name').val(rows[i].bank)
    $('#editbank_number').val(rows[i].number)
    $('#editbank_account').val(rows[i].name)
}

//ลบแถวบัญชี
function delrow() {
    let tableObj = JSON.parse(localStorage.getItem("tableBank"))
    const index = localStorage.getItem('deleteIndex')
    let rows = tableObj.data
    rows.splice(index, 1)
    $('#banktable').html("")
    rows.forEach((e, i) => {
        $('#banktable').append(`<tr id="rr${i + 1}">
                    <th class="index-table-bank">${i + 1}</th>
                    <th>${e.bank}</th>
                    <th>${e.number}</th>
                    <th>${e.name}</th>
                    <th>
                    <button type="button" class="bgs" data-bs-toggle="modal" data-bs-target="#exampleModal"><img src="./src/images/icon-delete.png" width="25" onclick="saveIndexDel(${i})"></button>
                    <button type="button" class="bgs" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm"><img src="./src/images/icon-pencil.png" width="25" onclick="saveIndexEdit(${i})"></button>
                    </th>
                </tr>`)
    });
    tableObj.data = rows
    localStorage.setItem("tableBank", JSON.stringify(tableObj))
    localStorage.removeItem('deleteIndex')
    $('#closedelrow').click()
}

//ตรวจสอบพร้อมส่งข้อมูล
$("#form1").submit(async function (event) {
    event.preventDefault();
    if (JSON.parse(localStorage.getItem("tableBank")).data.length <= 0) {
        event.preventDefault();
        alert('กรุณากรอกข้อมูลบัญชีธนาคาร');
        return
    }
    if (!telephone2(document.form1.seller_telephone.value)) {
        event.preventDefault();
        alert('เบอร์โทรศัพท์ไม่ถูกต้อง');
        return
    }
    if (!telephone1(document.form1.sell_telephone.value)) {
        event.preventDefault();
        alert('เบอร์โทรศัพท์ไม่ถูกต้อง');
        return
    }
    if (!check_email(document.form1.seller_email.value)) {
        event.preventDefault();
        alert('อีเมลไม่ถูกต้อง');
        return
    } else {

        $('#bank').val(JSON.stringify(JSON.parse(localStorage.getItem("tableBank")).data))
        event.preventDefault();
        let response = await fetch('controller/Sell.php', {
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
                timer: 3000
            })
            window.location.assign("sall.php");
        }
    }

});