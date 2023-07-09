$("#category_id").change(async function () {
    if ($("#category_id").val() !== "all") {
        let url = `./controller/ProductResult.php?category_id=${$("#category_id").val()}`
        $('.z').html($("#category_id :selected").text())
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
        $('.z').html("รายการสินค้าทั้งหมด")
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

$(".l").click(async function (e) {
    e.preventDefault();
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
    if (localStorage.getItem('cart') !== null) {
        const productCart = JSON.parse(localStorage.getItem('cart'))
        for (const p of productCart) {
            const idx = product.findIndex(e => e.product_id == p.id)
            product[idx].product_rm_unit = Number(product[idx].product_rm_unit) - Number(p.quantity)
        }
    } else {
        localStorage.setItem('cart', JSON.stringify([]))
    }
    setUI(product)
});

//แจ้งเตือนสินค้าในตะกร้า
if (JSON.parse(localStorage.getItem('cart')) === null) {
    $("#show").hide()
} else if (JSON.parse(localStorage.getItem('cart')) !== null) {
    let a = JSON.parse(localStorage.getItem('cart')).length
    if (a > 0) {
        $("#show").text(a)
    } else if (a == 0) {
        $("#show").hide()
    } else if (a == "") {
        $("#show").hide()
    } else if (a = []) {
        $("#show").hide()
    }
}


function setUI(data) {
    let html = ''
    let k = 0
    let m = ''
    data.forEach((element) => {
        if (element.product_rm_unit > 0 && element.sales_status == 1) {
            console.log(element.product_id)
            if (element.model == "-") {
               m = ""
            } else if(element.model == "") {
                m = ""
            } else if(element.model === null) {
                m = ""
            } else if(element.model == " ") {
                m = ""
            } else if(element.model != "") {
              m = "รุ่น&nbsp"
            }
            if (k % 3 === 0) {
                html += `<tr>`
            }
            html += `<th style="border: 0px">
                <div class="topic_product">
                <div class="row d-flex justify-content-center" style="margin: auto;">
                    <div class="col-11" style="padding:25px;">
                    ${element.product_name} ${m} ${element.model === "-" ? "" : element.model}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6" style="margin-left :auto;">
                        <div class="d-flex justify-content-start">
                        <a href="${element.product_img}" ><img src="${element.product_img}"  style="width: 225px; height: 250px;" ></a>
                        </div>
                    </div>
                    <div class="row col-5 d-flex justify-content-end" style="margin-right: auto;">
                    <div class="col-3" style="margin-right: auto;">
                    <p class="d-flex justify-content-start">ราคา</p>
                    <p class="d-flex justify-content-start">เหลือ</p>
                    </div>
                    <div class="col-5">
                    <p class="d-flex justify-content-end">${element.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</p>
                    <p class="d-flex justify-content-end"><span id="p${element.product_id}">${element.product_rm_unit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</span></p>
                    </div>
                    <div class="col-3" style="margin-left: auto;">
                    <p class="d-flex justify-content-start">บาท</p>
                    <p class="d-flex justify-content-start">${element.product_unit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</p>
                    </div>
                        <div class="d-flex justify-content-start">
                           <button onclick="addToCart(${element.product_id})" class="dynamicBT">เพิ่มไปยังรถเข็น</button>
                        </div>
                    </div>
                </div>
                </div>
                </th>`
            if ((k + 1) % 3 === 0 && (k + 1) === data.length) {
                html += `</tr>`
            }
            k++;
        }
    })
    $('#productlistTable').html(html)
}

function getDiff(date) {
    const days = (date_1, date_2) => {
        let difference = date_1.getTime() - date_2.getTime();
        let TotalDays = Math.ceil(difference / (1000 * 3600 * 24));
        return TotalDays;
    }
    return days(new Date(), new Date(date))
}

async function addToCart(id) {
    const p = Number($(`#p${id}`).text())
    let exlist = '';
    let l = 0;
    let expireList = await (await fetch('./controller/GetExpireProduct.php?product_id=' + id)).json()
    if (!(!expireList || expireList.length <= 0)) {
        let exdate = ''
        let k = 0
        for (let e of expireList) {
            if (getDiff(e.exp_date) <= 0) {
                exdate += `<option value="${e.stock_id}" ${k == 0 ? "selected" : ""}>${convertToDateThai(new Date(e.exp_date))}</option>
                `
                l++
            } else if (getDiff(e.exp_date) > 0) {
                exdate += `<option value="">ไม่ทราบวันหมดอายุ/ไม่มีวันหมดอายุ</option>`
            }
            k++
        }
        exlist = `<br>
                    <br style="font-size:30pt; "><b>วันหมดอายุ</b></br>
                    <label>
                    <select class="swal2-input" id="ex-id" style="width: 75%">
                    ${exdate}
                    </select>
                    </label>
            `
    } else {
        l = 1;
    }
    if (l <= 0) {
        Swal.fire({
            width: 1500,
            title: '<span style="font-size: 50px; color: red;">สินค้าหมดอายุแล้วหรือเป็นสินค้าไม่ทราบวันหมดอายุ</span>' +
                '<p></p><span style="font-size: 35px; color: black;">กรุณานำสินค้าหมดอายุออกจากคลังหรือจัดการจำนวนสินค้า</span>',
            icon: 'warning',
            showCancelButton: true,
            focusConfirm: false,
            cancelButtonText: "ยกเลิก",
            confirmButtonText: "ไปต่อโดยไม่มีวันหมดอายุ",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'จำนวน',
                    html: `<input id="q" type="number" min="1" step="1" value="1" class="swal2-input" placeholder="จำนวนสินค้า">${exlist}`,
                    confirmButtonText: 'ลงตะกร้า',
                    focusConfirm: false,
                    showCancelButton: true,
                    cancelButtonText: "ยกเลิก",
                    preConfirm: async () => {
                        const q = Number(Swal.getPopup().querySelector('#q').value)
                        if (p > 0 && p >= q) {
                            $(`#p${id}`).text(Number(p - q))
                        } else if (p > 0 && p < q) {
                            Swal.showValidationMessage(`สินค้าไม่เพียงพอ`)
                        }
                        return {q: q, id: id}
                    }
                }).then((result) => {
                    const cart = JSON.parse(localStorage.getItem('cart'))
                    const found = cart.findIndex(e => e.id === id)
                    console.log(result.value)
                    if (found > -1) {
                        cart[found].quantity += result.value.q
                    } else {
                        cart.push({
                            id: result.value.id,
                            quantity: result.value.q,
                        })
                    }
                    setTimeout(function () {
                        location.reload();
                    }, 0.1)
                    localStorage.setItem('cart', JSON.stringify(cart))
                })
            }
        });
    } else {
        if (p > 0) {
            Swal.fire({
                title: 'จำนวน',
                html: `<input id="q" type="number" min="1" step="1" value="1" class="swal2-input" placeholder="จำนวนสินค้า">${exlist}`,
                confirmButtonText: 'ลงตะกร้า',
                focusConfirm: false,
                showCancelButton: true,
                cancelButtonText: "ยกเลิก",
                preConfirm: async () => {
                    const q = Number(Swal.getPopup().querySelector('#q').value)
                    if (p > 0 && p >= q) {
                        $(`#p${id}`).text(Number(p - q))
                    } else if (p > 0 && p < q) {
                        Swal.showValidationMessage(`สินค้าไม่เพียงพอ`)
                    }
                    return {q: q, id: id}
                }
            }).then((result) => {
                const cart = JSON.parse(localStorage.getItem('cart'))
                const found = cart.findIndex(e => e.id === id)
                console.log(result.value)
                if (found > -1) {
                    cart[found].quantity += result.value.q
                } else {
                    cart.push({
                        id: result.value.id,
                        quantity: result.value.q,
                        stock_id: Number($('#ex-id').val())
                    })
                }
                setTimeout(function () {
                    window.location.reload();
                }, 0.1)
                localStorage.setItem('cart', JSON.stringify(cart))
            })
        } else {
            Swal.fire({
                icon: 'warning',
                text: "สินค้าไม่เพียงพอ"
            })
        }
    }
}