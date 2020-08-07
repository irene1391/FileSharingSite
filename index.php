<!DOCTYPE html>
<html lang="en">
<head>
    <title>Index</title>
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
</head>
<body class="directoryBody">
<?php
session_start();

// Init cache
$_SESSION['file_path'] = NULL;
$_SESSION['file_path_array'] = [];
$_SESSION['view_file_path_array'] = [];

$username = ($_SESSION['username'] ?? '');

if (!$username) {
    header("Location: login.php");
    exit;
}

$user_dir = '../mod2/' . $username;
$files = [];

// Files aggregation
foreach (glob($user_dir . '/*') as $index => $file_path) {
    $files[] =  [
        'path' => $file_path,
        'name' => str_replace($user_dir . '/', "", $file_path),
        'index' => $index
    ];
}
?>
<div class="directoryContainer">
    <div class="directoryContent">
        <div class="directoryWelcomeMessageContainer">
            <div class="directoryWelcomeMessageTitle">
                <strong>Welcome</strong>
<?php
echo htmlentities($username);
?>
            </div>
        </div>
        <div class="directoryLinkContainer">
            <a href="./upload.php">
                <div class="directoryLinkButton directoryLinkButtonLogout">Upload</div>
            </a>
            <a href="./logout.php">
                <div class="directoryLinkButton directoryLinkButtonLogout">Logout</div>
            </a>
        </div>
        <form method="POST">
            <table class="directoryTable">
                <tbody class="directoryTableBody">
<?php
if (!count($files)) {
    echo '<tr class="directoryTableRow directoryTableRowInfo">No file found.</tr>';
} else {
    foreach ($files as $file) {
        echo '<tr class="directoryTableRow">';
        echo '<td class="directoryTableCell directoryTableCellCheckbox"><input class="directoryCheckbox" type="checkbox" name="file_indexes[]" value="' . (string)$file['index'] . '"></td>';
        echo '<td class="directoryTableCell directoryTableCellFilename">' . htmlentities((string)$file['name']) . '</td>';
        echo '</tr>';
    }
}
?>
                    <tr class="directoryTableRow directoryTableRowButtons">
                        <td class="directoryTableRowButtonsCellSpace">&nbsp;</td>
                        <td class="directoryTableRowButtonsCell">
                            <input class="directoryTableSubmitButton directoryTableSubmitButtonDisplay" type="submit" name="goto_display" value="Display">
                            <input class="directoryTableSubmitButton directoryTableSubmitButtonDownload" type="submit" name="goto_download" value="Download">
                            <input class="directoryTableSubmitButton directoryTableSubmitButtonDelete" type="submit" name="goto_delete" value="Delete">
                            <input class="directoryTableSubmitButton directoryTableSubmitButtonCompress" type="submit" name="goto_compress" value="Compress">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
<?php
if (isset($_POST['file_indexes'])) {
    $file_path_array = [];
    $file_indexes = $_POST['file_indexes'];

    foreach ($file_indexes as $file_index) {
        foreach ($files as $file) {
            if ((int)$file_index == $file['index']) {
                $file_path_array[] = $file['path'];
            }
        }
    }

    if (count($file_path_array)) {
        $_SESSION['file_path_array'] = $file_path_array;

        $action = (string)(($_POST['goto_display'] ?? '') . ($_POST['goto_delete'] ?? '') . ($_POST['goto_compress'] ?? '') . ($_POST['goto_download'] ?? ''));

        switch ($action) {
            case 'Display':
                header('Location: display.php');
                break;

            case 'Delete':
                header('Location: delete.php');
                break;

            case 'Compress':
                header('Location: compress.php');
                break;

            case 'Download':
                header('Location: download.php');
                break;

            default:
                $_SESSION['file_path_array'] = [];
                break;
        }
    }
}
?>
</body>
</html>