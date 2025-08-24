<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PDF Upload</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <h2>Upload PDF</h2>
  <div>
    <input type="number" id="owner"><br><br>
    <label for="category">Choose Category:</label>
    <select name="category" id="category" required>
        <option disabled selected>Choose one</option>
        <option value="Inhouse">Inhouse</option>
        <option value="Inhouse w/ Materials">Inhouse w/ Materials</option>
        <option value="Out Source">Out Source</option>
    </select><br><br>

    <label for="pic">Person In Charge:</label>
    <select name="pic" id="pic" required>
        <option disabled selected>Choose one</option>
        <option value="Jade">Jade</option>
        <option value="Martin">Martin</option>
        <option value="Tofer">Tofer</option>
    </select><br><br>

    <div id="content" class="d-none">
        <label for="message">Message: </label><br>
        <textarea name="message" id="message"></textarea><br><br>

        <input type="file" name="pdfFile" id="pdfFile" accept="application/pdf">
    </div><br>

    <button class="submit_btn">Submit</button>
    <button class="check">Check</button>
    
  </div>
  <!-- <form id="uploadForm" enctype="multipart/form-data">
    <input type="number" name="owner_num" id="owner_num" required>
    <input type="file" name="pdfFile" id="pdfFile" accept="application/pdf" required>
    <button type="submit">Upload</button>
  </form> -->

  <div id="result"></div>

  <script>
    $('#category').on('change', function () {
        var cat = $(this).val();

        if (cat === 'Inhouse') {
            $('#content').addClass('d-none');
            $('#message').val('');
            $('#pdfFile').val('');
        } else {
            $('#content').removeClass('d-none');
            // $('#message').prop('required', true);
            // $('#pdfFile').prop('required', true);

        }
    });
    
    $(document).on('click', '.submit_btn', function () {
        var cat = $('#category').val();
        var pic = $('#pic').val();
        var mess = $('#message').val().trim();
        var file_input = $('#pdfFile').prop('files').length;

        if (cat === null || pic === null) {
            alert('Select category or pic first !');
            return false;
        } else if (cat != 'Inhouse') {
            if (mess === '' || file_input === 0) {
                alert('fields are null!');
                return false;
            }
        }

        var formData = new FormData();
        formData.append('owner', $('#owner').val());
        formData.append('category', cat);
        formData.append('pic', pic);
        formData.append('message', mess);
        formData.append('the_file', $('#pdfFile')[0].files[0]);

        $.ajax({
            url: 'upload.php',
            type: 'POST',
            data: formData,
            processData: false, // important
            contentType: false, // important
            success: function(response) {
                $("#result").html(response);
            },
            error: function() {
                $("#result").html("Upload failed!");
            }
        });

    });

    $(document).on('click', '.check', function () {
        var mess = $('#message').val();
        if (mess === '') {
            mess = null; // convert to null
        }

        alert(mess);
    });

    // $("#uploadForm").on("submit", function(e) {
    //   e.preventDefault();

    //   var formData = new FormData(this);

    //   $.ajax({
    //     url: "upload.php",
    //     type: "POST",
    //     data: formData,
    //     processData: false,
    //     contentType: false,
    //     success: function(response) {
    //       $("#result").html(response);
    //     },
    //     error: function() {
    //       $("#result").html("Upload failed!");
    //     }
    //   });
    // });
  </script>
</body>
</html>


<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PDF Upload</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <h2>Upload PDF</h2>
  <form id="uploadForm" enctype="multipart/form-data">
    <input type="number" name="owner_num" id="owner_num" required>
    <input type="file" name="pdfFile" id="pdfFile" accept="application/pdf" required>
    <button type="submit">Upload</button>
  </form>

  <div id="result"></div>

  <script>
    $("#uploadForm").on("submit", function(e) {
      e.preventDefault();

      var formData = new FormData(this);

      $.ajax({
        url: "upload.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          $("#result").html(response);
        },
        error: function() {
          $("#result").html("Upload failed!");
        }
      });
    });
  </script>
</body>
</html> -->
