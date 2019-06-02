
var BitGoJS = require('bitgo');
input=process.argv;// arguments passed buy PHP to Node Js
var bitgo = new BitGoJS.BitGo({accessToken:input[2] });



let walletId = input[3] //'5ac7ac3890138dc207576d838673100f';

bitgo.coin(input[4]).wallets().get({ id: walletId })
.then(function(wallet) {
  // print the wallet


   wallet.transfers()
        .then(function(transfers) {
          // print transfers
     for(i=0;i<transfers.transfers.length; i++){
  	   for(j=0;j<transfers.transfers[i].entries.length;j++){
        	 	 if(transfers.transfers[i].value>0 && transfers.transfers[i].entries[j].value == transfers.transfers[i].value){
                   	console.log(transfers.transfers[i].entries[j].address);
        	   	console.log(transfers.transfers[i].value);
        		  }
            }
       }

    //console.log(transfers.transfers[1]);
    });


});

