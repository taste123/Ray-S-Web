function countEvenNumbers(x,y) {
    let evenNums = [];
    for (let i = x; i < y+1; i++) {
        if (i% 2 == 0) {
            evenNums.push(i);
        }
    }
    console.log(evenNums.length, evenNums);
    
}

let x = parseInt(prompt("Masukkan angka pertama"));
let y = parseInt(prompt("Masukkan angka pertama"));

countEvenNumbers(x,y);