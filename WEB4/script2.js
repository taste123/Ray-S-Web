function discount(x,y) {
    let diskon = 0;
    switch (y.toLowerCase()) {
        case "elektronik":
            diskon = 10;           
            break;
        case "pakaian":
            diskon = 20;          
            break;
        case "makanan":
            diskon = 5;          
            break;
        default:
            diskon = 0;
            break;
    }
    let total = x - x*(diskon/100);

    console.log(`Harga awal: Rp${x}`);
    console.log(`Diskon: ${diskon}%`);
    console.log(`Harga setelah diskon: Rp${total}`);
}

let x = parseFloat(prompt("masukkan harga barang"));
let y = prompt("Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya) ");

discount(x,y)