let hari = ["senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu"];

function prediction(x, y, day) {
    let z = y % 7;
    console.log(`Prediksi hari, ${y} hari setelah ${day}: ${hari[x+z]}`);
}

while (true) {
    let day = prompt("Masukkan hari: ").toLowerCase();

    if (hari.includes(day)) {
        let y = parseFloat(prompt("Masukkan prediksi hari (angka): "));
        let x = hari.indexOf(day);
        prediction(x, y, day);
        break;
    } else {
        console.log("invalid input");
    }
}
