

var BitGoJS = require('bitgo');
var bitgo = new BitGoJS.BitGo({accessToken:'v2xbb5a25281bcd6f05135c7316fb206c0d0eb391c9b0753c9d5ca9cb31e7783bdf'});








let walletId = '5ac7ac3890138dc207576d838673100f';

bitgo.coin('tbtc').wallets().get({ id: walletId })
.then(function(wallet) {
  // print the wallet
  

	wallet.transfers()
	.then(function(transfers) {
	  // print transfers
	for(i=0;i<transfers.transfers.length; i++){
	  console.dir(transfers.transfers[i].entries[0].address);
	}
});


});


