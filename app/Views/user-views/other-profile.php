<!DOCTYPE html>
<html lang="en">
<head>
    <title>@<?= session()->get("username") ?></title>
    <?php include "includes/bootstrap.php" ?>
    <?php include "includes/lobster-two.php" ?>
    <?php include "includes/ionicons.php"; ?>
    <link rel="stylesheet" href="<?= base_url("css/side-nav.css"); ?> " />

    <style>
        .container {
            max-width: 650px !important;
        }
        .col-4 img {
            width: 10rem;
            height: 10rem;
            border-radius: 100%;
        }
    </style>
</head>
<body>
<?php include "includes/side-nav.php" ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-4">
            <img src="<?= esc($profile_pic) ?>" alt="Profile Picture"/>
        </div>
        <div class="col-8">
            <div class="">
                <div class="d-flex gap-3">
                    <p style="align-self: center; margin: 0; font-weight: 600;">@<?= esc($username) ?></p>
                    <?php if ($is_following): ?>
                        <form method="post" action="<?= base_url(esc($username) . "/unfollow") ?>">
                            <button type="submit" class="btn btn-secondary">Unfollow</button>
                        </form>
                    <?php else: ?>
                        <form method="post" action="<?= base_url(esc($username) . "/follow") ?>">
                            <button type="submit" class="btn btn-primary">Follow</button>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="d-flex gap-5 mt-3">
                    <p><?= esc($post_count); ?> posts</p>
                    <p><?= esc($follower_count); ?> followers</p>
                    <p><?= esc($following_count); ?> following</p>
                </div>
            </div>
        </div>
        <hr class="mt-4"/>
    </div>

    <div class="row">
        <?php if (sizeof($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <div class="col-6">
                    <a href="<?=base_url("/posts/" . $post->id) ?>">
                        <img style="width: 100%; height: 300px" src="<?= esc($post->photo_url); ?>" alt="Post image" />
                        <p>Likes: <?= esc($post->likes); ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h2 class="text-center">No Posts Yet</h2>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
