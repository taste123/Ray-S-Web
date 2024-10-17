// radnom card
let randomCardUsed = [];
let cardShape = ["Clubs", "Diamond", "Hearts", "Spades"];
let ifLose = 0;

function randomCardShape() {
    return Math.floor(Math.random() * 4);
  }
function randomCardNumber() {
    return Math.floor(Math.random() * 13) + 1;
  }

function randomCard(params) {

    let cardString;

    do {
        let number = randomCardNumber();
        let shape = cardShape[randomCardShape()];
        cardString = `${number}${shape}`;
    } while (randomCardUsed.includes(cardString));

    randomCardUsed.push(cardString)
    return cardString
}

// get the first string (number) from random cards
function getValueCard(card) {
    let x = parseInt(card.match(/\d+/)[0]);
    if (x>10) {
        x = 10;
    } else if (x === 1) {
        x = 11;
    }
    return x;
}


// sum score func
function sumScore(card1, card2) {
    let x = card1+card2;
    if (x > 21 && (card1 === 11 || card2 === 11)) {
        x -= 10;
    }
    return x;
}

// cek bid before start
let amountMoney = 5000;
const amount = document.getElementById("amount");
amount.innerHTML = `$${amountMoney}`
const afterBid = document.getElementById("afterBid");
const bid = document.getElementById("bid");

function cekBid(params) {
    const bidInput = parseInt(document.getElementById("bidInput").value);

    if (!bidInput) { //if input = empty
        afterBid.innerHTML = `<p>Please enter a bid</p>`;
    } else if (bidInput<100) {
        afterBid.innerHTML = `<p>minimal bid : $100</p>`;
    } else {
        if (amountMoney-bidInput < 0) {
            afterBid.innerHTML = `<p>insufficient balance!</p>`;
        } else {
            afterBid.innerHTML = `<p>Bid : $${bidInput}</p>`;
            amountMoney -= bidInput;
            amount.innerHTML = `$${amountMoney}`;   
            document.getElementById("bidInput").disabled = true;      
            // bid.disabled = true;
            const bidText = document.getElementById("bidText");
            bidText.innerHTML = ``;
            start(bidInput);
        }
    }
}

const buttonPlay = document.getElementById("buttonPlay"); 
// nextGame
function nextGame(ifLose) {
    if (ifLose === 1 && amountMoney === 0) {
        buttonPlay.innerHTML = `
        <div class="buttonGame">
            <button id="resetMoney" class="buttonGame">Reset Money</button>  
        </div>`;

        const resetMoney = document.getElementById("resetMoney");
        resetMoney.addEventListener("click", () => {
            // Reset the game state
            amountMoney = 5000;  // Reset the player's money
            ifLose = 0;  // Reset the lose state

            // Update the interface
            amount.innerHTML = `$${amountMoney}`;

            // Re-enable the bid input
            document.getElementById("bidInput").disabled = false;     

            // Display the start game button again
            buttonPlay.innerHTML = `
            <button id="startGame">Start Game</button>`;

            // Attach the event listener for starting the game
            const startGame = document.getElementById("startGame");
            startGame.addEventListener("click", () => {
                cekBid();
            });
        });
    } else {
        afterBid.innerHTML = ``;
        bidInput.value = '';
        document.getElementById("bidInput").disabled = false;     
        buttonPlay.innerHTML = `
        <button id="startGame">Start Game</button>`;
        
        const startGame = document.getElementById("startGame");
        startGame.addEventListener("click", async (params) => {
            cekBid();
        });
    }
        
    
}

// start game
function start(bidInput) {
    randomCardUsed.length = 0;
    const displayText = document.getElementById("displayText");
    displayText.innerHTML = `
    <h3>
    press HIT button to take a card <br/>
    press STAY to see the com's card
    </h3>`;
    
    //   player card
    let card1Player = randomCard();
    let card2Player = randomCard();        
    const cardPlayer = document.getElementById("cardPlayer");
    cardPlayer.innerHTML = `
        <img class="playerCard" src="./img/${card1Player}.png" width="150px" />
        <img class="playerCard" src="./img/${card2Player}.png" width="150px" />
        `;
    // count player score
    let scorePlayer = sumScore(getValueCard(card1Player),getValueCard(card2Player));  
    
    // show the player score
    const scorePlayerText = document.getElementById("scorePlayerText");
    scorePlayerText.innerHTML = `<h2>Your score <br/>(${scorePlayer})</h2>`;
    
    
    // computer card
    let card1com = randomCard();
    const cardCom = document.getElementById("cardCom");    
    cardCom.innerHTML = `
        <img id="comCard" src="./img/${card1com}.png" width="150px" />
        `;
    // count com score
    let scoreCom = getValueCard(card1com);
    
    // show the com score
    const scoreComText = document.getElementById("scoreComText");
    scoreComText.innerHTML = `<h2>Com score <br/>(${scoreCom})</h2>`;
    
    // change the button   
    buttonPlay.innerHTML = `
    <div class="buttonGame">
        <button id="hit" class="buttonGame">hit</button>  
    </div>  
    <div class="buttonGame">
        <button id="stay" class="buttonGame">stay</button>
    </div>  
        `;
    
    // button hit, add player card
        const hit = document.getElementById("hit");
        hit.addEventListener("click", async (params) => {
            let cardHit = randomCard();
            const cardPlayer = document.getElementById("cardPlayer");
            cardPlayer.innerHTML += `
                <img class="playerCard" src="./img/${cardHit}.png" width="150px" />
                `;
            // += score player

            scorePlayer = sumScore(scorePlayer, getValueCard(cardHit));
            // show the player score
            const scorePlayerText = document.getElementById("scorePlayerText");
            scorePlayerText.innerHTML = `<h2>Your score <br/>(${scorePlayer})</h2>`;
    
            // if score > 21, then lose
            if (scorePlayer > 21) {
                displayText.innerHTML = `<h3>
                    you lose (bust)
                </h3>`;

                ifLose = 1;

                nextGame(ifLose); 
            }
        });        
    // button stay, reveal com card
        const stay = document.getElementById("stay");    
        stay.addEventListener("click", async (params) => {
            //loop add car com till 17
            while (scoreCom < 17) {
                let cardAddCom = randomCard();
                // +=score com
                const cardCom2 = document.getElementById("cardCom");
                cardCom.innerHTML += `
                <img class="cardComAdded" src="./img/${cardAddCom}.png" width="150px" />`;
                scoreCom = sumScore(scoreCom, getValueCard(cardAddCom));
                // show the com score
                const scoreComText = document.getElementById("scoreComText");
                scoreComText.innerHTML = `<h2>Com score <br/>(${scoreCom})</h2>`;
            }

            if (scoreCom<scorePlayer && scorePlayer <= 21) {
                displayText.innerHTML = `<h3>
                    you WIN
                </h3>`;
                amountMoney += 2*bidInput; 
            } else if (scoreCom > 21) {
                displayText.innerHTML = `<h3>
                you WIN (com-bust)
                </h3>`;
                amountMoney += 2*bidInput; 
            } else if (scoreCom <= 21 && scoreCom>scorePlayer) {
                displayText.innerHTML = `<h3>
                Computer WIN
                </h3>`;
                ifLose = 1;
            } else if(scoreCom === scorePlayer){
                displayText.innerHTML = `<h3>
                PUSH, it's a tie
                </h3>`;
                amountMoney += bidInput; 
            }
            amount.innerHTML = `$${amountMoney}`

            nextGame( ifLose); 
        });    
}

const startGame = document.getElementById("startGame");
    startGame.addEventListener("click", async (params) => {
        cekBid();
    });         