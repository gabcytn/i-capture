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
        dialog::backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        dialog {
            width: 50%;
            height: 50vh;
            border: none;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.3);
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
                        <button id="edit-profile-btn" class="btn btn-secondary">Edit Profile</button>
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

    <dialog id="edit-profile-dialog">
        <h2 class="text-center">Edit Profile</h2>
        <form action="<?= base_url("/edit-profile") ?>" method="post" enctype="multipart/form-data">
            <label for="profile-pic-input" class="form-label">Profile Photo</label>
            <input id="profile-pic-input" name="profile-pic" type="file" class="form-control" />

            <label for="username" class="form-label">Username</label>
            <input value="<?= session()->get("username"); ?>" id="username" name="username" type="text" class="form-control" />

            <label for="password" class="form-label">Password</label>
            <input id="password" name="password" class="form-control" type="password" />

            <div class="mt-3"></div>
            <button type="submit" class="btn btn-warning">Update</button>
            <button id="close-dialog-btn" type="button" class="btn btn-danger">Close</button>
        </form>
    </dialog>

    <script>
        const editProfileButton = document.querySelector("#edit-profile-btn");
        const editProfileDialog = document.querySelector("#edit-profile-dialog");
        const closeDialogButton = document.querySelector("#close-dialog-btn");

        editProfileButton.addEventListener("click", () => {
            editProfileDialog.showModal();
        });

        closeDialogButton.addEventListener("click", () => {
            editProfileDialog.close();
        })
    </script>
</body>
</html>