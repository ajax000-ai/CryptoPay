<?php

$trxadress = "TUz2LvQsWr3wCBdwDGhwAV6FNBADKQ4npH";
$btcadress = "bc1qwh97vapvptjq3u54ypwytrx3m7ysqf3hczluz7";
$ethadress = "CCCCCCCCCCCCCCCCC";
$usdtadress = "DDDDDDDDDDDDDDDDDD";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay with Crypto</title>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .crypto-option img {
            width: 30px;
            height: 30px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <div class="row">
                        <center>
                            <h4 class="mb-0"><img src="cyrptopay.svg" /></h4>
                        </center>
                    </div>
                </div>
				 <div class="card-body">
                    <div id="trxInfoDiv">
					       <div class="mb-3" id="slctcry"><center>
                            <label for="cryptoSelect" class="form-label">Select Cryptocurrency</label>
                            <div class="dropdown">
                                <input class="btn btn-danger dropdown-toggle" type="button" id="cryptoDropdown" value="Tron (TRX)" data-bs-toggle="dropdown" aria-expanded="false">
                               
                                <ul class="dropdown-menu" aria-labelledby="cryptoDropdown">
                                    <li><a onclick="selectCrypto('btc')" class="dropdown-item crypto-option" href="#" data-crypto="btc"><img src="btc.png" alt="Bitcoin"> Bitcoin (BTC)</a></li>
                                    <li><a onclick="selectCrypto('eth')" class="dropdown-item crypto-option" href="#" data-crypto="eth"><img src="eth.png" alt="Ethereum"> Ethereum (ETH)</a></li>
                                    <li><a onclick="selectCrypto('trx')" class="dropdown-item crypto-option" href="#" data-crypto="trx"><img src="trx.png" alt="Tron" selected> Tron (TRX)</a></li>
                                    <li><a onclick="selectCrypto('usdt')" class="dropdown-item crypto-option" href="#" data-crypto="usdt"><img src="usdt.svg" alt="Tether"> Tether (USDT)</a></li>
                                   
                                </ul>
								 
                                <input type="hidden" name="crypto" id="selectedCrypto">
                            </div>
							</center>
                        </div>
						<div id="hashInputDiv" style="display: none;">
						<center><div id="countdown" class="mt-3">Loading..</div></center>
						<hr />
    <div class="mb-3">
        <label for="hash" class="form-label">Transaction Hash:</label>
        <input type="text" class="form-control" id="hash">
    </div>
    <button type="button" class="btn btn-success" onclick="Complete()">Complete</button>
</div>
						<div id="CryBody">
						
				<script>
let cryptoType = "BTC";
let amount = 50;
let SelectedWalletAdress = "<?php echo $btcadress ?>";
let ApiLink = "http://localhost/s-client/JetCrypto/api.php";
let countdown;
function copyToClipboard(elementId) {
    var element = document.getElementById(elementId);
    element.select();
    document.execCommand("copy");
    Swal.fire({
        title: "Copied",
        text: "Copied => " + element.value + " ",
        timer: 500,
        icon: "success"
    });
}

 function startCountdown() {
        let timeLeft = 300; // 5 minutes in seconds

        countdown = setInterval(function () {
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;

            document.getElementById('countdown').innerText = `${minutes}:${seconds}`;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                document.getElementById('countdown').innerText = "Time's up!";
            }

            timeLeft -= 1;
        }, 1000);
    }
function showHashInput() {
	startCountdown();
       var trxInfoDiv = document.getElementById('CryBody');
    if (!trxInfoDiv) {
        trxInfoDiv = document.createElement('div');
        trxInfoDiv.id = 'CryBody';
        document.getElementById('trxInfoDiv').appendChild(trxInfoDiv);
    }

    trxInfoDiv.innerHTML = ""; // Clear other fields
    var hashInputDiv = document.getElementById('hashInputDiv');
    if (!hashInputDiv) {
        console.error('hashInputDiv element not found.');
        return;
    }
document.getElementById("slctcry").style.display = 'none';
    hashInputDiv.style.display = 'block';
}


function Complete() {
	 clearInterval(countdown);
	var hash = document.getElementById("hash").value;
	
	const url = `http://localhost/s-client/JetCrypto/api.php?request=CheckTransaction&amount=${amount}&hash=${hash}`;

// Fetch ile HTTP isteği gönderme
fetch(url)
  .then(response => response.json()) // Gelen veriyi JSON formatına çevirme
  .then(data => {
    // Gelen veriyi kontrol etme
    if (data.Status === "SUCCESS") {
       Swal.fire({
        title: "Verified",
        text: "Your " + cryptoType + " has been successfully received.",
        icon: "success"
    });
    } else {
   Swal.fire({
        title: "Error",
        text: data.Message,
        icon: "error"
    });
    }
  })
  .catch(error => {
    console.error("İstek hatası:", error);
  });

	
	
	
   
}

function selectCrypto(crypto) {
    if (crypto == 'btc') {
        document.getElementById("cryptoDropdown").value = "Bitcoin (BTC)";
		SelectedWalletAdress = "<?php echo $btcadress ?>";
        cryptoType = "BTC";
    } else if (crypto == 'eth') {
        document.getElementById("cryptoDropdown").value = "Ethereum (ETH)";
		SelectedWalletAdress = "<?php echo $ethadress ?>";
        cryptoType = "ETH";
		 
    } else if (crypto == 'trx') {
        document.getElementById("cryptoDropdown").value = "Tron (TRX)";
		SelectedWalletAdress = "<?php echo $trxadress ?>";
        cryptoType = "TRX";
    } else if (crypto == 'usdt') {
        document.getElementById("cryptoDropdown").value = "Tether (USDT)";
		SelectedWalletAdress = "<?php echo $usdtadress ?>";
        cryptoType = "USDT";
    } else {
        document.getElementById("cryptoDropdown").value = "Choose Cryptocurrency";
		
    }

	document.getElementById("CryBody").innerHTML = `
           
                    
    <div class="mb-3">
        <label for="trxAddress" class="form-label">Recipient ${cryptoType} Address:</label>
        <div class="input-group">
            <input type="text" class="form-control" id="trxAddress" value="${SelectedWalletAdress}" readonly>
            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('trxAddress')">Copy</button>
        </div>
    </div>
    <div class="mb-3">
        <label for="trxAmount" class="form-label">Amount to Send (${cryptoType}):</label>
        <div class="input-group">
            <input type="text" class="form-control" id="trxAmount" value="${amount}" readonly>
            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('trxAmount')">Copy</button>
        </div>
    </div>
    <button type="button" class="btn btn-success" onclick="showHashInput()">Sent</button>
</div>


					</div>
						</div>
                </div>
            </div>
        </div>
    </div>

`;
	
	
}


</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>
