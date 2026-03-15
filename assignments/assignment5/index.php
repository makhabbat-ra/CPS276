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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

   <!-- Top Heading -->
<div class="mb-4 text-start">
    <h2 class="fw-bold">File and Directory Assignment</h2>
    <p>
        Enter a folder name and the contents of a file. Folder names should contain alpha numeric characters only.
    </p>
</div>



    <?php if ($linkPath): ?>
    <p>File and directory were created.</p>
    <p><a href="<?php echo $linkPath; ?>">Path where the file is located</a></p>
<?php endif; ?>

<?php if ($message): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>


    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" class="row g-3">

                <div class="col-12">
                    <label for="dirname" class="form-label">Folder Name</label>
                    <input type="text" id="dirname" name="dirname" class="form-control" required>
                </div>

                <div class="col-12">
                    <label for="content" class="form-label">File Content</label>
                    <textarea id="content" name="content" class="form-control" rows="6" required></textarea>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>

            </form>
        </div>
    </div>

</div>

</body>
</html>