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

        #post-owner-profile {
            width: 3rem;
            height: 3rem;
            border-radius: 100%;
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

        <div class="row">
            <?php foreach ($posts as $post): ?>
                <div class="col-12 d-flex my-3 align-items-center">
                    <img src="<?= base_url(esc($post->profile_pic)); ?>" id="post-owner-profile" alt="Post owner profile picture" />
                    <a href="<?= base_url(esc($post->username)) ?>" style="width: max-content;" class="ms-3">@<strong><?= esc($post->username); ?></strong></a>
                </div>
                <img src="<?= esc($post->photo_url); ?>" alt="Post Image" />
                <div class="col-12 d-flex align-items-center mt-3 marker">
                    <form method="post" action="<?= base_url("/posts/" . $post->post_id . "/like"); ?>" class="w-100 d-flex">
                        <button type="submit" class="w-25 btn btn-primary">Like</button>
                        <p id="like-count" class="m-0 fs-5 ms-3"><?= esc($post->likes); ?></p>
                    </form>
                </div>
            <?php endforeach; ?>
            <button class="my-4 py-3 btn btn-warning">LOAD MORE</button>
        </div>
    </div>
</body>
</html>