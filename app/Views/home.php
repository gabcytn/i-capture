<!DOCTYPE html>
<html lang="en">
<head>
    <title>iCapture</title>
    <?php include "includes/bootstrap.php"; ?>
    <?php include "includes/ionicons.php"; ?>
    <?php include "includes/lobster-two.php"; ?>
    <link rel="stylesheet" href="<?= base_url("css/side-nav.css")?> " />
    <style>
        .container {
            max-width: 650px !important;
        }

        .row .col-6 a:hover {
            background-color: #eee;
        }

        .active-tab {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <?php include "includes/side-nav.php"; ?>

    <div class="container">
        <div class="row gx-1">
            <?php if ($tab == "foryou"): ?>
                <div class="active-tab col-6" id="for-you" role="button">
                    <a href="" class="d-flex justify-content-center align-items-center">
                        <p class="m-0 py-2 text-center fs-5">For you</p>
                    </a>
                </div>

                <div class="col-6" id="following" role="button">
                    <a href="<?= base_url("?tab=following") ?>" class="d-flex justify-content-center align-items-center">
                        <p class="m-0 py-2 text-center fs-5">Following</p>
                    </a>
                </div>
            <?php elseif ($tab == "following"): ?>
                <div class="col-6" id="for-you" role="button">
                    <a href="?tab=foryou" class="d-flex justify-content-center align-items-center">
                        <p class="m-0 py-2 text-center fs-5">For you</p>
                    </a>
                </div>

                <div class="active-tab col-6 " id="following" role="button">
                    <a href="" class="d-flex justify-content-center align-items-center">
                        <p class="m-0 py-2 text-center fs-5">Following</p>
                    </a>
                </div>
            <?php endif ?>
        </div>
    </div>
</body>
</html>