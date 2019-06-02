

<?php 

$filename="db_backup_".date('Y-M-d_H:i').".sql";

$result=exec('mysqldump c1db  --password=behzad9189442305  --user=c1dbadmin  --single-transaction >/var/www/clients/client1/backups/'.$filename,$output);

if(empty($output)){
/* no output is good */

    $path= "/var/www/clients/client1/backups" ;
    $file = $path . "/" . $filename;

    $mailto = "ramzinex2018@gmail.com";
    $subject = "Databse Backup";
    $message = "this is the backup file for the ramzibase database taken at: ".date('Y-M-d_H:1');

    $content = file_get_contents($file);
    $content = chunk_split(base64_encode($content));

    // a random hash will be necessary to send mixed content
    $separator = md5(time());

    // carriage return type (RFC)
    $eol = "\r\n";

    // main header (multipart mandatory)
    $headers = "From: Ramzibase Admin <admin@ramzibase.com>" . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
    $headers .= "This is a MIME encoded message." . $eol;

    // message
    $body = "--" . $separator . $eol;
    $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
    $body .= "Content-Transfer-Encoding: 8bit" . $eol;
    $body .= $message . $eol;

    // attachment
    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol;
    $body .= "Content-Disposition: attachment" . $eol;
    $body .= $content . $eol;
    $body .= "--" . $separator . "--";

    //SEND Mail
    if (mail($mailto, $subject, $body, $headers)) {
        echo "mail send ... OK"; // or use booleans here
    } else {
        echo "mail send ... ERROR!";
    }

}
else {/* we have something to log the output here*/}


?>
