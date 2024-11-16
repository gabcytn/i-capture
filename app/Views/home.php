<!DOCTYPE html>
<html lang="en">
<head>
    <title>Instaclone</title>
    <?php include "app/Views/includes/bootstrap.php"; ?>
    <?php include "app/Views/includes/ionicons.php"; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <style>
        .side-nav {
            border-right: 1px solid #CCC;
            position: fixed;
            left: 0;
            top: 0;
            width: 240px;
            height: 100vh;
        }
        .side-nav h1 {
            font-family: "Lobster Two", sans-serif;
            font-size: 1.75rem;
            padding-top: 2rem;
            margin-left: 1.5rem;
        }
        .side-nav-list {
            list-style-type: none;
        }
    </style>
</head>
<body>
    <?php include "app/Views/includes/side-nav.php"; ?>
</body>
</html>