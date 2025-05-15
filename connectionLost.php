<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection Lost</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @-webkit-keyframes slide-in-bck-center {
            0% {
                -webkit-transform: translateZ(600px);
                transform: translateZ(600px);
                opacity: 0;
            }

            100% {
                -webkit-transform: translateZ(0);
                transform: translateZ(0);
                opacity: 1;
            }
        }

        @keyframes slide-in-bck-center {
            0% {
                -webkit-transform: translateZ(600px);
                transform: translateZ(600px);
                opacity: 0;
            }

            100% {
                -webkit-transform: translateZ(0);
                transform: translateZ(0);
                opacity: 1;
            }

            body {
                -webkit-animation: slide-in-bck-center 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
                animation: slide-in-bck-center 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body text-center">
                <h1 class="text-danger">Connection Lost</h1>
                <p class="lead">We are unable to connect to the server at the moment. Please check your internet connection and try again.</p>
                <p>If the problem persists, please contact support.</p>
                <a href="index.php" class="btn btn-primary mt-3">Return to Main Page</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>