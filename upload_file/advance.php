<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded PDFs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Upload File</h1>
    <div class="file_container">
        <div class="row">
            <div class="col">
                <span class="view_id"></span>
            </div>
            <div class="col">
                <span class="view_name"></span>
            </div>
            <div class="col">
                <span class="view_date"></span>
            </div>
            <div id="btn_data" class="col">
                <button class="download_file">Download</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $.ajax({
                type: "post",
                url: "fetch_files.php",
                data: { owner: '6768' },
                dataType: "json",
                success: function (response) {
                    // var d = JSON.parse(response);

                    $('.view_id').text(response.id);
                    $('.view_name').text(response.filename);
                    $('.view_date').text(response.uploaded_at);

                    if (response.filename === null) {
                        $('#btn_data').addClass('d-none');
                    }
                }
            });

            $(document).on('click', '.download_file', function () {
                var id = $('.view_id').text();

                window.location.href = "download.php?id=" + id;
            });
        });
    </script>

</body>
</html>