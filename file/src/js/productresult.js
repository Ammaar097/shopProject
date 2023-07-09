$("#category_id").change(async function () {
    if ($("#category_id").val() !== "all") {
        let url = `./controller/ProductResult.php?category_id=${$("#category_id").val()}`
        if ($("#keyword").val() !== "") {
            url += `&keyword=${$("#keyword").val()}`
        }
        const product = await (await fetch(url)).json()
        setUI(product)
    } else {
        let url = './controller/ProductResult.php'
        if ($("#keyword").val() !== "") {
            url += `?keyword=${$("#keyword").val()}`
        }
        const product = await (await fetch(url)).json()
        console.log(product);
        setUI(product)
    }
});

$("#keyword").keyup(async function () {
    let url = `./controller/ProductResult.php?keyword=${$("#keyword").val()}`
    if ($("#category_id").val() !== "" && $("#category_id").val() !== "all") {
        url += `&category_id=${$("#category_id").val()}`
    }
    const product = await (await fetch(url)).json()
    setUI(product)
});

$(document).ready(async function () {
    let url = './controller/ProductResult.php'
    const product = await (await fetch(url)).json()
    setUI(product)
});

function setUI(data) {
    $('#productResultTable').html('')
    data.forEach(element => {
        $('#productResultTable').append(`
        <tr style="vertical-align:top;">
        <th>${element.category_name}</th>
        <th>${element.product_name}</th>
        <th>${element.brand}</th>
        <th>${element.model}</th>
        <th>${element.product_dlt_unit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th>${element.product_rm_unit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th>${element.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th><img src="${element.product_img}" width="200" height="200"></th>
        ${$('#H').val() === `L` ? `<th>
            <label class="switch">
                <input ${element.product_rm_unit == 0 ? 'disabled' : ''} type="checkbox" id="S${element.product_id}" ${element.sales_status == 1 && element.product_rm_unit > 0 ? "checked" : ""} onchange="setStatus(${element.product_id})">
                <span class="slider round"></span>
            </label>
        </th>
        <th>
            <button type="button" class="bgs" onclick="del(${element.product_id})"><img src="./src/images/icon-delete.png" width="25"></button>
            <a type="button" class="bgs" href="./editproduct.php?id=${element.product_id}"><img src="./src/images/icon-pencil.png" width="25"></a>
        </th>`:""}
    </tr>`)
    });
}

async function setStatus(id, val) {
    if (!val) {
        const status = $("#S" + id).is(':checked');
        fetch(`./controller/setProductStatus.php?status=${status}&id=${id}`).then(() => {
            setTimeout(() => window.location.reload(), 500)
        })
        return
    }
    fetch(`./controller/setProductStatus.php?status=${val == 0 ? false : true}&id=${id}`)
        .then(() => {
            setTimeout(() => window.location.reload(), 500)
        })
}

//ลบสินค้า
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
            const product = await (await fetch("./controller/GetProduct.php?id=" + id)).json()
            product.table = 'product'
            product.form_action = 'delete'
            let formdata = new FormData();
            Object.keys(product).forEach(key => formdata.append(key, product[key]));
            const requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };
            await fetch("./controller/Product.php?id=", requestOptions)
            Swal.fire(
                {
                    title: 'ลบรายการสินค้า',
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