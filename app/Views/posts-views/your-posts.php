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
        }
    </style>
</head>
<body>
    <?php include "includes/side-nav.php" ?>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex my-3 align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="<?= base_url(esc($postOwnerProfile)); ?>" id="post-owner-profile" alt="Post owner profile picture" />
                    <a href="<?= base_url(esc($post["post_owner"])) ?>" style="width: max-content;" class="ms-3">@<strong><?= esc($post["post_owner"]); ?></strong></a>
                </div>
                <div>
                    <button id="delete-post" href="<?= base_url("/posts" . $post["id"] . "/delete"); ?>" class="btn btn-danger">Delete</button>
                </div>
            </div>
            <img src="<?= esc($post["photo_url"]); ?>" alt="Post Image" />
            <div class="col-12 d-flex align-items-center mt-3">
                <?php if (esc($isLikedByThisUser)): ?>
                    <form id="unlike-form" method="post" action="<?= base_url("/posts/" . $post["id"] . "/unlike") ?>" class="w-100 d-flex">
                        <button id="unlike-button" type="submit" class="w-25 btn btn-secondary">Unlike</button>
                        <p id="like-count" class="m-0 fs-5 ms-3"><?= esc($post["likes"]); ?></p>
                    </form>
                    <form id="like-form" action="<?= base_url("/posts/" . $post["id"] . "/like"); ?>"></form>
                    <script src="<?= base_url("javascript/post-liked.js") ?>"></script>
                <?php else: ?>
                    <form id="like-form" method="post" action="<?= base_url("/posts/" . $post["id"] . "/like"); ?>" class="w-100 d-flex">
                        <button id="like-button" type="submit" class="w-25 btn btn-primary">Like</button>
                        <p id="like-count" class="m-0 fs-5 ms-3"><?= esc($post["likes"]); ?></p>
                    </form>
                    <form id="unlike-form" action="<?= base_url("/posts/" . $post["id"] . "/unlike"); ?>"></form>
                    <script src="<?= base_url("javascript/post-notliked.js") ?>"></script>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
        const deleteButton = document.querySelector("#delete-post");

        deleteButton.addEventListener("click", () => {
        const currentLocation = window.location.href;

        fetch(`${currentLocation}/delete`, {
                method: "DELETE"
        })
                .then(res => res.json())
                .then(data => {
                        location.href = data.redirect;
                });
        });
    </script>
</body>
</html>
