$("#search").click(async function () {
    if ($("#keyword").val() !== "") {
        let url = `./controller/SearchInformation.php?keyword=${$("#keyword").val()}`
        const product = await (await fetch(url)).json()
        setUI(product)
    }
});

async function start() {
    let url = './controller/SearchInformation.php'
    const product = await (await fetch(url)).json()
    console.log(product);
    setUI(product)
}

$(document).ready(function () {
    start()
});

function setUI(data) {
    let c = 0
    $('#searchTable').html('')
    data.forEach((element, i) => {
        c++
        $('#searchTable').append(`<tr id="rr${i + 1}">
        <th class="index">${i + 1}</th>
        <th><img src="${element.product_img}" style="width: 200px; padding: 10px"></th>
        <th><span id="p${element.product_id}">${element.product_name}</span></th>
        <th>${element.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th>${element.sales_amt.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th>${element.sales_pr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</th>
        <th><a class="bgs" href="./addproductexchange.php?id=${element.product_id}">${element.set_exchange == 1 ? 'เปลี่ยนสินค้า' : ''}</a></th>
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

//ส่วนเผื่อใช้
/*
let r =-1
while(r!==0){
    r = 0
    for(let i = 0;i<data.length ;i++){
        if(i+1 !== data.length ){
            if(data[i].sales_amt < data[i+1].sales_amt){
                let a = data[i]
                let b = data[i+1]
                data[i] = b
                data[i+1] = a
                r++
            }
        }
    }
}*/