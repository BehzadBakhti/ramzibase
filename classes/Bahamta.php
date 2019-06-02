<?php
	
class Bahamta{

	public function checkPayments($lastCheck){

        $checkURL=  "https://api.bahamta.com/v2/".PHONE_NO."/funds/".FUND_ID."/bills?since=".$lastCheck;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $checkURL);
        curl_setopt($curl, CURLOPT_HTTPHEADER,  array('Content-type: application/json', 'access-token:'.IRR_API_KEY));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            //$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $response = curl_exec($curl);
        curl_close($curl);
 
/*{"bills":
    [{"fund_id":24157,
        "bill_id":1,
        "code":"674589",
        "url":"https://bahamta.com/24157/1-674589",
        "pay_id":null,
        "requested":"2018-04-23T19:36:32.414Z",
        "rejected":"2018-04-23T19:40:27.064Z",
        "payed":null,
        "status":"canceled",
        "state":"reject",
        "amount":"1500000",
        "note":"عضویتِ ماهانه ی دی ماهِ ۹۳",
        "payer_number":"989125208859",
        "payer_name":"بهرنگ نوروزی نیا",
        "fund_name":"بهزاد بختی",
        "iban":"IR610180000000004825551501",
        "account_owner":"بهزاد بختی",
        "created":"2018-04-23T19:36:32.414Z",
        "modified":"2018-04-23T19:40:27.064Z",
        "display":"2018-04-23T19:40:27.064Z",
        "request_time":"2018-04-23T19:36:32.414Z",
        "requester":"989378970570",
        "reject_time":"2018-04-23T19:40:27.064Z",
        "rejecter":"989378970570",
        "pay_time":null,
        "pay_wage":"0",
        "pay_trace":"",
        "pay_pan":"",
        "transfer_estimate":null,
        "transfer_trace":""}
     ],
    "until":"2018-04-23T19:41:48.277Z"}*/

        return $response;

    }



	
	

	

}