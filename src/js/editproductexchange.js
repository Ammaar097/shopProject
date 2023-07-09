$(document).ready(function () {
    $("input[name$='exchange_status']").click(function () {
        var test = $(this).val();
        $("div.desc").hide();
        $("#" + test).show();
    });
    /*$("#product_name").autocomplete({
        source: "./controller/ProductExchangeList.php",
        minLength: 2,
        select: function (event, ui) {
            $("#product_name").val(ui.item.label);
            $("#product_id").val(ui.item.value);
            return false;
        }
    });*/
});

/*$('#form1').submit(async function (e) {
    e.preventDefault()
    if (!$("#product_id").val()) {
        Swal.fire({
            title: 'กรุณาใส่ชื่อสินค้าให้ถูกต้อง'
            , icon: 'warning'
            , timer: 3000
        })
        return
    }
    if ($('#exchange_status').val() === 'complete') {
        const expass = (await (await fetch(`./controller/GetStock.php?id=${$("#product_id").val()}
        &q=${$("#exchange_amount").val()}`)).json())
        console.log(expass)
        if (!expass) {
            Swal.fire({
                title: 'สินค้าไม่เพียงพอให้เปลี่ยน'
                , icon: 'warning'
                , timer: 3000
            })
            return
        }
    }
    e.currentTarget.submit();
})*/

function phonePattern(obj) {
    const mobile = [8, 9, 6]
    const phone = [2, 3, 5, 7, 4]
    if (mobile.includes(Number(obj.value[1]))) {
        return new String("___-_______")
    } else if (phone.includes(Number(obj.value[1]))) {
        return new String("__-_______")
    } else {
        return null
    }
}

function autoTab2(obj) {
    if (obj.value[0] != 0) {
        obj.value = ''
        return
    }
    if (obj.value.length <= 1) {
        return
    }
    var pattern = null
    if (phonePattern(obj)) {
        pattern = phonePattern(obj)
    } else {
        obj.value = obj.value[0]
        return
    }
    var pattern_ex = new String("-");
    var returnText = new String("");
    var obj_l = obj.value.length;
    var obj_l2 = obj_l - 1;
    for (i = 0; i < pattern.length; i++) {
        if (obj_l2 == i && pattern.charAt(i + 1) == pattern_ex) {
            returnText += obj.value + pattern_ex;
            obj.value = returnText;
        }
    }
    if (obj_l >= pattern.length) {
        obj.value = obj.value.substr(0, pattern.length);
    }
}

$("#form1").submit(async function (event) {
    event.preventDefault();
    let response = await fetch('controller/ProductExchange.php', {
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
            timer: 3000
        })
        window.location.assign("productexchangehistory.php");
    }
});