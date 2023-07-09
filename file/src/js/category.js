function del(id) {
    Swal.fire({
        title: 'คำเตือน',
        text: "คุณต้องการลบประเภทสินค้าใช่หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const category = {}
            category.table = 'category'
            category.form_action = 'delete'
            category.category_id = id
            let formdata = new FormData();
            Object.keys(category).forEach(key => formdata.append(key, category[key]));
            const requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };
            await fetch("./controller/Category.php", requestOptions)
            Swal.fire(
                {
                    title: 'ลบประเภทสินค้า',
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

async function delay(ms) {
    return await new Promise(resolve => setTimeout(resolve, ms));
}


function insert() {
    Swal.fire({
        title: 'เพิ่มประเภทสินค้า',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก',
        showLoaderOnConfirm: true,
        preConfirm: async (name) => {
            if (name === '') {
                Swal.showValidationMessage(
                    'กรุณากรอกข้อความ'
                )
                return false

            } else {
                const category = {}
                category.table = 'category'
                category.form_action = 'insert'
                category.category_name = name
                let formdata = new FormData();
                Object.keys(category).forEach(key => formdata.append(key, category[key]));
                const requestOptions = {
                    method: 'POST',
                    body: formdata,
                    redirect: 'follow'
                };
                await delay(1000)
                return fetch("./controller/Category.php", requestOptions)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Request failed: ${error}`
                        )
                    })
            }
        },
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'เพิ่มประเภทสินค้า',
                text: 'การเพิ่มข้อมูลเสร็จสิ้น',
                icon: 'success',
                timer: 3000
            }).then(() => location.reload())
        }
    })
}


function edit(id) {
    Swal.fire({
        title: 'แก้ไขประเภทสินค้า',
        input: 'text',
        inputValue: $('#text' + id).text(),
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก',
        showLoaderOnConfirm: true,
        preConfirm: async (name) => {
            if (name === '') {
                Swal.showValidationMessage(
                    'กรุณากรอกข้อความ'
                )
                return false
            } else {
                const category = {}
                category.table = 'category'
                category.form_action = 'update'
                category.category_id = id
                category.category_name = name
                let formdata = new FormData();
                Object.keys(category).forEach(key => formdata.append(key, category[key]));
                const requestOptions = {
                    method: 'POST',
                    body: formdata,
                    redirect: 'follow'
                };
                await delay(1000)
                return fetch("./controller/Category.php", requestOptions)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Request failed: ${error}`
                        )
                    })
            }
        },
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'แก้ไขประเภทสินค้า',
                text: 'การแก้ไขข้อมูลเสร็จสิ้น',
                icon: 'success',
                timer: 3000
            }).then(() => location.reload())
        }
    })
}