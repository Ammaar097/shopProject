let ALL;
let AllPrice = 0;
let AllQuantity = 0;
$(document).ready(async function () {
    let price = 0
    let baht_text = ""
    let text = ""
    let baht = 0
    let stang = 0
    let list = []
    let order = JSON.parse(localStorage.getItem('cart'))
    if (!(!order || order.length == 0 || localStorage.getItem('cart') === null)) {
        for (const element of order) {
            let product = await (await fetch(`./controller/GetProduct.php?id=${element.id}`)).json()
            price += Number(product.price) * Number(element.quantity)
            text += product.product_name + '&#13;&#10;'
            product.quantity = element.quantity
            AllQuantity += element.quantity
            list.push(product)
        }
        ALL = list
        AllPrice = price
        baht = Number((price + '').split('.')[0])
        stang = Number((price + '').split('.')[1]) ? Number((price + '').split('.')[1]) : 0
        baht_text = bahttext(price)
        $("#product_detail").html(text)
        $("#baht").val(baht)
        $("#stang").val(stang)
        $("#stang").text(stang)
        $("#stangt").val(baht_text)

    }
});

async function setStatus(id) {
    const status = $("#S" + id).is(':checked');
    console.log(await (await fetch(`./controller/SetEmployeeStatus.php?status=${status}&id=${id}`)))
}

function validateForm() {
    if (document.getElementById('namecustomer').value == "") {
        alert('กรุณากรอกข้อมูล');
        return false;
    }
}

//บัตรประชาชน
function autoTab(obj) {
    var pattern = new String("_____________"); // กำหนดรูปแบบในนี้
    var pattern_ex = new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้
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
    let id = document.form3.keyword.value.split(/ /)[0].replace(/[^\d]/g, '')
}

//เช็คเลข13หลัก
function checkID(id) {
    //alert(id);
    id = id.replace(/-/g, "");
    //alert(id);
    if (id.length != 13) return false;
    for (i = 0, sum = 0; i < 12; i++) {
        sum += parseInt(id.charAt(i)) * (13 - i);
    }
    let mod = sum % 11;
    let check = (11 - mod) % 10;
    if (check == parseInt(id.charAt(12))) {
        return true;
    }
    return false;
}

async function loopInsert() {
    let lastID = await (await fetch('controller/GetLastIdSales.php')).text()
    let data = JSON.parse(localStorage.getItem('cart'))
    for (const e of data) {
        var formdata = new FormData();
        let objData = ALL.filter(d => d.product_id == e.id);
        console.log("objData:", objData)
        formdata.append("sales_list_id", lastID);
        formdata.append("product_id", e.id);
        formdata.append("sales_amt", e.quantity);
        formdata.append("sales_pr", objData[0].price * e.quantity);
        formdata.append("form_action", "insert");
        formdata.append("table", "salesdetails");
        var requestOptions = {
            method: 'POST',
            body: formdata,
            redirect: 'follow'
        };
        await fetch("controller/SalesDetails.php", requestOptions)
        var formdata1 = new FormData();
        formdata1.append("q", e.quantity);
        formdata1.append("product_id", e.id);
        formdata1.append("form_action", "cut");
        formdata1.append("table", "product");
        var requestOptions = {
            method: 'POST',
            body: formdata1,
            redirect: 'follow'
        };
        await fetch("controller/Product.php", requestOptions)
        if (!!e.stock_id) {
            var formdata2 = new FormData();
            formdata2.append("q", e.quantity);
            formdata2.append("stock_id", e.stock_id);
            formdata2.append("form_action", "cut");
            formdata2.append("table", "stock");
            var requestOptions = {
                method: 'POST',
                body: formdata2,
                redirect: 'follow'
            };
            await fetch("controller/Stock.php", requestOptions)
        }
    }
}

$("#form1").submit(async function (event) {
    event.preventDefault();
    if ($("#customer_prefix").val() == "all") {
        Swal.fire({
            icon: 'warning',
            title: 'คำเตือน',
            text: 'กรุณาเลือกคำนำหน้า',
            timer: 2000
        })
        return
    }
    if ($("#sell_id").val() == "all") {
        Swal.fire({
            icon: 'warning',
            title: 'คำเตือน',
            text: 'กรุณาเลือกผู้ขาย',
            timer: 2000
        })
        return
    }
    if (!checkID(document.form1.customer_img.value)) {
        Swal.fire({
            icon: 'warning',
            title: 'คำเตือน',
            text: 'ระบุหมายเลขประจำตัวประชาชนไม่ถูกต้อง',
            timer: 3000
        })
        return
    } else {
        event.preventDefault();
        let employee_id = await (await fetch('./controller/GetEmployeeID.php')).text()
        var formdata = new FormData();
        formdata.append("payment_sl", "ผ่อนชำระ");
        formdata.append("all_price", AllPrice);
        formdata.append("all_quantity", AllQuantity);
        formdata.append("employee_id", employee_id);
        formdata.append("form_action", "insert");
        formdata.append("table", "sales");
        await fetch('controller/Sales.php', {
            method: 'POST',
            body: formdata
        })
        let lastID1 = await (await fetch('controller/GetLastIdSales.php')).text()
        $("#sales_list_id").val(lastID1)
        await fetch('controller/Contract.php', {
            method: 'POST',
            body: new FormData(document.form1)
        })
        loopInsert()
        let lastID = await (await fetch('controller/GetLastIdContract.php')).text()
        var formdata1 = new FormData();
        formdata1.append("contract_code", lastID);
        formdata1.append("outstanding", AllPrice);
        formdata1.append("form_action", "insertInit");
        formdata1.append("table", "debtPaymentDetails");
        await fetch('controller/DebtPaymentDetails.php', {
            method: 'POST',
            body: formdata1
        })
        Swal.fire({
            icon: 'success',
            text: 'บันทึกข้อมูลเสร็จสิ้น',
        }).then(() => {
            localStorage.clear()
            window.location = './contracthistory.php'
        })
    }
});