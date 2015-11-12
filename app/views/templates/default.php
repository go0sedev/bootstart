<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Gustav Trenwith">
    <title>Swordfish Issue Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{url}}images/favicon.ico">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/lumen/bootstrap.min.css">
    <link rel="stylesheet" href="{{url}}css/styles.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 page-header">
                <h1>Github Issue Tracker</h1>
                <p class="col-md-8 col-sm-6 col-xs-12 lead pull-left">This is a basic issue tracker built for Swordfish by Gustav Trenwith.</p>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    {{navigation}}
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        {{content}}
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>