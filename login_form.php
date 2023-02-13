<?php

@include 'db_connect.php';

if (isset($_POST['submit'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $pass = md5($_POST['password']);

   $select = " SELECT * FROM user_form WHERE name = '$name' ";

   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
         if ($row['password'] === $pass) {
            if ($row['user_type'] === 'user') {
               header('location: user_page.php');
            } else {
               header('location: admin_page.php');
            }
         } else {
            $error[] = 'Wrong password!';
         }
      }
   } else {
      $error[] = 'Name not found!';
   }

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register Form</title>

   <!----------------- CSS FILE LINK ----------------->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

   <div class="form-container">

      <form action="" method="post">
         <h3>Login Now</h3>

         <?php
         
         if (isset($error)) {
            foreach($error as $error) {
               echo '<span class="error-msg">'.$error.'</span>';
            };
         };

         ?>
         
         <input type="text" name="name" placeholder="Enter your name" required>
         <input type="password" name="password" placeholder="Enter your password" required>
         <input type="submit" name="submit" value="Register Now" class="form-btn">
         <p>Dont have an account? <a href="register_form.php">register now</a></p>
      </form>

   </div>
   
</body>
</html>