<!DOCTYPE html>
<html lang="en">
<head>
    <title>@<?= session()->get("username") ?></title>
    <?php include "app/Views/includes/bootstrap.php" ?>
    <?php include "app/Views/includes/lobster-two.php" ?>
    <?php include "app/Views/includes/ionicons.php"; ?>
    <link rel="stylesheet" href="<?= base_url("assets/css/side-nav.css"); ?> " />

    <style>
        .container {
            max-width: 650px !important;
        }
        .col-4 img {
            width: 10rem;
            border-radius: 100%;
        }
    </style>
</head>
<body>
    <?php include "app/Views/includes/side-nav.php" ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-4">
                <img src="<?= base_url("assets/default-profile.jpg"); ?>" alt="Profile Picture"/>
            </div>
            <div class="col-8">
                <div class="">
                    <div class="d-flex gap-3">
                        <p style="align-self: center; margin: 0; font-weight: 600;">@<?= esc($username) ?></p>
                        <button class="btn btn-secondary">Edit Profile</button>
                    </div>
                    <div class="d-flex gap-5 mt-3">
                        <p>0 posts</p>
                        <p>100 followers</p>
                        <p>66 following</p>
                    </div>
                </div>
            </div>
            <hr class="mt-4"/>
        </div>

        <div class="row">
            <?php if (sizeof($posts) > 0): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-6">
                        <a href="#">
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