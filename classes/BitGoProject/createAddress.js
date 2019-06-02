
var BitGoJS = require('bitgo');
input=process.argv;// arguments passed buy PHP to Node Js

var bitgo = new BitGoJS.BitGo({accessToken:input[2]});


let walletId = input[3];//'5ac7ac3890138dc207576d838673100f'

bitgo.coin(input[4]).wallets().get({ id: walletId })
.then(function(wallet) {

		wallet.createAddress({ label: 'New Address' })
		.then(function(address) {
		  // print new address
		  console.dir(address.address);
		});

});