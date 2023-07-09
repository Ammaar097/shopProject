$("#search").click(async function () {
    if ($("#start").val() !== "" && $("#end").val() == "") {
        Swal.fire({
            icon: 'warning',
            title: 'คำเตือน',
            text: 'กรุณาเลือกวันที่ช่วงสุดท้ายก่อนค้นหา',
            timer: 3000
        })
        return
    } else if ($("#start").val() == "" && $("#end").val() !== "") {
        Swal.fire({
            icon: 'warning',
            title: 'คำเตือน',
            text: 'กรุณาเลือกวันที่ช่วงแรกก่อนค้นหา',
            timer: 3000
        })
        return
    } else if ($("#start").val() == "" && $("#end").val() == "") {
        Swal.fire({
            icon: 'warning',
            title: 'คำเตือน',
            text: 'กรุณาเลือกวันที่',
            timer: 3000
        })
        return
    } else if ($("#start").val() !== "" && $("#end").val() !== "") {
        let url = `./controller/CostPrice2.php?product_id=${$("#product_id").val()}&start=${$("#start").val()}&end=${$("#end").val()}`
        const product = await (await fetch(url)).json()
        setUI(product)
    }
});

async function start() {
    let url = './controller/CostPrice2.php'
    const product = await (await fetch(url)).json()
    console.log(product);
    setUI(product)
}

function setUI(data) {
    $("canvas#graphCanvas").remove();
    $("#ChartTable").append(`<canvas id="graphCanvas" style="height:70vh; width:80vw;"></canvas>`);
    var name = [];
    var marks = [];
    for (var i in data) {
        name.push(data[i].cost_price);
        marks.push(data[i].costprice_dt);
    }
    const ctx = $("#graphCanvas");
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: marks,
            datasets: [{
                label: 'ราคาทุน',
                data: name,
                backgroundColor: ['rgb(180, 120, 120)',],
                borderColor: ['rgb(120, 120, 120)',],
                borderWidth: 1,

            }],
        },
        options: {
            scales: {
                y: {
                    min: 0,
                }
            }
        }
    });
    Chart.defaults.font.size = 14;
    /*type: 'line',
    data: {
        labels: name,
        datasets:
            [
                {
                    label: 'วันที่ขายสินค้า',
                    data: marks,
                    backgroundColor: ['rgb(180, 120, 120)',],
                    borderColor: ['rgb(120, 120, 120)',],
                    borderWidth: 1,
                }
            ]
    },
    options: {
        indexAxis: 'y',
    }
    });*/
}