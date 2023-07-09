let AllPrice = 0;
let diff = 0;
let interest_ = 0;
let mode = 'stop'
let D = '';


function getDate(date) {
    D = date
}

function getInterest(interest) {
    interest_ = interest / 100
}

function getAllprice(price) {
    AllPrice = price
}

function getDiff() {
    const days = (date_1, date_2) => {
        let difference = date_1.getTime() - date_2.getTime();
        let TotalDays = Math.ceil(difference / (1000 * 3600 * 24));
        return TotalDays;
    }
    diff = days(new Date($('#repayment_date').val()), new Date(D))
}

$('#repayment_date').change((e) => {
    getDiff();
    setDebt();
})

$("#slip_upload").hide(function () {
});

$("#payment").change(function () {
    if ($("#payment").val() == 'โอนเงิน') {
        $("#slip_upload").toggle()
    } else {
        $("#slip_upload").hide()
    }
});

function setDebt() {
    if (mode === 'clear') {
        $('#payment_amount').val(0)
        $('#deduct_principal').val(0)
        $('#outstanding').val(0)
        $('#less_interest').val(0)
        let interestAll = 0;
        if (diff > 120) {
            let m = Math.abs(Math.round((diff / 30)) - 4)
            console.log("m:", m)
            m = m == 0 ? 1 : m
            $('#less_interest').val(Math.round(AllPrice * (interest_ * m)))
            interestAll = Math.round(AllPrice * (interest_ * m))
        } else {
            $('#less_interest').val(0)
            interestAll = 0
        }
        $('#payment_amount').val(AllPrice + interestAll)
        $('#deduct_principal').val(AllPrice - interestAll)
        $('#outstanding').val(0)
    } else if (mode == 'pay') {
        let pay = $('#payment_amount').val()
        if (pay > AllPrice) {
            $('#payment_amount').val(AllPrice)
            pay = AllPrice
        }
        if (diff > 120) {
            let m = Math.abs(Math.round((diff / 30)) - 4)
            console.log("m:", m)
            m = m == 0 ? 1 : m
            $('#less_interest').val(Math.round(pay * (interest_ * m)))
            pay -= Math.round(pay * (interest_ * m))
        } else {
            $('#less_interest').val(0)
        }
        $('#deduct_principal').val(pay)
        $('#outstanding').val(Math.round(AllPrice - pay))
    }
}

$("#payment_modal").on("hidden.bs.modal", function () {
    mode = "stop"
});

function payMode() {
    mode = "pay"
}

function clearDebt() {
    mode = 'clear'
    setDebt();
}


$('#payment_amount').keyup((e) => {
    setDebt();
})

let diff2 = 0;
let D2 = '';
let interest_2 = 0;

function getDate2(date2) {
    D2 = date2
}

function getInterest2(interest2) {
    interest_2 = interest2
}
$("#index").ready(function () {
});

$(document).ready(function () {
    getDiff2();
    timeinterest();
    getInterest2();
});

function getDiff2() {
    const dayss = (date2_1, date2_2) => {
        let difference2 = date2_1.getTime() - date2_2.getTime();
        let TotalDays2 = Math.ceil(difference2 / (1000 * 3600 * 24));
        return TotalDays2;
    }
    diff2 = dayss(new Date(), new Date(D2))
}

function timeinterest() {
    if (diff2 <= 120) {
        let m = Math.abs(Math.ceil(Math.round(0)))
        if (m > 15) {
            m = 15
        }
        $('#less_interestt').text(m)
    } else if (diff2 > 120, diff2 < 149) {
        let m = Math.abs(Math.ceil(Math.round(interest_2)))
        if (m > 15) {
            m = 15
        }
        $('#less_interestt').text(m)
        dateout()
    } else if (diff2 > 150, diff2 < 179) {
        let m = Math.abs(Math.ceil(Math.round(interest_2 * 2)))
        if (m > 15) {
            m = 15
        }
        $('#less_interestt').text(m)
        dateout()
    } else if (diff2 > 180, diff2 < 209) {
        let m = Math.abs(Math.ceil(Math.round(interest_2 * 3)))
        if (m > 15) {
            m = 15
        }
        $('#less_interestt').text(m)
        dateout()
    } else if (diff2 > 210, diff2 < 239) {
        let m = Math.abs(Math.ceil(Math.round(interest_2 * 4)))
        if (m > 15) {
            m = 15
        }
        $('#less_interestt').text(m)
        dateout()
    } else if (diff2 > 240, diff2 < 259) {
        let m = Math.abs(Math.ceil(Math.round(interest_2 * 5)))
        if (m > 15) {
            m = 15
        }
        $('#less_interestt').text(m)
        dateout()
    } else if (diff2 > 260, diff2 < 279) {
        let m = Math.abs(Math.ceil(Math.round(interest_2 * 6)))
        if (m > 15) {
            m = 15
        }
        $('#less_interestt').text(m)
        dateout()
    } else if (diff2 > 280, diff2 < 309) {
        let m = Math.abs(Math.ceil(Math.round(interest_2 * 7)))
        if (m > 15) {
            m = 15
        }
        $('#less_interestt').text(m)
        dateout()
    } else if (diff2 > 310) {
        let m = Math.abs(Math.ceil(Math.round(interest_2 * 8)))
        if (m > 15) {
            m = 15
        }
        $('#less_interestt').text(m)
        dateout()
    } else {
        $('#less_interestt').text(0)
    }

}

function dateout() {
    if (diff2 >= 120) {
        let promise = 1
        $('#promise_status').val(promise)
    } else if (diff2 <= 120) {
        let promise = 0
        $('#promise_status').val(promise)
    }
    var formdata2 = new FormData();
    formdata2.append("contract_code", $('#contract_code').val());
    formdata2.append("promise_status", $('#promise_status').val());
    formdata2.append("form_action", "updatestatus");
    formdata2.append("table", "contract");
    fetch('controller/Contract.php', {
        method: 'POST',
        body: formdata2,
    })
}

$("#form1").submit(async function (event) {
    event.preventDefault();
    await fetch('controller/DebtPaymentDetails.php', {
        method: 'POST',
        body: new FormData(document.form1),
    })
    var formdata1 = new FormData();
    formdata1.append("contract_code", $('#contract_code').val());
    formdata1.append("outstanding", $('#outstanding').val());
    formdata1.append("form_action", "updateremain");
    formdata1.append("table", "contract");
    await fetch('controller/Contract.php', {
        method: 'POST',
        body: formdata1,
    }).then(() => {
        Swal.fire({
            icon: 'success',
            text: 'บันทึกข้อมูลเสร็จสิ้น',
        })
    })
    setTimeout(function () { location.reload(); }, 1000);
});

/*
$("#addslip_img").submit(async function (event) {
    event.preventDefault();
    let response = await fetch('controller/DebtPaymentDetails.php', {
        method: 'POST',
        body: new FormData(document.addslip_img)
    });
    console.log(response);
    if (!response.ok) {
        console.log(response);
    } else {
        await Swal.fire({
            icon: 'success',
            text: 'บันทึกข้อมูลเสร็จสิ้น',
        })
        console.log(await response.text())
        location.reload()
    }
});
*/

//เพิ่มสินค้า
/*$("#form1").submit(async function (event) {
    event.preventDefault();
    if ($('#payment_amount').val() === "" || $('#payment').val() === "" || $('#deduct_principal').val() === "" || $('#less_interest').val() === "" || $('#less_interest').val() === "" || $('#outstanding').val() === "") {
        return
    }
    var formdata1 = new FormData();
    formdata1.append("contract_code", $('#contract_code').val());
    formdata1.append("payment_amount", $('#payment_amount').val());
    formdata1.append("payment", $('#payment').val());
    formdata1.append("deduct_principal_principal", $('#deduct_principal').val());
    formdata1.append("less_interest", $('#less_interest').val());
    formdata1.append("outstanding", $('#outstanding').val());
    formdata1.append("form_action", "insert");
    formdata1.append("table", "debtPaymentDetails");
    var requestOptions = {
        method: 'POST',
        body: formdata1 + new FormData(document.form1),
        redirect: 'follow'
    };
    await fetch("controller/DebtPaymentDetails.php", requestOptions)
    //location.reload()
});*/

