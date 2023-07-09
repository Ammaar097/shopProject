$("#payment_sl").change(function () {
    if ($("#payment_sl").val() === 'เครดิต') {
        $("#creditupload").show()
    } else {
        $("#creditupload").hide()
    }
});

async function madeoption(){
    let url = './controller/ProductResult.php'
    const product = await (await fetch(url)).json()
    let data = JSON.parse(localStorage.getItem("tableProduct")).data
    $('#product_id').html('')
    product.forEach(e=>{
        if(data.findIndex(element => element.list == e.product_id) ==-1){
            $('#product_id').append(`<option value="${e['product_id']}">${e['product_name']}</option>`)
        }
    })
}
async function Editmadeoption(list){
    let url = './controller/ProductResult.php'
    const product = await (await fetch(url)).json()
    let data = JSON.parse(localStorage.getItem("tableProduct")).data
    $('#editproduct_id').html('')
    let temp = []
    product.forEach(e=>{
        if(data.findIndex(element => (element.list == e.product_id)&&element.list!=list) == -1){
            temp.push({value:e.product_id,name:e.product_name})
        }
    })
    temp = temp.sort(function(x,y){ return x.value == list ? -1 : y.value == list ? 1 : 0; });
    temp.forEach((e,i)=>{
        if(i===0){
            $('#editproduct_id').append(`<option selected value="${e['value']}">${e['name']}</option>`)
        }
        else{
            $('#editproduct_id').append(`<option value="${e['value']}">${e['name']}</option>`)
        }
    })
}
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
                    <th>${$("#product_id option:selected").text()}</th>
                    <th>${$('#order_pr').val().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
                    <th>${$('#order_amt').val().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
                    <th>${(Number($('#order_pr').val()) * Number($('#order_amt').val())).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
                    <th>
                        <button type="button" class="btn1 " data-bs-toggle="modal" data-bs-target="#exampleModal"><img src="./src/images/icon-delete.png" width="25" onclick="saveIndexDel(${i},${-1})"></button>
                        <button type="button" class="btn1" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl"><img src="./src/images/icon-pencil.png" width="25" onclick="saveIndexEdit(${i})"></button>
                    </th>
                </tr>`)
    $('#addclose').click()
    tableObj.data.push({
        name: $("#product_id option:selected").text(),
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
function saveIndexDel(i,id) {
    localStorage.setItem('deleteIndex', i)
    localStorage.setItem('deleteID', id)
}

//กำหนดแถวที่จะแก้ไข พร้อมข้อมูลเริ่มต้น
function saveIndexEdit(i) {
    localStorage.setItem('editIndex', i)
    let rows = (JSON.parse(localStorage.getItem("tableProduct"))).data
    Editmadeoption(rows[i].list)
    $('#editproduct_id').val(rows[i].list).change()
    $('#editorder_pr').val(rows[i].price)
    $('#editorder_amt').val(rows[i].amount)
    $('#editall_price_odr').val(rows[i].allPrice)
}

//ลบแถวสินค้า
function delrow() {
    let tableObj = JSON.parse(localStorage.getItem("tableProduct"))
    const index = localStorage.getItem('deleteIndex')
    const id = localStorage.getItem('deleteID')
    if(id!=-1){
        deleteproduct(id)
    }
    let rows = tableObj.data
    rows.splice(index, 1)
    $('#list-product').html("")
    rows.forEach((e, i) => {
        $('#list-product').append(`<tr id="rr${i + 1}">
                    <th class="index-table-product">${i + 1}</th>
                    <th>${e.name}</th>
                    <th>${e.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
                    <th>${e.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
                     <th>${(Number(e.price) * Number(e.amount)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
                    <th>
                        <button type="button" class="bgs" data-bs-toggle="modal" data-bs-target="#exampleModal"><img src="./src/images/icon-delete.png" width="25" onclick="saveIndexDel(${i},${e.id})"></button>
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
    console.log(tableObj.data[index]);
    tableObj.data[index] = {
        name:$("#editproduct_id option:selected").text(),
        list: $('#editproduct_id').val(),
        price: $('#editorder_pr').val(),
        amount: $('#editorder_amt').val(),
        id: tableObj.data[index].id,
    }
    localStorage.setItem("tableProduct", JSON.stringify(tableObj))
    let rows = tableObj.data
    $('#list-product').html("")
    rows.forEach((e, i) => {
        $('#list-product').append(`<tr id="rr${i + 1}">
                    <th class="index-table-product">${i + 1}</th>
                    <th>${e.name}</th>
                    <th>${e.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
                    <th>${e.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
                    <th>${(Number(e.price) * Number(e.amount)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
                    <th>
                        <button type="button" class="bgs" data-bs-toggle="modal" data-bs-target="#exampleModal"><img src="./src/images/icon-delete.png" width="25" onclick="saveIndexDel(${i},${e.id})"></button>
                        <button type="button" class="bgs" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl"><img src="./src/images/icon-pencil.png" width="25" onclick="saveIndexEdit(${i})"></button>
                    </th>
                </tr>`)
    });
    localStorage.setItem("tableProduct", JSON.stringify(tableObj))
    localStorage.removeItem('editIndex')
    $('#editclose').click()
    getAllprice()

})

//เพิ่มรายการอื่นๆ
$("#addprice").submit(function (event) {
    event.preventDefault();
    let tableObj = JSON.parse(localStorage.getItem("tablePrice"))
    const i = tableObj.data.length
    if ($('#listother').val() === "" || $('#priceother').val() === "") {
        $('#addtable2').blur()
        return
    }
    $('#list-priceother').append(`<tr id="rr${i + 1}">
                    <th class="index-table-price">${i + 1}</th>          
                    <th>${$('#listother').val()}</th>
                    <th>${$('#priceother').val().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
                    <th>
                        <button type="button" class="btn1 " data-bs-toggle="modal" data-bs-target="#exampleModalother"><img src="./src/images/icon-delete.png" width="25" onclick="saveIndexDel1(${i},${-1})"></button>
                        <button type="button" class="btn1" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm4"><img src="./src/images/icon-pencil.png" width="25" onclick="saveIndexEdit1(${i})"></button>
                    </th>
                </tr>`)
    $('#addcloseother').click()
    tableObj.data.push({
        listOther: $('#listother').val(),
        priceOther: $('#priceother').val(),
        id: -1,

    })
    localStorage.setItem("tablePrice", JSON.stringify(tableObj))
    $('#listother').val("")
    $('#priceother').val("")
    getAllprice()

});

//กำหนดแถวที่จะลบ
function saveIndexDel1(i,id) {
    localStorage.setItem('deleteIndex1', i)
    localStorage.setItem('deleteID1', id)
}

//กำหนดแถวที่จะแก้ไข พร้อมข้อมูลเริ่มต้น
function saveIndexEdit1(i) {
    localStorage.setItem('editIndex1', i)
    let rows = (JSON.parse(localStorage.getItem("tablePrice"))).data
    $('#editlistother').val(rows[i].listOther)
    $('#editpriceother').val(rows[i].priceOther)
}

//ลบแถว
function delrow2() {
    let tableObj = JSON.parse(localStorage.getItem("tablePrice"))
    const index = localStorage.getItem('deleteIndex1')
    const id = localStorage.getItem('deleteID1')
    if(id!=-1){
        deleteother(id)
    }
    let rows = tableObj.data
    rows.splice(index, 1)
    $('#list-priceother').html("")
    rows.forEach((e, i) => {
        $('#list-priceother').append(`<tr id="rr${i + 1}">
                    <th class="index-table-price">${i + 1}</th>   
                    <th>${e.listOther}</th>
                    <th>${e.priceOther.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
                    <th>
                    <button type="button" class="btn1 " data-bs-toggle="modal" data-bs-target="#exampleModalother"><img src="./src/images/icon-delete.png" width="25" onclick="saveIndexDel1(${i},${e.id})"></button>
                        <button type="button" class="btn1" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm4"><img src="./src/images/icon-pencil.png" width="25" onclick="saveIndexEdit1(${i})"></button>
                    </th>
                </tr>`)
    });
    tableObj.data = rows
    localStorage.setItem("tablePrice", JSON.stringify(tableObj))
    localStorage.removeItem('deleteIndex1')
    localStorage.removeItem('deleteID1')
    $('#closedelrow2').click()
    getAllprice()
}

//แก้ไข
$("#editaddprice").submit(function (event) {
    event.preventDefault();
    let tableObj = JSON.parse(localStorage.getItem("tablePrice"))
    const index = localStorage.getItem('editIndex1')
    tableObj.data[index] = {
        listOther: $('#editlistother').val(),
        priceOther: $('#editpriceother').val(),
        id: tableObj.data[index].id,
    }
    localStorage.setItem("tablePrice", JSON.stringify(tableObj))
    let rows = tableObj.data
    $('#list-priceother').html("")
    rows.forEach((e, i) => {
        $('#list-priceother').append(`<tr id="rr${i + 1}">
        <th class="index-table-price">${i + 1}</th>   
        <th>${e.listOther}</th>
        <th>${e.priceOther.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th>
        <button type="button" class="btn1 " data-bs-toggle="modal" data-bs-target="#exampleModalother"><img src="./src/images/icon-delete.png" width="25" onclick="saveIndexDel1(${i},${e.id})"></button>
        <button type="button" class="btn1" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm4"><img src="./src/images/icon-pencil.png" width="25" onclick="saveIndexEdit1(${i})"></button>
        </th>
        </tr>`)
    });
    localStorage.setItem("tablePrice", JSON.stringify(tableObj))
    localStorage.removeItem('editIndex1')
    $('#editaddcloseother').click()
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

async function deleteproduct(id) {
        var formdata = new FormData();
        formdata.append("unique_id", id);
        formdata.append("form_action", "delete");
        formdata.append("table", "orderdetails");
        var requestOptions = {
            method: 'POST',
            body: formdata,
            redirect: 'follow'
        };
        await fetch("controller/OrderDetails.php", requestOptions)
}

async function deleteother(id) {
    var formdata = new FormData();
    formdata.append("unique_id", id);
    formdata.append("form_action", "delete");
    formdata.append("table", "otherprice");
    var requestOptions = {
        method: 'POST',
        body: formdata,
        redirect: 'follow'
    };
    await fetch("controller/OtherPrice.php", requestOptions)
}

async function insertproduct() {
    let rows = (JSON.parse(localStorage.getItem("tableProduct"))).data
    for (let d of rows) {
        if(d.id ==-1) {
            var formdata = new FormData();
            formdata.append("order_id", $("#order_id").val());
            formdata.append("product_id", Number(d.list));
            formdata.append("order_amt", Number(d.price));
            formdata.append("order_pr", Number(d.amount));
            formdata.append("form_action", "insert");
            formdata.append("table", "orderdetails");
            var requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };
            await fetch("controller/OrderDetails.php", requestOptions)
        }
    }
}

async function insertother() {
    let rows = (JSON.parse(localStorage.getItem("tablePrice"))).data
    for (let d of rows) {
        if(d.id ==-1) {
            var formdata = new FormData();
            formdata.append("order_id", $("#order_id").val());
            formdata.append("listother", d.listOther);
            formdata.append("priceother", Number(d.priceOther));
            formdata.append("form_action", "insert");
            formdata.append("table", "otherprice");
            var requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };
            await fetch("controller/OtherPrice.php", requestOptions)
        }
    }
}

async function loopproduct() {
    let rows = (JSON.parse(localStorage.getItem("tableProduct"))).data
    for (let d of rows) {
        if(d.id != -1) {
            var formdata = new FormData();
            formdata.append("order_id", $("#order_id").val());
            formdata.append("product_id", Number(d.list));
            formdata.append("order_amt", Number(d.price));
            formdata.append("order_pr", Number(d.amount));
            formdata.append("unique_id", d.id);
            formdata.append("form_action", "update");
            formdata.append("table", "orderdetails");
            var requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };
            await fetch("controller/OrderDetails.php", requestOptions)
        }
    }
}

async function loopother() {
    let rows = (JSON.parse(localStorage.getItem("tablePrice"))).data
    for (let d of rows) {
        if(d.id != -1) {
            var formdata = new FormData();
            formdata.append("order_id", $("#order_id").val());
            formdata.append("listother", d.listOther);
            formdata.append("priceother", Number(d.priceOther));
            formdata.append("unique_id", d.id);
            formdata.append("form_action", "update");
            formdata.append("table", "otherprice");
            var requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };
            await fetch("controller/OtherPrice.php", requestOptions)
        }
    }
}


//ตรวจสอบพร้อมส่งข้อมูล
$("#form1").submit(async function (event) {
    event.preventDefault();
    if ($("#sell_id").val() == "all") {
        Swal.fire({
            icon: 'warning',
            title: 'คำเตือน',
            text: 'กรุณาเลือกผู้ขาย',
            timer: 2000
        })
        return
    }
    if ($("#payment_sl").val() == "all") {
        Swal.fire({
            icon: 'warning',
            title: 'คำเตือน',
            text: 'กรุณาเลือกวิธีการชำระ',
            timer: 2000
        })
        return
    }
    if (JSON.parse(localStorage.getItem("tableProduct")).data.length <= 0) {
        Swal.fire({
            icon: 'warning',
            title: 'คำเตือน',
            text: 'กรุณาเพิ่มสินค้า',
            timer: 2000
        })
        return
    } else {
        event.preventDefault();
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
                await loopproduct()
                await loopother()
                await insertproduct()
                await insertother()
                localStorage.clear()
                window.location = './order.php'

            })
        }
    }
});