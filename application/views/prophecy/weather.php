<?php
$time = sprintf("%02d", $this->uri->segment(3));
$date = date('Y-m-d '.$time.':00:00');
?>
<!-- <!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

        <title>weather!</title>
    </head>
    <body>
        <h1>Hello, world!</h1>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    </body>
</html> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

<script>
    const settings = {
        "async": true,
        "crossDomain": true,
        "url": 'https://api.ambeedata.com/weather/history/by-lat-lng?lat=13.75&lng=100.52&from='+<?=date('Y-m-d')?>+'%2012%3A16%3A44&to='+<?=date('Y-m-d')?>+'%2012%3A16%3A44',
        "method": "GET",
        "headers": {
            "x-api-key": "0zxop0oeBA9uHcqbqYrP67yHISuqerk275WlbL6B",
            "Content-type": "application/json"
        }
    };
    $.ajax(settings).done(function (response) {
        console.log(response);
    });
</script>