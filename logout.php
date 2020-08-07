<!DOCTYPE html>
<html lang="en">
<head>
	<title>Logout</title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css" />
</head>
<body class="logoutBody">
  <div class="logoutContainer">
    <div class="logoutContent">
      <div class="logoutMessage">
<?php
session_start();
session_destroy();
?>
        You have logged out.<br/>
        <a href="login.php">Click here to Login</a>
      </div>
    </div>
  </div>
</body>
</html>