const number = Math.floor(Math.random() * 100) + 1;

let i = 1;
while (true) {
    let x = parseFloat(prompt("Masukkan salah satu dari angka 1 sampai 100: "));
    if (x == number) {
        console.log(`Selamat! kamu berhasil menebak angka ${number} dengan benar. \nSebanyak ${i}x percobaan.`);
        break;
    } else if (x < number) {
        console.log(`Terlalu rendah! Coba lagi.`);
    } else {
        console.log(`Terlalu tinggi! Coba lagi.`);  
    } 
    i++
}