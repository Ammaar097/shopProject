$("#search").click(async function () {
    if ($("#category_id").val() == "all" && $("#keyword").val() !== "" && $("#date").val() == "") {
        let url = `./controller/DailyBestSeller.php?keyword=${$("#keyword").val()}`
        const product = await (await fetch(url)).json()
        setUI(product)
    }
    else if ($("#category_id").val() !== "all" && $("#keyword").val() == "" && $("#date").val() == "") {
        let url = `./controller/DailyBestSeller.php?category_id=${$("#category_id").val()}`
        const product = await (await fetch(url)).json()
        setUI(product)
    }
    else if ($("#category_id").val() == "all" && $("#keyword").val() == "" && $("#date").val() !== "") {
        let url = `./controller/DailyBestSeller.php?date=${$("#date").val()}`
        const product = await (await fetch(url)).json()
        setUI(product)
    }
    else if ($("#category_id").val() !== "all" && $("#keyword").val() !== "" && $("#date").val() == "") {
        let url = `./controller/DailyBestSeller.php?category_id=${$("#category_id").val()}&keyword=${$("#keyword").val()}`
        const product = await (await fetch(url)).json()
        setUI(product)
    }
    else if ($("#category_id").val() !== "all" && $("#keyword").val() == "" && $("#date").val() !== "") {
        let url = `./controller/DailyBestSeller.php?category_id=${$("#category_id").val()}&date=${$("#date").val()}`
        const product = await (await fetch(url)).json()
        setUI(product)
    }
    else if ($("#category_id").val() == "all" && $("#keyword").val() !== "" && $("#date").val() !== "") {
        let url = `./controller/DailyBestSeller.php?keyword=${$("#keyword").val()}&date=${$("#date").val()}`
        const product = await (await fetch(url)).json()
        setUI(product)
    }
    else if ($("#category_id").val() !== "all" && $("#keyword").val() !== "" && $("#date").val() !== "") {
        let url = `./controller/DailyBestSeller.php?category_id=${$("#category_id").val()}&keyword=${$("#keyword").val()}&date=${$("#date").val()}`
        const product = await (await fetch(url)).json()
        setUI(product)
    }
    else if ($("#category_id").val() == "all" && $("#keyword").val() == "" && $("#date").val() == "") {
        let url = `./controller/DailyBestSeller.php`
        const product = await (await fetch(url)).json()
        setUI(product)
    }
});


async function start() {
    let url = `./controller/DailyBestSeller.php?date=${$("#date").val()}`
    const product = await (await fetch(url)).json()
    console.log(product);
    setUI(product)
}

$(document).ready(function () {
    start()
});

async function reset() {
    let url = `./controller/DailyBestSeller.php?category_id=${$("#category_id").val('all')}&keyword=${$("#keyword").val('')}&date=${$("#date").val('')}`
    const product = await (await fetch(url)).json()
    console.log(product);
    setUI(product)
}

function setUI(data) {
    let c = 0
    $('#dailybestsellerTable').html('')
    let r = -1
    while (r !== 0) {
        r = 0
        for (let i = 0; i < data.length; i++) {
            if (i + 1 !== data.length) {
                if (data[i].sales_amt < data[i + 1].sales_amt) {
                    let a = data[i]
                    let b = data[i + 1]
                    data[i] = b
                    data[i + 1] = a
                    r++
                }
            }
        }
    }
    data.forEach((element, i) => {
        c++
        $('#dailybestsellerTable').append(`<tr style="vertical-align:top;" id="rr${i + 1}">
        <th class="index-table-bank">${i + 1}</th>
        <th><img src="${element.product_img}" width="250"></th>
        <th>${element.product_name}</th>
        <th>${element.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th>${element.product_rm_unit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th>${element.sales_amt.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
    </tr>`)
    });
    if (c <= 0) {
        $('#no-let').show()
        $("#tb-let").hide()
    } else {
        $("#tb-let").show()
        $('#no-let').hide()
    }
}