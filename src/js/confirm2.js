//เพิ่มสินค้า
$("#addproduct").submit(function (event) {
    event.preventDefault();
    let tableObj = JSON.parse(localStorage.getItem("tableProduct"))
    const i = tableObj.data.length
    if ($('#product_id').val() === "" || $('#order_pr').val() === "" || $('#order_amt').val() === "") {
        $('#addtable').blur()
        return
    }
    $('#list-product').append(`<tr id="rr${i + 1}">
                    <th class="index-table-product">${i + 1}</th>
                    <th>${$('#product_name').val() || $("#product_id option:selected").text()}</th>
                    <th>${Number($('#order_pr').val())}</th>
                    <th>${Number($('#order_amt').val())}</th>
                    <th>${Number($('#order_pr').val()) * Number($('#order_amt').val())}</th>
                    <th>
                        <button type="button" class="btn1 " data-bs-toggle="modal" data-bs-target="#exampleModal"><img src="./src/images/icon-delete.png" width="25" onclick="saveIndexDel(${i})"></button>
                        <button type="button" class="btn1" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl"><img src="./src/images/icon-pencil.png" width="25" onclick="saveIndexEdit(${i})"></button>
                    </th>
                </tr>`)
    $('#addclose').click()
    tableObj.data.push({
        list: Number($('#product_id').val()),
        price: Number($('#order_pr').val()),
        amount: Number($('#order_amt').val()),
        allPrice: Number($('#order_pr').val()) * Number($('#order_amt').val()),
        id: Number(-1),
    })
    localStorage.setItem("tableProduct", JSON.stringify(tableObj))
    $('#product_id').val("")
    $('#order_pr').val("")
    $('#order_amt').val("")
    getAllprice()

});

//กำหนดแถวที่จะลบ
function saveIndexDel(i) {
    localStorage.setItem('deleteIndex', i)
}

//กำหนดแถวที่จะแก้ไข พร้อมข้อมูลเริ่มต้น
function saveIndexEdit(i) {
    localStorage.setItem('editIndex', i)
    let rows = (JSON.parse(localStorage.getItem("tableProduct"))).data
    $('#editproduct_id').val(rows[i].list)
    $('#editorder_pr').val(rows[i].price)
    $('#editorder_amt').val(rows[i].amount)
    $('#editall_price_odr').val(rows[i].allPrice)
}

//ลบแถวสินค้า
function delrow() {
    let tableObj = JSON.parse(localStorage.getItem("tableProduct"))
    const index = localStorage.getItem('deleteIndex')
    let rows = tableObj.data
    rows.splice(index, 1)
    $('#list-product').html("")
    rows.forEach((e, i) => {
        $('#list-product').append(`<tr id="rr${i + 1}">
                    <th class="index-table-product">${i + 1}</th>
                    <th>${Number(e.list)}</th>
                    <th>${Number(e.price)}</th>
                    <th>${Number(e.amount)}</th>
                     <th>${Number(e.price) * Number(e.amount)}</th>
                    <th>
                        <button type="button" class="bgs" data-bs-toggle="modal" data-bs-target="#exampleModal"><img src="./src/images/icon-delete.png" width="25" onclick="saveIndexDel(${i})"></button>
                        <button type="button" class="bgs" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl"><img src="./src/images/icon-pencil.png" width="25" onclick="saveIndexEdit(${i})"></button>
                    </th>
                </tr>`)
    });
    tableObj.data = rows
    localStorage.setItem("tableProduct", JSON.stringify(tableObj))
    localStorage.removeItem('deleteIndex')
    $('#closedelrow').click()
    getAllprice()
}

//แก้ไขสินค้า
$("#editaddproduct").submit(function (event) {
    event.preventDefault();
    let tableObj = JSON.parse(localStorage.getItem("tableProduct"))
    const index = localStorage.getItem('editIndex')
    tableObj.data[index] = {
        list: $('#editproduct_id').val(),
        price: $('#editorder_pr').val(),
        amount: $('#editorder_amt').val(),
        expdate: $('#editexp_date').val(),
        allPrice: $('#editall_price_odr').val(),
        id: tableObj.data[index].id,
    }
    localStorage.setItem("tableProduct", JSON.stringify(tableObj))
    let rows = tableObj.data
    $('#list-product').html("")
    rows.forEach((e, i) => {
        $('#list-product').append(`<tr id="rr${i + 1}">
                    <th class="index-table-product">${i + 1}</th>
                    <th>${e.list}</th>
                    <th>${e.price}</th>
                    <th>${e.amount}</th>
                    <th>${Number(e.price) * Number(e.amount)}</th>
                    <th>${e.expdate}</th>
                    <th>
                        <button type="button" class="bgs" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl"><img src="./src/images/icon-pencil.png" width="25" onclick="saveIndexEdit(${i})"></button>
                    </th>
                </tr>`)
    });
    localStorage.setItem("tableProduct", JSON.stringify(tableObj))
    localStorage.removeItem('editIndex')
    $('#editclose').click()
    getAllprice()
})

$("#payment_sl").change(function () {
    if ($("#payment_sl").val() === 'เครดิต') {
        $("#slipupload").show()
    } else {
        $("#slipupload").hide()
    }
});

let ALLPrice = 0;
let A = 0;
function getAllprice() {
    ALLPrice = 0
    A = 0
    let tableObj = (JSON.parse(localStorage.getItem("tableProduct"))).data
    for (const element of tableObj) {
        A += Number(element.amount)
        ALLPrice += Number(element.price) * Number(element.amount)

    }
    let tableObj2 = (JSON.parse(localStorage.getItem("tablePrice"))).data
    for (const element of tableObj2) {
        ALLPrice += Number(element.priceOther)
    }
    $("#all_amount_odr").val(A)
    $("#all_price_odr").val(ALLPrice)
    $("#all_price_odr_text").text(ALLPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
}
$(document).ready(async function () {
    getAllprice()
});

async function loopexp() {
    let lastID = await (await fetch('controller/GetLastIdOrder.php')).text()
    let rows = (JSON.parse(localStorage.getItem("tableProduct"))).data
    for (let d of rows) {
        if(d.expdate != "" ) {
            var formdata = new FormData();
            formdata.append("order_id", $("#order_id").val());
            formdata.append("product_id", Number(d.list));
            formdata.append("amount_exp", Number(d.amount));
            formdata.append("exp_date", d.expdate);
            formdata.append("form_action", "insert");
            formdata.append("table", "stock");
            var requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };
            await fetch("controller/Stock.php", requestOptions)
        }
    }
}

async function loopcostprice() {
    let rows = (JSON.parse(localStorage.getItem("tableProduct"))).data
    for (let d of rows) {
        var formdata = new FormData();
        formdata.append("order_id", $("#order_id").val());
        formdata.append("product_id", Number(d.list));
        formdata.append("cost_price", Number(d.price));
        formdata.append("form_action", "insert");
        formdata.append("table", "costprice");
        var requestOptions = {
            method: 'POST',
            body: formdata,
            redirect: 'follow'
        };
        await fetch("controller/CostPrice.php", requestOptions)
    }
}

//ตรวจสอบพร้อมส่งข้อมูล
$("#form1").submit(async function (event) {
    event.preventDefault();
    if (!$('#order_status').is(":checked")) {
        Swal.fire({
            icon: 'warning',
            title: 'คำเตือน',
            text: 'กรุณายืนยันสถานะ',
            timer: 2000
        })
        return
    } else {
        let response = await fetch('controller/Order.php', {
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
            }).then(async () => {
                await loopcostprice()
                await loopexp()
                localStorage.clear()
                window.location = './order.php'

            })
        }
    }
});