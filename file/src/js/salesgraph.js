$("#search").click(async function () {
    if ($("#date").val() !== "" && $("#category_id").val() !== "all" && $("#limit").val() !== "") {
        let url = `./controller/SalesGraph.php?category_id=${$("#category_id").val()}&date=${$("#date").val()}&limit=${$("#limit").val()}`
        const product = await (await fetch(url)).json()
        setUI(product)
    } else if ($("#category_id").val() == "all" && $("#limit").val() !== "" && $("#date").val() !== "") {
        let url = `./controller/SalesGraph.php?&date=${$("#date").val()}&limit=${$("#limit").val()}`
        const product = await (await fetch(url)).json()
        setUI(product)
    }
});

async function start() {
    let url = './controller/SalesGraph.php'
    const product = await (await fetch(url)).json()
    console.log(product);
    setUI(product)
}

$(document).ready(function () {
    start()
});


function setUI(data) {
    $("canvas#graphCanvas").remove();
    $("#ChartTable").append(`<canvas id="graphCanvas" style="height:70vh; width:80vw;"></canvas>`);
    var name = [];
    var marks = [];
    for (var i in data) {
        name.push(data[i].product_name);
        marks.push(data[i].sales_amt);
    }
    const ctx = $("#graphCanvas");
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: name,
            datasets:
                [
                    {
                        barPercentage: 0.5,
                        barThickness: 50,
                        maxBarThickness: 50,
                        minBarLength: 2,
                        label: 'ยอดขายสินค้า',
                        data: marks,
                        backgroundColor: ['rgb(180, 120, 120)',],
                        borderColor: ['rgb(120, 120, 120)',],
                        borderWidth: 1,
                    }
                ]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        font: {
                            size: 20
                        }
                    }
                }
            }
        }
    });

    Chart.defaults.font.size = 14;
}

