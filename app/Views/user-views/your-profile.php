<!DOCTYPE html>
<?= helper("form"); ?>
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

        #edit-password-dialog {
            width: 30%;
            height: 32.5vh;
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
                        <button id="edit-password-btn" class="btn btn-secondary">Change password</button>
                    </div>
                    <div class="d-flex gap-5 mt-3">
                        <p><?= esc($post_count); ?> posts</p>
                        <p><?= esc($follower_count); ?> followers</p>
                        <p><?= esc($following_count); ?> following</p>
                    </div>
                </div>
            </div>
            <?= validation_list_errors(); ?>
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

    <dialog id="edit-password-dialog">
        <h4 class="text-center">Change Password</h4>
        <form action="<?= base_url("/change-password") ?>" method="post" enctype="multipart/form-data">
            <label for="old-password" class="form-label">Old Password</label>
            <input type="password" name="old-password" id="old-password" class="form-control"/>

            <label for="new-password" class="form-label">New Password</label>
            <input type="password" name="new-password" id="new-password" class="form-control"/>

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
        const editPasswordButton = document.querySelector("#edit-password-btn");
        const editPictureButton = document.querySelector("#edit-picture-btn");

        const editPictureDialog= document.querySelector("#edit-picture-dialog");
        const editPasswordDialog = document.querySelector("#edit-password-dialog");

        const closeDialogButton = document.querySelectorAll(".close-dialog-btn");

        editPictureButton.addEventListener("click", () => {
            editPictureDialog.showModal();
        });

        editPasswordButton.addEventListener("click", () => {
            editPasswordDialog.showModal();
        });

        closeDialogButton.forEach(i => {
            i.addEventListener("click", () => {
                editPictureDialog.close();
                editPasswordDialog.close();
            })
        });

        document.querySelector(".errors").classList.add("text-danger", "mt-3")
    </script>
</body>
</html>