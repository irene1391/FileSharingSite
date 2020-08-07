<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css" />
  <link href="https://fonts.googleapis.com/css?family=Freckle+Face&display=swap" rel="stylesheet">
</head>
<body class="loginBody">
  <div class="loginContainer">
<?php
if(isset($_POST['user_input'])) {
  $user_list = fopen("../mod2/hidden/users.txt", "r");
  $user_input = (string) $_POST['user_input'];
  $is_passed = false;

  while(!feof($user_list)) {
    $user_listcheck = fgets($user_list);
    if(strcmp(trim($user_listcheck), $user_input) == 0) {
      $is_passed = true;
      break;
    }
  }
  fclose($user_list);

  if($is_passed) {
    session_start();
    $_SESSION['username'] = $user_input;
    header("Location: index.php");
    exit;
  } else {
    echo '<div class="loginMessage">User do not exist, please try again or register.</div>';
  }
}
?>
    <div class="loginFormContainer">
      <div class="loginFormTitle">Login</div>
      <form method="POST">
        <input type="text" class="loginFormInput" name="user_input">
        <input type="submit" class="loginFormButton loginFormButtonLogin" name="Login">
      </form>
      <div class="loginFormButtonRegister">
        <a href="./register.php">
          <div class="loginFormButton">Register</div>
        </a>
      </div>
    </div>
  </div>
</body>
</html>