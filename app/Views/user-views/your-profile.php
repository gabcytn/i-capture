<!DOCTYPE html>
<html lang="en">
<head>
    <title>@<?= session()->get("username") ?></title>
    <?php include "includes/bootstrap.php"; ?>
    <?php include "includes/ionicons.php"; ?>
    <?php include "includes/lobster-two.php"; ?>
    <link rel="stylesheet" href="<?= base_url("css/side-nav.css")?> " />

    <style>
        .container {
            max-width: 650px !important;
        }
        .col-4 img {
            width: 10rem;
            height: 10rem;
            border-radius: 100%;
        }
        dialog::backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        dialog {
            width: 25%;
            height: 25vh;
            border: none;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <?php include "includes/side-nav.php" ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-4">
                <div id="edit-picture-btn" style="cursor:pointer;">
                    <img src="<?= base_url(session()->get("profile")); ?>" alt="Profile Picture"/>
                </div>
            </div>
            <div class="col-8">
                <div class="">
                    <div class="d-flex gap-3">
                        <p style="align-self: center; margin: 0; font-weight: 600;">@<?= esc($username) ?></p>
                        <button id="edit-username-btn" class="btn btn-secondary">Change username</button>
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

    <dialog id="edit-username-dialog">
        <h4 class="text-center">Edit Username</h4>
        <?= helper("form"); ?>
        <?= validation_list_errors(); ?>
        <form action="<?= base_url("/change-username") ?>" method="post" enctype="multipart/form-data">
            <label for="username" class="form-label">Username</label>
            <input value="<?= session()->get("username")?>" type="text" name="username" id="username" class="form-control"/>

            <div class="mt-3"></div>
            <button type="submit" class="btn btn-warning">Update</button>
            <button type="button" class="close-dialog-btn btn btn-danger">Close</button>
        </form>
    </dialog>
    <dialog id="edit-picture-dialog">
        <h4 class="text-center">Edit Profile</h4>
        <form action="<?= base_url("/change-picture") ?>" method="post" enctype="multipart/form-data">
            <label for="profile" class="form-label">Profile Picture</label>
            <input type="file" name="profile" id="profile" class="form-control"/>

            <div class="mt-3"></div>
            <button type="submit" class="btn btn-warning">Update</button>
            <button type="button" class="close-dialog-btn btn btn-danger">Close</button>
        </form>
    </dialog>

    <script>
        const editUsernameButton = document.querySelector("#edit-username-btn");
        const editPictureButton = document.querySelector("#edit-picture-btn");

        const editPictureDialog= document.querySelector("#edit-picture-dialog");
        const editUsernameDialog = document.querySelector("#edit-username-dialog");

        const closeDialogButton = document.querySelectorAll(".close-dialog-btn");

        editPictureButton.addEventListener("click", () => {
            editPictureDialog.showModal();
        });

        editUsernameButton.addEventListener("click", () => {
            editUsernameDialog.showModal();
        });

        closeDialogButton.forEach(i => {
            i.addEventListener("click", () => {
                editPictureDialog.close();
                editUsernameDialog.close();
            })
        });
    </script>
</body>
</html>