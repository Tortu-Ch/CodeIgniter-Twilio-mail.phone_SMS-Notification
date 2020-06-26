<?php
$servername = "garmysqlserver.mysql.database.azure.com";
$username = "garadmin@garmysqlserver";
$password = "Caca2015";
$dbname = "garmysqlserver";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
require __DIR__ . '/twilio-php-master/Twilio/autoload.php';
use Twilio\Rest\Client;

$query="SELECT * FROM projects WHERE sms=0";
$result=$conn->query($query);
if($result->num_rows>0) {
while ($row=$result->fetch_assoc()) {
$idd=$row["id"]; $uid=$row["client_id"]; $ev=$row["title"]; 
$cr=$row["description"];
echo $uid;
$query2="SELECT * FROM clients WHERE id=$uid";
$result2=$conn->query($query2);
if($result2->num_rows>0) {
while ($row2=$result2->fetch_assoc()) {
$id2=$row2["id"]; $ph=$row2["phone"]; $ph="+".$ph;

 $ever="Added Demo Trabajador in project. PROJECT : ".$ev;

// Your Account SID and Auth Token from twilio.com/console
$sid = 'AC490f0212f5fef4f538d8791cf0aded11';
$token = 'f8945a67f348afa1460f7d4c3ace8399';
$client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!
$client->messages->create(
    // the number you'd like to send the message to
     $ph ,
    array(
        // A Twilio phone number you purchased at twilio.com/console
        'from' => '+17036599762',
        // the body of the text message you'd like to send
        'body' => "$ever"
    )
);

 $sql = "UPDATE projects SET sms='1' WHERE id=$idd";

if ($conn->query($sql) === TRUE) {
   echo "SMS NOTIFICTATION SENT TO USERS PHONE ON: ". $ph; 
} 



}}

}}
else{ echo "No New Notification Recieved"; }









$query3="SELECT * FROM tasks WHERE sms=0 ";
$result3=$conn->query($query3);
if($result3->num_rows>0) {
while ($row3=$result3->fetch_assoc()) {
$idd2=$row3["id"]; $uid=$row3["project_id"]; $ev2=$row3["title"]; 
$cr=$row3["description"];
echo $uid;




$query4="SELECT * FROM projects WHERE id=$uid ";
$result4=$conn->query($query4);
if($result4->num_rows>0) {
while ($row4=$result4->fetch_assoc()) {
$idd4=$row4["id"]; $cidd4=$row4["client_id"];




$query0="SELECT * FROM clients WHERE id=$cidd4";
$result0=$conn->query($query0);
if($result0->num_rows>0) {
while ($row0=$result0->fetch_assoc()) {
$id0=$row0["id"]; $ph=$row0["phone"]; $ph="+".$ph;


 $ever2="Created A new Task#". $idd2." : PROJECT : ".$ev2;

// Your Account SID and Auth Token from twilio.com/console
$sid = 'AC490f0212f5fef4f538d8791cf0aded11';
$token = 'f8945a67f348afa1460f7d4c3ace8399';
$client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!
$client->messages->create(
    // the number you'd like to send the message to
     $ph ,
    array(
        // A Twilio phone number you purchased at twilio.com/console
        'from' => '+17036599762',
        // the body of the text message you'd like to send
        'body' => "$ever2"
    )
);

 $sql = "UPDATE tasks SET sms='1' WHERE id=$idd2";

if ($conn->query($sql) === TRUE) {
   echo "SMS Task SENT TO USERS PHONE ON: ". $ph; 
} 




}}


}}








}}
else{ echo "No New Task notification Recieved"; }








$query33="SELECT * FROM project_comments WHERE sms=0 ";
$result33=$conn->query($query33);
if($result33->num_rows>0) {
while ($row33=$result33->fetch_assoc()) {
$idd2=$row33["id"]; $uid=$row33["project_id"]; $ev2=$row33["title"]; 
$cr=$row33["description"];
echo $uid;




$query43="SELECT * FROM projects WHERE id=$uid ";
$result43=$conn->query($query43);
if($result43->num_rows>0) {
while ($row43=$result43->fetch_assoc()) {
$idd4=$row43["id"]; $cidd4=$row43["client_id"];




$query03="SELECT * FROM clients WHERE id=$cidd4";
$result03=$conn->query($query03);
if($result03->num_rows>0) {
while ($row03=$result03->fetch_assoc()) {
$id0=$row03["id"]; $ph=$row03["phone"]; $ph="+".$ph;


 $ever2="Commented On A Task.  Task#". $idd2." Comment: ".$cr;

// Your Account SID and Auth Token from twilio.com/console
$sid = 'AC490f0212f5fef4f538d8791cf0aded11';
$token = 'f8945a67f348afa1460f7d4c3ace8399';
$client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!
$client->messages->create(
    // the number you'd like to send the message to
     $ph ,
    array(
        // A Twilio phone number you purchased at twilio.com/console
        'from' => '+17036599762',
        // the body of the text message you'd like to send
        'body' => "$ever2"
    )
);

 $sql = "UPDATE project_comments SET sms='1' WHERE id=$idd2";

if ($conn->query($sql) === TRUE) {
   echo "SMS comments SENT TO USERS PHONE ON: ". $ph; 
} 




}}


}}








}}
else{ echo "No  Task Commented notification Recieved"; }





?>