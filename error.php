<!DOCTYPE html>
<html lang="en">
<head>
  <title>Error</title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css" />
</head>
<body class="errorBody">
<?php
  session_start();

  $username = ($_SESSION['username'] ?? '');
  if (!$username) {
    header('Location: login.php');
    exit;
  }

  $error_message = (string)($_GET['error'] ?? '');
  if (!$error_message) {
    header('Location: index.php');
    exit;
  }
?>
  <div class="errorPage">
    <div class="errorPageContainer">
      <div class="errorPageMessage">
        <?php
          echo htmlentities($error_message);
        ?>
      </div>
      <div class="errorPageReturnLink">
        <a href="index.php">
          <div class="errorPageReturnLinkButton">Go Back To Drive</div>
        </a>
      </div>
    </div>
  </div>
</body>
</html>