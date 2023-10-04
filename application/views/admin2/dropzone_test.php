<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dropzone_test</title>
</head>
<body>
    <form action="/file-upload" class="dropzone">
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
    </form>

    <script src="<?=base_url('assets/admin2')?>assets/js/dropzone5.7/dropzone.js"></script>
    
</body>
</html>