<!DOCTYPE html>
<html lang="en">
<head>
    <title>iCapture</title>
    <?php include "includes/bootstrap.php" ?>
    <?php include "includes/lobster-two.php" ?>
    <?php include "includes/ionicons.php"; ?>
    <link rel="stylesheet" href="<?= base_url("css/side-nav.css"); ?> " />

    <style>
        .container {
            max-width: 650px !important;
        }
        #post-owner-profile {
            width: 3rem;
            height: 3rem;
            border-radius: 100%;
        }    </style>
</head>
<body>
    <?php include "includes/side-nav.php" ?>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex my-3 align-items-center">
                <img src="<?= base_url(esc($postOwnerProfile)); ?>" id="post-owner-profile" alt="Post owner profile picture" />
                <a href="<?= base_url(esc($post["post_owner"])) ?>" style="width: max-content;" class="ms-3">@<strong><?= esc($post["post_owner"]); ?></strong></a>
            </div>
            <img src="<?= esc($post["photo_url"]); ?>" alt="Post Image" />
            <div class="col-12 d-flex align-items-center mt-3">
                <?php if (esc($isLikedByThisUser)): ?>
                    <form method="post" action="<?= base_url("/posts/" . $post["id"] . "/unlike") ?>" class="w-100 d-flex">
                        <button type="submit" class="w-25 btn btn-secondary">Unlike</button>
                        <p id="like-count" class="m-0 fs-5 ms-3"><?= esc($post["likes"]); ?></p>
                    </form>
                <?php else: ?>
                    <form method="post" action="<?= base_url("/posts/" . $post["id"] . "/like"); ?>" class="w-100 d-flex">
                        <button type="submit" class="w-25 btn btn-primary">Like</button>
                        <p id="like-count" class="m-0 fs-5 ms-3"><?= esc($post["likes"]); ?></p>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>