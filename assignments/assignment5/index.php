<?php
require_once "classes/Directories.php";

$message = "";
$linkPath = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dirName = $_POST["dirname"] ?? "";
    $content = $_POST["content"] ?? "";

    $directory = new Directories($dirName, $content);
    $result = $directory->createDirectoryAndFile();

    if ($result["success"]) {
        $linkPath = $result["path"];
    } else {
        $message = $result["error"];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Directory Creator</title>
</head>
<body>

<?php if ($linkPath): ?>
    <p><a href="<?php echo $linkPath; ?>">Path where the file is located</a></p>
<?php endif; ?>

<?php if ($message): ?>
    <p style="color:red;"><?php echo $message; ?></p>
<?php endif; ?>

<form method="post">
    <label>Directory Name:</label><br>
    <input type="text" name="dirname" required><br><br>

    <label>File Content:</label><br>
    <textarea name="content" rows="6" cols="40" required></textarea><br><br>

    <button type="submit">Submit</button>
</form>

</body>
</html>