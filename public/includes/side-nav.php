<div class="side-nav">
    <h1>iCapture</h1>
    <ul class="side-nav-list">
        <li class="side-nav-item"><ion-icon name="home"></ion-icon><a href="<?= base_url("/") ?>" class="side-nav-link">Home</a></li>
        <li id="search-dialog-button" class="side-nav-item"><ion-icon name="search-outline"></ion-icon><a class="side-nav-link">Search</a></li>
        <li id="create-post-button" class="side-nav-item"><ion-icon name="add-circle-outline"></ion-icon><a class="side-nav-link">Create</a></li>
        <li class="side-nav-item"><img src="<?= base_url(session()->get("profile")); ?>" alt="Profile Picture" id="side-nav-profile"><a href="<?= base_url(session()->get("username")) ?>" class="side-nav-link">Profile</a></li>
    </ul>

    <a href="<?= base_url("/logout") ?>" style="width:max-content; position: absolute; left: 2rem; bottom: 1.5rem" class="btn btn-danger">Logout</a>
</div>

<dialog id="create-post-dialog">
    <form id="create-post-form" action="<?= base_url("/post") ?>" method="post" enctype="multipart/form-data">
        <h3 class="text-center mb-3">Create Post</h3>
        <input id="post-image" class="form-control" name="image" type="file"/>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Post</button>
            <button id="close-dialog-button" type="button" class="btn btn-danger">Close</button>
        </div>
    </form>
</dialog>

<dialog  id="search-user-dialog">
    <form id="search-user-form" method="get" action="<?= base_url("/search") ?>">
        <h3 class="text-center mb-3">Search User</h3>
        <input type="text" id="username" name="username" placeholder="Username" class="form-control" />

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Search</button>
            <button id="close-search-button" type="button" class="btn btn-danger">Close</button>
        </div>
    </form>
</dialog>

<script>
    const searchForm = document.querySelector("#search-user-form");
    const searchDialog = document.querySelector("#search-user-dialog");
    const closeSearchDialogButton = document.querySelector("#close-search-button");

    const openSearchDialogButton = document.querySelector("#search-dialog-button");

    openSearchDialogButton.addEventListener("click", () => {
        searchDialog.showModal();
    });

    closeSearchDialogButton.addEventListener("click", () => {
        searchDialog.close();
    });
</script>

<script>
    const createPostButton = document.querySelector("#create-post-button");
    const createPostDialog = document.querySelector("#create-post-dialog");
    const createPostForm = document.querySelector("#create-post-form");

    createPostButton.addEventListener("click", () => {
        createPostDialog.showModal();
    });

    document.querySelector("#close-dialog-button").addEventListener("click", () => {
       createPostDialog.close();
    });
</script>