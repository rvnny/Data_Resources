<?php

$serverName = "DESKTOP-5OL6G85\SQLEXPRESS"; 
$connectionOptions = [
    "Database" => "MasterDB",
    "Uid" => "",
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if (!$conn) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

$sql = "SELECT id, filename, uploaded_at FROM UploadedFiles WHERE owner = '1111' ORDER BY uploaded_at DESC";
$stmt = sqlsrv_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Uploaded PDFs</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Uploaded Files</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Filename</th>
            <th>Uploaded At</th>
            <th>Action</th>
        </tr>
        <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['filename']) ?></td>
                <td><?= $row['uploaded_at']->format("Y-m-d H:i:s") ?></td>
                <td>
                    <form action="download.php" method="get">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit">Download</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
