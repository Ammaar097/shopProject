function logout() {
    Swal.fire({
        title: 'ออกจากระบบ',
        text: "คุณต้องการออกจากระบบหรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ออกจากระบบ',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        if (result.isConfirmed) {
            await fetch('./controller/LogOut.php')
            window.location = 'index.php'
        }
    })
}
