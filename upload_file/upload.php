<?php
// header('Content-Type: application/json');

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

$owner = $_POST['owner'] ?? '';
$category = $_POST['category'] ?? '';
$pic = $_POST['pic'] ?? '';
$message = $_POST['message'] ?? null;
// Convert empty string to NULL
if ($message === '' || strtolower($message) === 'null') {
    $message = null;
}

// Default values when no file
$fileName   = null;
$fileStream = null;

// Check if file uploaded
if (isset($_FILES['the_file']) && $_FILES['the_file']['error'] === UPLOAD_ERR_OK) {
    $fileTmp  = $_FILES['the_file']['tmp_name'];
    $fileName = $_FILES['the_file']['name'];
    $fileType = mime_content_type($fileTmp);

    // Restrict to PDF only
    if ($fileType !== "application/pdf") {
        echo "Only PDF files are allowed.";
        exit;
    }

    // Open file as a stream
    $fileStream = fopen($fileTmp, "rb");
}

$sql = "INSERT INTO UploadedFiles (pic, category, owner, filename, filedata, message) 
        VALUES (?, ?, ?, ?, ?, ?)";
$params = [
    [$pic, SQLSRV_PARAM_IN],
    [$category, SQLSRV_PARAM_IN],
    [$owner, SQLSRV_PARAM_IN],
    [$fileName, SQLSRV_PARAM_IN],   // may be NULL if no file
    [$fileStream, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_STREAM(SQLSRV_ENC_BINARY), SQLSRV_SQLTYPE_VARBINARY('max')],
    [$message, SQLSRV_PARAM_IN]
];

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt) {
    echo "✅ Data saved successfully!";
} else {
    echo "❌ Save failed: " . print_r(sqlsrv_errors(), true);
}

?>
