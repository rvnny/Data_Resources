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

$owner = $_POST['owner'] ?? '';

$sql = "
        SELECT * FROM UploadedFiles WHERE owner = '$owner' ORDER BY uploaded_at DESC
";

$stmt = sqlsrv_query($conn, $sql);

$files = [];

if ($stmt) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $files = [
            "id"            => $row['id'],
            "filename"      => $row['filename'],
            "uploaded_at"   => $row['uploaded_at'] instanceof DateTime ? $row['uploaded_at']->format("Y-m-d H:i:s") : null,
            "owner"         => $row['owner']
        ];
    }
    header("Content-Type: application/json");
    echo json_encode($files);
} else {
    http_response_code(500);
    echo json_encode(["error" => sqlsrv_errors()]);
}

?>