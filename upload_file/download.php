<?php
$serverName = "DESKTOP-5OL6G85\SQLEXPRESS"; 
$connectionOptions = [
    "Database" => "MasterDB",
    "Uid" => "",
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if (!$conn) {
    die("DB connection failed");
}

$id = (int)($_GET['id'] ?? 0);

$sql = "SELECT filename, filedata FROM UploadedFiles WHERE id = ?";
$stmt = sqlsrv_query($conn, $sql, [$id]);

if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    header("Content-Type: application/pdf");
    header("Content-Disposition: attachment; filename=\"" . $row['filename'] . "\"");

    // Handle stream or binary directly
    if (is_resource($row['filedata'])) {
        fpassthru($row['filedata']);
        fclose($row['filedata']);
    } else {
        echo $row['filedata'];
    }
    exit;
}

echo "<script>alert('File not found.');</script>";
exit;
?>
