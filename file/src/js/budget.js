

/*$("#search").click(async function () {
    if ($('#firstdate').val() !== "" && $('#lastdate').val() !== "") {
        let url = `./controller/Budget.php?startDate=${$("#firstdate").val()}&endDate=${$("#lastdate").val()}`
        const product = await (await fetch(url)).json()
        setUI(product)
    }
});*/
/*
async function start() {
    let url = './controller/Budget.php'
    const product = await (await fetch(url)).json()
    console.log(product);
    setUI(product)
}

$(document).ready(function () {
    start()
});

function setUI() {
        let allprice = Number(element.price)
        let allpricesales = Number(element.all_price)
        let allpriceorder = $('#all_price_odr').val()
        $("#price").text(allprice)
        $("#pricesales").text(allpricesales)
        $("#priceorder").text(allpriceorder)
        $("#priceorder").val(allpriceorder)

}
*/
/*function setUI(data) {
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
        $('#dailybestsellerTable').append(`<tr id="rr${i + 1}">
        <th class="index-table-bank">${i + 1}</th>
        <th><img src="${element.product_img}" width="400"></th>
        <th>${element.product_name}</th>
        <th>${element.price}</th>
        <th>${element.product_rm_unit}</th>
        <th>${element.sales_amt}</th>
    </tr>`)
    });
}*/

