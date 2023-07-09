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


//ส่วนรับรายการสินค้า
let ALL;
$(document).ready(async function () {
    $('#pay_C').hide()
    let list = []
    let order = JSON.parse(localStorage.getItem('cart'))
    if (!order || order.length == 0 || localStorage.getItem('cart') === null) {
        $('#addtocartTable').html('<tr ><td colspan="7">ไม่มีรายการสินค้า</td></tr>')
        $('#solutionPay').prop("disabled", true);
        $('#mySubmit').prop("disabled", true);
        $('#Delall').prop("disabled", true);
    } else {
        $('#solutionPay').prop("disabled", false);
        $('#mySubmit').prop("disabled", false);
        $('#Delall').prop("disabled", false);
        for (const element of order) {
            let product = await (await fetch(`./controller/GetProduct.php?id=${element.id}`)).json()
            product.quantity = element.quantity
            list.push(product)
        }
        ALL = list
        setUI(list)
    }
});

//ลบรายการสินค้าที่เลือก
function del(id) {
    Swal.fire({
        title: 'คำเตือน',
        text: "คุณต้องการลบรายการสินค้าใช่หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        if (result.isConfirmed) {
            let order = JSON.parse(localStorage.getItem('cart'))
            order = order.filter(e => e.id != id)
            localStorage.setItem('cart', JSON.stringify(order))
            location.reload()
        }
    })
}

//ลบรายการสินค้าที่เลือก
function del2() {
    Swal.fire({
        title: 'คำเตือน',
        text: "คุณต้องการลบรายการสินค้าทั้งหมดใช่หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        if (result.isConfirmed) {
            localStorage.clear()
            location.reload()
            window.location = './productlist.php'
        }
    })
}

//ส่วนชำระเงินสด
const targetElement = document.getElementById('payment_s')
const submitElement = document.getElementById('mySubmit')
targetElement.addEventListener('change', async (e) => {
    if (e.target.value === 'เงินสด') {
        let payment = $("#payment_s").val()
        $('#payment_sl').val(payment)
        submitElement.setAttribute("data-bs-target", ".cash-form");
    } else if (e.target.value === 'โอนผ่านบัญชีธนาคาร') {
        let payment = $("#payment_s").val()
        $('#payment_sl').val(payment)
        submitElement.setAttribute("data-bs-target", ".transfer-form");
    } else if (e.target.value === 'ผ่อนชำระ') {
        let route = (await (await fetch('./controller/GetRolesSales.php')).text()).trim()
        if (route !== "L") {
            submitElement.setAttribute("Swal.fire",
                Swal.fire({
                    width: 1300,
                    title: '<span style="font-size: 40px; color: red;">เฉพาะเจ้าของร้านเท่านั้นที่สามารถเข้าระบบผ่อนชำระได้</span>',
                    icon: 'warning',
                    showDenyButton: true,
                    focusConfirm: false,
                    confirmButtonText: "ออกจากระบบ",
                    denyButtonText: `ยกเลิก`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('./controller/LogOutAndClear.php').then(() => {
                            window.location = "./login.php"
                        })
                    } else if (result.isDenied) {
                        location.reload()
                    }
                }));
        } else {
            submitElement.setAttribute("data-bs-target", ".search-costumer-form");
        }
    }
})


function setUI(data) {
    let allprice = 0
    let allquantity = 0
    $('#addtocartTable').html('')
    data.forEach((element, i) => {
        allprice += Number(element.price) * Number(element.quantity)
        allquantity += Number(element.quantity)
        $('#addtocartTable').append(`<tr style="vertical-align:top;" id="rr${i + 1}" >
        <th style="border-right: 1px;">${i + 1}</th>
        <th style="border-left: 1px; border-right: 1px;">
            <img style="width: 275px; height: 275px; padding-top: 15px; padding-bottom: 15px; padding-left: 15px; padding-right: 15px;" src="${element.product_img}">
        </th>
        <th style="border-left: 1px; border-right: 1px;">${element.product_name}</th>
        <th style="border-left: 1px; border-right: 1px;">${element.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th style="border-left: 1px; border-right: 1px;">${element.quantity.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th style="border-left: 1px; border-right: 1px;">${(Number(element.price) * Number(element.quantity)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th style="border-left: 1px;" >
        <div class="d-flex justify-content-center">
            <button type="button" class="bgs topic_BTAJ" onclick="del(${element.product_id})"><img src="./src/images/icon-delete.png" class="delete" width="30"></button>
        </div>
        <div class="d-flex justify-content-center">
            <a href="./productlist.php" class="bgs topic_BTAJ" ><img src="./src/images/icon-pencil.png" class="edit" width="30"></a>
        </div>
        </th>
    </tr>`)
        $("#allprice").text(allprice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
        $("#all_price").text(allprice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
        $(".all_price").val(allprice.toString())
        $("#allquantity").text(allquantity.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
        $(".all_quantity").val(allquantity.toString())
    });
    console.log(data)
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

///form1
//เงินสด
//ส่วนคำนวณเงินของชำระเงินสด
$('#receivecash').keyup(() => {
    const change = Number($('#receivecash').val()) - Number($(".all_price").val())
    if (change >= 0) {
        $('#change').text(change.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
        $('#pay_C').show()
    } else {
        $('#change').text('')
        $('#pay_C').hide()
    }
})

//ตรวจสอบพร้อมส่งข้อมูล form1
$("#form1").submit(async function (event) {
    event.preventDefault();
    $('#sales').val(JSON.stringify(JSON.parse(localStorage.getItem("cart")).data))
    let response = await fetch('controller/Sales.php', {
        method: 'POST',
        body: new FormData(document.form1)
    });
    console.log(response);
    if (!response.ok) {
        console.log(response);
    } else {
        loopInsert()
        Swal.fire({
            icon: 'success',
            text: 'ทำการขายเสร็จสิ้น',
        }).then(async () => {
            localStorage.clear()
            window.location = 'productlist.php'
        })
    }
});

///form2
//โอนผ่านบัญชีธนาคาร
$("#form2").submit(async function (event) {
    event.preventDefault();
    $('#sales').val(JSON.stringify(JSON.parse(localStorage.getItem("cart")).data))
    let response = await fetch('controller/Sales.php', {
        method: 'POST',
        body: new FormData(document.form2)
    });
    if (!response.ok) {
        console.log(response);
    } else {
        loopInsert()
        Swal.fire({
            icon: 'success',
            text: 'ทำการขายเสร็จสิ้น',
            timer: 3000
        }).then(() => {
            localStorage.clear()
            window.location = 'productlist.php'
        })
    }
});

///form3
//การผ่อนชำระ
//คีย์ข้อมูลลูกค้าเพื่อตรวจสอบ
$("#search").click(async function () {
    let url = `./controller/SalestoContract.php`
    if ($("#keyword").val() !== "") {
        url += `?keyword=${$("#keyword").val()}`
    } else if ($("#keyword").val() === "") {
        url += `?keyword=${$("#keyword").val("")}`
    }
    const keyword = await (await fetch(url)).json()
    if (keyword.length > 0) {
        setU(keyword)
    } else if ((document.form3.keyword.value).length == 13 && keyword.length <= 0) {
        $('#salestocontracttable').html('<br><center><h3>ไม่พบรายการการผ่อนชำระ</h3></center>')
        $('#next-add').attr("href", './addcontract.php')
    } else if (!checkID(document.form3.keyword.value)) {
        Swal.fire({
            icon: 'warning',
            title: 'คำเตือน',
            text: 'ระบุหมายเลขประจำตัวประชาชนไม่ถูกต้อง',
            timer: 3000
        })
        return
    }
});

//ส่วนแสดงผลข้อมูลลูกค้า
async function star() {
    let url = './controller/SalestoContract.php'
    const keyword = await (await fetch(url)).json()
    console.log(keyword);
    setU(keyword)
}


function setU(keyword) {
    let c = 0
    let table = `<table class="col-11 salestocontracttable">
                    <tr>
                        <th width=5%>ลำดับ</th>
                        <th width=16%>วันที่ทำสัญญา</th>
                        <th width=16%>วันที่ครบกำหนดชำระ</th>
                        <th width=14%>สถานะ</th>
                        <th width=17%>คงค้าง</th>
                    </tr>
                    <tbody>`
    keyword.forEach((element, i) => {
        $('#next-add').attr("href", `./addcontract.php?cardID=${element.customer_img}`)
        c++
        if (element.promise_status == 0) {
            table += `<tr id="rr${i + 1}">
        <th class="index-table-bank">${i + 1}</th>
        <th>${convertToDateThai(new Date(element.date_contract))}</th>
        <th>${convertToDateThai(new Date(element.date_due))}</th>
        <th>ไม่เกินกำหนด</th>
        <th>${element.outstanding.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
    </tr>`
        } else if (element.promise_status == 1) {
            table += `<tr id="rr${i + 1}">
        <th class="index-table-bank">${i + 1}</th>
        <th>${element.date_contract}</th>
        <th>${element.date_due}</th>
        <th>เกินกำหนด</th>
        <th>${element.outstanding.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
    </tr>`
        }
    })
    table += '</tbody></table>`'
    $('#salestocontracttable').html(table)
}