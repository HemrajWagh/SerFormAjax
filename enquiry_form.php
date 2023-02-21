<?php 
session_start();
$allErrs = $name = $nameErr = $tym = $tymErr = $email = $emailErr = $phone = $phoneErr = $message = $messageErr = $projectErr = "";
if(isset($_SESSION['errors'])){
  $allErrs = $_SESSION['errors'];
}

if(isset($_SESSION['postval'])){
  $allpostval =$_SESSION['postval'];
}

if(isset($allpostval['name'])){
  $name = $allpostval['name'];
}

if(isset($allpostval['email'])){
  $email = $allpostval['email'];
}

if(isset($allpostval['phone'])){
  $phone = $allpostval['phone'];
}

if(isset($allpostval['message'])){
  $message = $allpostval['message'];
}

if(isset($allpostval['tym'])){
  $tym = $allpostval['tym'];
}

if(isset($allErrs['name'])){
  $nameErr = $allErrs['name'];
}

if(isset($allErrs['email'])){
  $emailErr = $allErrs['email'];
}


if(isset($allErrs['phone'])){
  $phoneErr = $allErrs['phone'];
}


if(isset($allErrs['tym'])){
  $tymErr = $allErrs['tym'];
}


if(isset($allErrs['message'])){
  $messageErr = $allErrs['message'];
}

if(isset($allErrs['pid'])){
  $projectErr = $allErrs['pid'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Contact Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body style="padding:3% ;">

<div class="container" style="box-shadow:
  0 12.5px 10px rgba(0, 0, 0, 0.06),
  0 22.3px 17.9px rgba(0, 0, 0, 0.072),
  0 41.8px 33.4px rgba(0, 0, 0, 0.086),
  0px 0px 25px 25px rgba(0, 0, 0, 0.20);
   padding:15px;">
  <h2>Contact Form</h2>
  <form  id="formdata">
  	<div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" value="<?php if(isset($allpostval['name'])){echo $name;} ?>">
      <span class="text-danger"><?php echo $nameErr; ?></span>
    </div>

    <div class="form-group">
      <label for="email">E-mail:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" value="<?php if(isset($allpostval['email'])){echo $email;} ?>" maxlength="35">
      <span class="text-danger"><?php echo $emailErr; ?></span>
    </div>
    
    <div class="form-group">
      <label for="phone">Mobile No:</label>
      <input type="number" class="form-control" id="phone" placeholder="Enter Mobile No." name="phone" value="<?php if(isset($allpostval['phone'])){echo $phone;} ?>">
      <span class="text-danger"><?php echo $phoneErr; ?></span>
    </div>
    
    <div class="form-group">
      <!-- <label for="pid">Project:</label> -->
      <input type="hidden" id="pid" name="pid" value="542697205146839813">
      <!-- <select name="pid" id="pid" class="form-control"> -->
        <!-- <option value="">Select Project</option> -->
        <!-- <option value="527663432578816202">All</option> -->
       
        <!-- <option value="527663432578816438">Springs</option> -->
       <!--  <option value="527663432578816955">Mystic</option>   
        <option value="542697205146839434">Saffron</option>
        <option value="542697205146839813">Serenity</option>
      </select> -->
      
      <span class="text-danger"><?php echo $projectErr; ?></span>
    </div>

    <div class="form-group">
      <label for="tym">Prefered Time To Call:(10am to 7pm)</label>
      <input type="text" name="tym" class="form-control" id="tym" placeholder="Prefered Time To Call" value="<?php if(isset($allpostval['tym'])){echo $tym;} ?>">
      <span class="text-danger"><?php echo $tymErr; ?></span>
    </div>
    
    <div class="form-group">
      <label for="message">Message:</label>
      <input type="textarea" class="form-control" id="message" placeholder="Enter Message" name="message" value="<?php if(isset($allpostval['message'])){echo $message;} ?>">
      <span class="text-danger"><?php echo $messageErr; ?></span>
    </div>  
      <input type="hidden" name="campaign" value="KP_Digital">
      <input type="hidden" name="source" value="Website">
    <button type="submit" id="submit" name="submit" class="btn btn-success">Submit</button>
  </form>
</div>
</body>
</html>

  <head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  </head>

<script>
    $(function(){
       $('#submit').click('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: "http://127.0.0.1/SerenityFormAjax/save.php",
                type: "POST",
                data: $("#formdata").serialize(),
                success: function(data){
                  // if (data == true) {
                      // alert("Successfully submitted.")
                      window.location = "http://127.0.0.1/SerenityFormAjax/thank-you.php";
                                  // }

                }
            });
       }); 
    });
</script>


<?php 
session_destroy();
?>