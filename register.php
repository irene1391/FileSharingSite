<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
</head>
<body class="registerBody">
    <div class="registerContainer">
        <div class="registerContent">
<?php
if(isset($_POST['newuser'])) {
    $existing_user_list = fopen('../mod2/hidden/users.txt','r');
    $user_list = fopen('../mod2/hidden/users.txt','a');

    if (!$user_list) {
        echo '<div class="errorMessage">Cannot open file</div>';
        exit;
    }

    $user_input = (string) $_POST['newuser'];
    $user_input = trim($user_input);
    $list_write = "\n" . $user_input;

    if (preg_match('/^[A-Za-z0-9]+$/', $user_input) && $user_input != 'hidden') {
        $is_dupe = false;

        while(!feof($existing_user_list)) {
            $user_listcheck = trim(fgets($existing_user_list));

            if(strcmp($user_listcheck, $user_input) == 0) {
                $is_dupe = true;
                break;
            }
        }

        fclose($existing_user_list);

        if (!$is_dupe) {
            if (fwrite($user_list, $list_write) !== FALSE) {

                fclose($user_list);

                if (mkdir("../mod2/" . $user_input, 0755)){
                    session_start();

                    $_SESSION['username'] = $user_input;

                    header('Location: login.php');
                    exit;
                } else {
                    echo '<div class="errorMessage">Cannot create directory</div>';
                }
            } else {
                fclose($user_list);
                echo '<div class="errorMessage">Cannot write file</div>';
            }
        } else {
            fclose($user_list);
            echo "<div class=\"errorMessage\">Invalid username</div>";
        }
    } else {
        fclose($user_list);
        echo "<div class=\"errorMessage\">Invalid username</div>";
    }
}
?>
            <form method="POST">
                <p>
                    <input class="registerInput" placeholder="New Username..." type="text" name="newuser" id="newuser">
                </p>
                <p>
                    <input class="registerSubmit" type="submit" name="Register">
                </p>
            </form>
            <a href="login.php">
                <div class="registerButtonCancel">Cancel</div>
            </a>
        </div>
    </div>
</body>
</html>