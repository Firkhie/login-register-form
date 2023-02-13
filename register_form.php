<?php

@include 'db_connect.php';

if (isset($_POST['submit'])) {

   $name = strtolower(mysqli_real_escape_string($conn, $_POST['name']));
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = " SELECT * FROM user_form WHERE name = '$name' || email = '$email' ";

   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
         if ($row['name'] == $name) {
            $error[] = 'Name already taken!';
         } else if ($row['email'] == $email) {
            $error[] = 'Email has been used!';
         }
      }
   } else {
      if ($pass !== $cpass) {
         $error[] = 'Password not matched!';
      } else {
         $insert = " INSERT INTO user_form (name, email, password, user_type) VALUES('$name', '$email', '$pass', '$user_type') ";
         mysqli_query($conn, $insert);
         header('location: login_form.php');
      };
   };

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
         <h3>Register Now</h3>

         <?php
         
         if (isset($error)) {
            foreach($error as $error) {
               echo '<span class="error-msg">'.$error.'</span>';
            };
         };

         ?>
         
         <input type="text" name="name" placeholder="Enter your name" required>
         <input type="email" name="email" placeholder="Enter your email" required>
         <input type="password" name="password" placeholder="Enter your password" required>
         <input type="password" name="cpassword" placeholder="Confirm your password" required>
         <select name="user_type">
            <option value="user">User</option>
            <option value="admin">Admin</option>
         </select>
         <input type="submit" name="submit" value="Register Now" class="form-btn">
         <p>Already have an account? <a href="login_form.php">login now</a></p>
      </form>

   </div>
   
</body>
</html>