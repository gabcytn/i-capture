<div class="side-nav">
    <h1>iCapture</h1>
    <ul class="side-nav-list">
        <li class="side-nav-item"><ion-icon name="home"></ion-icon><a href="<?= base_url("/") ?>" class="side-nav-link">Home</a></li>
        <li class="side-nav-item"><ion-icon name="search-outline"></ion-icon><a href="#" class="side-nav-link">Search</a></li>
        <li id="create-post-button" class="side-nav-item"><ion-icon name="add-circle-outline"></ion-icon><a href="#" class="side-nav-link">Create</a></li>
        <li class="side-nav-item"><img src="<?= base_url(session()->get("profile")); ?>" alt="Profile Picture" id="side-nav-profile"><a href="<?= base_url(session()->get("username")) ?>" class="side-nav-link">Profile</a></li>
    </ul>
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