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

        .row .col-4 a:hover {
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
        img {
            max-width: 100%;
        }
    </style>
</head>
<body>
    <?php include "includes/side-nav.php"; ?>

    <div class="container">
        <div class="row gx-1">
            <?php if ($tab == "foryou"): ?>
                <div class="active-tab col-4" id="for-you" role="button">
                    <a href="" class="d-flex justify-content-center align-items-center">
                        <p class="m-0 py-2 text-center fs-5">For you</p>
                    </a>
                </div>
                <div class="col-4" id="following" role="button">
                    <a href="<?= base_url("?tab=following") ?>" class="d-flex justify-content-center align-items-center">
                        <p class="m-0 py-2 text-center fs-5">Following</p>
                    </a>
                </div>
                <div class="col-4 " id="following" role="button">
                    <a href="?tab=likes" class="d-flex justify-content-center align-items-center">
                        <p class="m-0 py-2 text-center fs-5">Likes</p>
                    </a>
                </div>
            <?php elseif ($tab == "following"): ?>
                <div class="col-4" id="for-you" role="button">
                    <a href="?tab=foryou" class="d-flex justify-content-center align-items-center">
                        <p class="m-0 py-2 text-center fs-5">For you</p>
                    </a>
                </div>
                <div class="active-tab col-4 " id="following" role="button">
                    <a href="" class="d-flex justify-content-center align-items-center">
                        <p class="m-0 py-2 text-center fs-5">Following</p>
                    </a>
                </div>
                <div class="col-4 " id="following" role="button">
                    <a href="?tab=likes" class="d-flex justify-content-center align-items-center">
                        <p class="m-0 py-2 text-center fs-5">Likes</p>
                    </a>
                </div>
            <?php elseif ($tab == "likes"): ?>
                <div class="col-4" id="for-you" role="button">
                    <a href="?tab=foryou" class="d-flex justify-content-center align-items-center">
                        <p class="m-0 py-2 text-center fs-5">For you</p>
                    </a>
                </div>
                <div class="col-4 " id="following" role="button">
                    <a href="?tab=following" class="d-flex justify-content-center align-items-center">
                        <p class="m-0 py-2 text-center fs-5">Following</p>
                    </a>
                </div>
                <div class="active-tab col-4 " id="following" role="button">
                    <a href="" class="d-flex justify-content-center align-items-center">
                        <p class="m-0 py-2 text-center fs-5">Likes</p>
                    </a>
                </div>
            <?php endif ?>
        </div>

        <!-- ALL POSTS ARE DISPLAYED BELOW -->

        <div class="row">
            <?php if (sizeof($posts) > 0): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post col-12">
                        <div class="d-flex my-3 align-items-center">
                            <img src="<?= base_url(esc($post->profile_pic)); ?>" id="post-owner-profile" alt="Post owner profile picture" />
                            <a href="<?= base_url(esc($post->post_owner)) ?>" style="width: max-content;" class="ms-3">@<strong><?= esc($post->post_owner); ?></strong></a>
                        </div>
                        <img src="<?= esc($post->photo_url); ?>" alt="Post Image" />
                        <div class="mt-3 d-flex align-items-center justify-content-start">
                            <form action="<?= base_url("/posts/" . $post->post_id . "/like"); ?>" class="like-form"></form>
                            <form action="<?= base_url("/posts/" . $post->post_id . "/unlike"); ?>" class="unlike-form"></form>
                            <button type="submit" class="like-button w-25 btn btn-primary">Like</button>
                            <p class="like-count m-0 fs-5 ms-3"><?= esc($post->likes); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <button class="my-4 py-3 btn btn-warning">LOAD MORE</button>
                <script src="<?= base_url("javascript/home.js"); ?>"></script>
            <?php else: ?>
                <h3 class="text-center mt-3">No posts available</h3>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
