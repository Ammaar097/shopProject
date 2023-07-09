/*$("#category_id").change(async function () {
    if ($("#category_id").val() !== "all") {
        let url = `./controller/ExpireProduct.php?category_id=${$("#category_id").val()}`
        if ($("#keyword").val() !== "") {
            url += `&keyword=${$("#keyword").val()}`
        }
        if($("#date").val() !== ''){
            url += `&date=${$("#date").val()}`
        }
        const product = await (await fetch(url)).json()
        setUI(product)
    } else {
        let url = './controller/ExpireProduct.php'
        if ($("#keyword").val() !== "") {
            url += `?keyword=${$("#keyword").val()}`
        }
        if($("#date").val() !== ''){
            url += `&date=${$("#date").val()}`
        }
        const product = await (await fetch(url)).json()
        setUI(product)
    }
});

$("#keyword").keyup(async function () {
    let url = `./controller/ExpireProduct.php`
    if($("#keyword").val() !== "" ){
        url += `?keyword=${$("#keyword").val()}`
    }
    if ($("#category_id").val() !== "" && $("#category_id").val() !== "all") {
        if(url.indexOf('?')==-1){
            url+='?'
        }else{
            url+='&'
        }
        url += `category_id=${$("#category_id").val()}`
    }
    if ($("#date").val() !== "" ) {
        if(url.indexOf('?')==-1){
            url+='?'
        }else{
            url+='&'
        }
        url += `date=${$("#date").val()}`
    }
    const product = await (await fetch(url)).json()
    setUI(product)
});

$("#date").change(async function(){
    const product = await (await fetch('./controller/ExpireProduct.php')).json()
    setUI(product,true)
})*/

$("#search").click(async function () {
    if ($("#category_id").val() == "all" && $("#keyword").val() !== "" && $("#date").val() == "") {
        let url = `./controller/ExpireProduct.php?keyword=${$("#keyword").val()}`
        const product = await (await fetch(url)).json()
        setUI(product, true)
    }
    else if ($("#category_id").val() !== "all" && $("#keyword").val() == "" && $("#date").val() == "") {
        let url = `./controller/ExpireProduct.php?category_id=${$("#category_id").val()}`
        const product = await (await fetch(url)).json()
        setUI(product, true)
    }
    else if ($("#category_id").val() == "all" && $("#keyword").val() == "" && $("#date").val() !== "") {
        let url = `./controller/ExpireProduct.php?date=${$("#date").val()}`
        const product = await (await fetch(url)).json()
        setUI(product, true)
    }
    else if ($("#category_id").val() !== "all" && $("#keyword").val() !== "" && $("#date").val() == "") {
        let url = `./controller/ExpireProduct.php?category_id=${$("#category_id").val()}&keyword=${$("#keyword").val()}`
        const product = await (await fetch(url)).json()
        setUI(product, true)
    }
    else if ($("#category_id").val() !== "all" && $("#keyword").val() == "" && $("#date").val() !== "") {
        let url = `./controller/ExpireProduct.php?category_id=${$("#category_id").val()}&date=${$("#date").val()}`
        const product = await (await fetch(url)).json()
        setUI(product, true)
    }
    else if ($("#category_id").val() == "all" && $("#keyword").val() !== "" && $("#date").val() !== "") {
        let url = `./controller/ExpireProduct.php?keyword=${$("#keyword").val()}&date=${$("#date").val()}`
        const product = await (await fetch(url)).json()
        setUI(product, true)
    }
    else if ($("#category_id").val() !== "all" && $("#keyword").val() !== "" && $("#date").val() !== "") {
        let url = `./controller/ExpireProduct.php?category_id=${$("#category_id").val()}&keyword=${$("#keyword").val()}&date=${$("#date").val()}`
        const product = await (await fetch(url)).json()
        setUI(product, true)
    }
    else if ($("#category_id").val() == "all" && $("#keyword").val() == "" && $("#date").val() == "") {
        let url = `./controller/ExpireProduct.php`
        const product = await (await fetch(url)).json()
        setUI(product, true)
    }
});

function getDiff(T, D) {
    const days = (date_1, date_2) => {
        let difference = date_1.getTime() - date_2.getTime();
        let TotalDays = Math.ceil(difference / (1000 * 3600 * 24));
        return TotalDays;
    }
    return days(new Date(T), new Date(D))
}

async function start() {
    let url = './controller/ExpireProduct.php'
    const product = await (await fetch(url)).json()
    console.log(product);
    setUI(product)
}

$(document).ready(function () {
    start()
});

async function reset() {
    let url = `./controller/ExpireProduct.php?category_id=${$("#category_id").val('all')}&keyword=${$("#keyword").val('')}&date=${$("#date").val('')}`
    const product = await (await fetch(url)).json()
    console.log(product);
    setUI(product)
}

function setUI(data, f = false) {
    let c = 0
    $('#expireTable').html('')
    data.forEach((element, i) => {
        if (f) {
            if (getDiff(new Date().toDateString(), element.exp_date) >= -20000) {
                c++
                $('#expireTable').append(`<tr id="rr${i + 1}">
        <th><img src="${element.product_img}" style="width: 250px; padding: 10px;" ></th>
        <th>${element.product_name}</th>
        <th>${convertToDateThai(new Date(element.datereceive))}</th>
        <th>${convertToDateThai(new Date(element.exp_date))}</th>
        <th>${element.price.replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th>${element.product_rm_unit.replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th>${element.amount_exp.replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th><button type="button" class="bgs"  onclick="del(${element.stock_id},${element.amount_exp},${element.product_id})"><img src="./src/images/icon-delete.png" width="25"></button></th>
    </tr>`)
            }
        } else {
            if (getDiff(new Date().toDateString(), element.exp_date) >= -60) {
                c++
                $('#expireTable').append(`<tr style="vertical-align:top;" id="rr${i + 1}">
        <th><img src="${element.product_img}" style="width: 250px; padding: 10px;"></th>
        <th>${element.product_name}</th>
        <th>${convertToDateThai(new Date(element.datereceive))}</th>
        <th>${convertToDateThai(new Date(element.exp_date))}</th>
        <th>${element.price}</th>
        <th>${element.product_rm_unit}</th>
        <th>${element.amount_exp}</th>
        <th><button type="button" class="bgs"  onclick="del(${element.stock_id},${element.amount_exp},${element.product_id})"><img src="./src/images/icon-delete.png" width="25"></button></th>
    </tr>`)
            }
        }
    });
    if (c <= 0) {
        $('#no-let').show()
        $("#tb-let").hide()
    } else {
        $("#tb-let").show()
        $('#no-let').hide()
    }
}

function del(id, q, product_id) {
    Swal.fire({
        title: 'คำเตือน',
        text: "คุณต้องลบใช่หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const stock = {}
            stock.table = 'stock'
            stock.form_action = 'delete'
            stock.stock_id = id
            let formdata = new FormData();
            Object.keys(stock).forEach(key => formdata.append(key, stock[key]));
            var requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };
            await fetch("./controller/Stock.php", requestOptions)
            var formdata1 = new FormData();
            formdata1.append("q", q);
            formdata1.append("product_id", product_id);
            formdata1.append("form_action", "cut");
            formdata1.append("table", "product");
            requestOptions = {
                method: 'POST',
                body: formdata1,
                redirect: 'follow'
            };
            await fetch("controller/Product.php", requestOptions)
            Swal.fire(
                {
                    title: 'ลบสินค้าหมดอายุ',
                    text: 'การลบข้อมูลเสร็จสิ้น',
                    icon: 'success',
                    timer: 3000
                }
            ).then(() => {
                location.reload()
            })
        }
    })
}