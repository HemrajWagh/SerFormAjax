<?php
session_start();
$name = $tym = $message = $email = $phone = $pid = "";
$err = [];

$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=contact_form", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

if(isset($_POST['name']) && !empty($_POST['name'])){
  $name = $_POST['name'];
}else{
  $err['name'] = "Name is Required";
}

if (validate_phone_number($_POST['phone']) == true) {
   if(isset($_POST['phone']) && !empty($_POST['phone'])){
    $phone = $_POST['phone'];
  }else{
     $err['phone'] = "Mobile number is Required";
  }
} else {
    $err['phone'] = "Invalid Mobile number";
}

// var_dump(strlen($_POST['email']) > 30);die();
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
  $err['email'] = "Invalid email format";
}else if(isset($_POST['email']) && !empty($_POST['email'])){
  $email = $_POST['email'];
}else{
  $err['email'] = "Email is Required";
}

if(!preg_match("/^[a-zA-Z0-9]+$/", $_POST['tym'])){
  $err['tym'] = "Only Alphabets & Numbers allowed";
}else if(isset($_POST['tym']) && !empty($_POST['tym'])){
  $tym = $_POST['tym'];
}else{
  $err['tym'] = "Call Time is Required";
}

if(isset($_POST['message']) && !empty($_POST['message'])){
  $message = $_POST['message'];
}else{
  $err['message'] = "Message is Required";
}

if(isset($_POST['pid']) && !empty($_POST['pid'])){
  $pid = $_POST['pid'];
}else{
  $err['pid'] = "Project Name is Required";
}

if(count($err) == 0){
  $projects = array(
  // "527663432578816438" => "Springs",
  // "527663432578816955" => "Mystic",  
  // "542697205146839434" => "Saffron",
  "542697205146839813" => "Serenity"
                );

$query = "INSERT INTO enquiries SET name=:name, email=:email, mobile_no=:phone, call_time=:tym, message=:message, project_name=:pid, campaign=:campaign, source=:source";

  $stmt = $conn->prepare($query);
  $name = htmlspecialchars(strip_tags($name));
  $email = htmlspecialchars(strip_tags($email));
  $phone = htmlspecialchars(strip_tags($phone));
  $tym = htmlspecialchars(strip_tags($tym));
  $message = htmlspecialchars(strip_tags($message. " Calling Time:" . $tym));
  $pid = htmlspecialchars(strip_tags($pid));
  $campaign = "Megapolis_Digital";
  $source = "MP_Digital";
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(":email", $email);
  $stmt->bindParam(":phone", $phone);
  $stmt->bindParam(":tym", $tym);
  $stmt->bindParam(":message", $message);

  
  // var_dump($projects[$project_name]);die();
  $stmt->bindParam(":pid", $projects[$pid]);
  $stmt->bindParam(":campaign", $campaign);
  $stmt->bindParam(":source", $source);
  if($stmt->execute()){
  //   return true;
                    
    $project = $projects[$pid];
    $wuid= '527748409256816694_ws_527660047398816469';
    $uid= '527660047398816469';
    $campaign= 'Megapolis_Digital';
    $source= 'MP_Digital';

    $RQurl = 'http://api.realtyredefined.in/rqLeadAPI.php?wuid=' . $wuid . '&name=' . urlencode($name) . '&mobile=' . urlencode($phone) . '&email=' . urlencode($email) . '&Source=' . urlencode($source) . '&Message=' . urlencode($message) . '&Campaign=' . $campaign . '&pid=' . $pid . '&uid=' . $uid;
                          
      $RQch = curl_init();
      curl_setopt($RQch, CURLOPT_URL, $RQurl);
      curl_setopt($RQch, CURLOPT_HEADER, 0);
      curl_setopt($RQch, CURLOPT_RETURNTRANSFER, true);
      $RQresult = curl_exec($RQch);
      curl_close($RQch);
      
// echo $RQurl;die();
      //email

      $to = "richard.mudaliar@megapolis.co.in, himanshu.chhatraband@kumarworld.com, hanmant.sankpal@kumarworld.com, hemraj.wagh@kumarworld.com";
  
        $subject = "Megapolis Enquiry -" .$project; 
        
        $body  = '<html><body>';
        $body .= '<table rules="all" style="border-color: #666;" cellpadding="10">';    
        $body .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" .$name. "</td></tr>";
          $body .= "<tr><td><strong>Email:</strong> </td><td>" . $email. "</td></tr>";
        $body .= "<tr><td><strong>Phone:</strong> </td><td>" .  $phone. "</td></tr>";
        $body .= "<tr><td><strong>Calling Time:</strong> </td><td>" .  $tym. "</td></tr>";
        $body .= "<tr><td><strong>Message:</strong> </td><td>" . $message. "</td></tr>";
          $body .= "<tr><td><strong>Project:</strong> </td><td>"  .$project. "</td></tr>";
            $body .= "<tr><td><strong>Source:</strong> </td><td>" .$project. "</td></tr>";
        $body .= "</table>";
          $body .= "</body></html>";
          
      $headers = "From: Megapolis Enquiry \r\n";
        //$headers .='X-Mailer: PHP/' . phpversion();
             //$headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
      
    $send = mail($to, $subject, $body, $headers);

      header('Location: /projects/thank-you.php');
    }else{
        return false;
      }  
}else{
  $_SESSION['errors'] = $err;
  $_SESSION['postval'] = $_POST;
  header('Location: enquiry_form.php');
}

function validate_phone_number($phone)
{    
   if (strlen($phone) <= 10) {
      return true;
   } else {
     return false;
   }
}

// function validate_email($email)
// {    
//    if (strlen($email) <= 30) {
//       return true;
//    } else {
//      return false;
//    }
// }
  
?>