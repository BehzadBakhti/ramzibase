
var BitGoJS = require('bitgo');
input=process.argv;// arguments passed buy PHP to Node Js
var bitgo = new BitGoJS.BitGo({accessToken:input[4]});


var recipients = [];
//var fs = require('fs');
var array = input[2].split("_");

array.pop();// to remove the empty Item after las"_"


for(i in array) {
	var a = [];
	a[i] = array[i].split(',');
	a[i][1] = parseInt(10e7*a[i][1],10);
	recipients.push({amount: a[i][1], address: a[i][0] });

}


var walletPassphrase = input[3] // replace with wallet passphrase
walletPassphrase='behzad9189442305hani' // just for Test
var walletId = input[5] //  '5ac7ac3890138dc207576d838673100f'
                                                                

let params = {
  recipients: recipients,
  walletPassphrase: walletPassphrase
};
console.dir(params)
bitgo.coin(input[6]).wallets().get({ id: walletId })
.then(function(wallet) {
  // print the wallet
      wallet.sendMany(params)
      .then(function(transaction) {
        // print transaction details
        console.dir(transaction);
      });

});
