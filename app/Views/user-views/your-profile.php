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

        .follows-item {
            display: flex;
            align-items: center;
        }

        .follows-item a {
            width: max-content;
        }

        .follows-item img {
            width: 70px;
            height: 70px;
            border-radius: 100%;
            margin-right: .5rem;
        }

        .follows-item + .follows-item {
            margin-top: .5rem;
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
            <div class="col-8 before-errors">
                <div class="">
                    <div class="d-flex gap-3">
                        <p style="align-self: center; margin: 0; font-weight: 600;">@<?= esc($username) ?></p>
                        <button id="edit-password-btn" class="btn btn-secondary">Change password</button>
                    </div>
                    <div class="d-flex gap-5 mt-3">
                        <p><?= esc($post_count); ?> posts</p>
                        <form id="followers-form" action="<?= base_url("/followers") ?>">
                            <p id="followers-list" role="button"><?= esc($follower_count); ?> followers</p>
                        </form>
                        <form id="followings-form" action="<?= base_url("/followings") ?>">
                            <p id="followings-list" role="button"><?= esc($following_count); ?> following</p>
                        </form>
                    </div>
                </div>
            </div>
            <hr class="mt-3"/>
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
        <form id="form-password" action="<?= base_url("/change-password") ?>">
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

    <dialog id="followers-dialog">
    </dialog>

    <dialog id="followings-dialog">
    </dialog>
    <!--    Send data via fetch API-->
    <script>
        const formPassword = document.querySelector("#form-password");
        const formProfile = document.querySelector("#form-profile");

        const oldPasswordField = document.querySelector("#old-password");
        const newPasswordField = document.querySelector("#new-password");
        const profilePicField = document.querySelector("#profile");

        formPassword.addEventListener("submit", (event) => {
            event.preventDefault();
            const oldPasswordValue = oldPasswordField.value;
            const newPasswordValue = newPasswordField.value;

            console.log(formPassword.action)
            fetch(formPassword.action, {
                headers: {
                    "Content-Type": "application/json",
                },
                method: "PUT",
                body: JSON.stringify({
                    "old-password": oldPasswordValue,
                    "new-password": newPasswordValue
                }),
            })
                .then(res => res.json())
                .then(data => {
                    if (data.message === "ok") {
                        location.reload();
                    }
                    else {
                        const beforeErrors = document.querySelector(".before-errors");
                        const divErrors = document.createElement("div");
                        divErrors.classList.add("alert", "alert-danger", "mt-3");
                        const errorMessage = document.createElement("p");
                        errorMessage.textContent = data.message;
                        errorMessage.classList.add("text-center");
                        divErrors.appendChild(errorMessage);
                        beforeErrors.insertAdjacentElement("afterend", divErrors);
                    }
                })
                .catch(e => {
                    console.error(e);
                });
        });

    </script>

    <!--    Open and close dialogs-->
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

    <!--    Following and followers list-->
    <script>
        const followingForm = document.querySelector("#followings-form");
        const followerForm = document.querySelector("#followers-form");

        const followingListButton = document.querySelector("#followings-list");
        const followerListButton = document.querySelector("#followers-list");

        followingListButton.addEventListener("click", async () => {
            const followings = await fetchData(followingForm.action);
            populateFollowingsDialog(followings, "Following");
        });

        followerListButton.addEventListener("click", async () => {
            const followers = await fetchData(followerForm.action);
            populateFollowersDialog(followers, "Followers");
        });


        async function fetchData (url) {
            try {
                const res = await fetch(url);
                return await res.json();
            } catch (e) {
                console.error("Error fetching data: ");
                console.error(e);
            }
        }

        function populateFollowersDialog (items, title) {
            const followersDialog = document.querySelector("#followers-dialog");
            if (followersDialog.children.length > 0) {
                followersDialog.showModal();
                return;
            }

            const h3 = document.createElement("h3");
            h3.textContent = title;
            h3.classList.add("text-center");
            if (items.length < 1) {
                h3.textContent = "No one follows you"
                followersDialog.appendChild(h3);
                followersDialog.showModal();
                return;
            }
            followersDialog.appendChild(h3);

            items.forEach(data => {
                const div = document.createElement("div");
                const a = document.createElement("a");
                a.textContent = `@${data.id}`;
                a.href = data.href;
                const img = document.createElement("img");
                img.src = data.profile_pic;
                img.alt = "User profile";

                div.appendChild(img);
                div.appendChild(a);
                div.classList.add("follows-item");

                followersDialog.appendChild(div);
            });

            followersDialog.showModal();
        }


        function populateFollowingsDialog (items, title) {
            const followingsDialog = document.querySelector("#followings-dialog");
            if (followingsDialog.children.length > 0) {
                followingsDialog.showModal();
                return;
            }


            const h3 = document.createElement("h3");
            h3.textContent = title;
            h3.classList.add("text-center");
            if (items.length < 1) {
                h3.textContent = "You don't follow anyone";
                followingsDialog.appendChild(h3);
                followingsDialog.showModal();
                return;
            }
            followingsDialog.appendChild(h3);

            items.forEach(data => {
                const div = document.createElement("div");
                const a = document.createElement("a");
                a.textContent = `@${data.id}`;
                a.href = data.href;
                const img = document.createElement("img");
                img.src = data.profile_pic;
                img.alt = "User profile";

                div.appendChild(img);
                div.appendChild(a);
                div.classList.add("follows-item");

                followingsDialog.appendChild(div);
            });

            followingsDialog.showModal();
        }
    </script>
</body>
</html>