$("#category_id").change(async function () {
    $('#cat').text($("#category_id option:selected").text())
    if ($("#category_id").val() !== "all") {
        let url = `./controller/NotificationResult.php?category_id=${$("#category_id").val()}`
        if ($("#keyword").val() !== "") {
            url += `&keyword=${$("#keyword").val()}`
        }
        const product = await (await fetch(url)).json()
        setUI(product)
    } else {
        let url = './controller/NotificationResult.php'
        if ($("#keyword").val() !== "") {
            url += `?keyword=${$("#keyword").val()}`
        }
        const product = await (await fetch(url)).json()

        setUI(product)
    }
});

$("#keyword").keyup(async function () {
    let url = `./controller/NotificationResult.php?keyword=${$("#keyword").val()}`
    if ($("#category_id").val() !== "" && $("#category_id").val() !== "all") {
        url += `&category_id=${$("#category_id").val()}`
    }
    const product = await (await fetch(url)).json()
    setUI(product)
});

async function start() {
    let url = './controller/NotificationResult.php'
    const product = await (await fetch(url)).json()
    console.log(product);
    $('#cat').text($("#category_id option:selected").text())
    $('#no-let').hide()
    setUI(product)
}

$(document).ready(function () {
    start()
});

function setUI(data) {
    let c = 0
    $('#notification_amtTable').html('')
    data.forEach((element, i) => {
            c++
            $('#notification_amtTable').append(`<tr style="vertical-align:top;" id="rr${i}">
        <th><img src="${element.product_img}" width="250"></th>
        <th>${element.product_name}</th>
        <th>${element.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th>${element.product_rm_unit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        ${$('#H').val() === `L` ? `<th>
            <label class="switch">
            <input type="checkbox" id="${element.product_id}" ${element.sales_status == 1 && element.product_rm_unit > 0 ? "checked" : ""} ${element.sales_status == 0 ? 'disabled' : ''} onchange="setStatus(${element.product_id})">
            <span class="slider round"></span>
            </label>
        </th>`:""}
    </tr>`)
    });
    if (c <= 0) {
        $('#no-let').show()
        $("#tb-let").hide()
        $("#num-list").text('')
        $("#cat").hide()
    } else {
        $("#tb-let").show()
        $("#num-list").text(`จำนวน ${c} รายการ`)
        $("#cat").show()
        $('#no-let').hide()
    }
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
