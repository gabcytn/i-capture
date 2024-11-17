<div class="side-nav">
    <h1>iCapture</h1>
    <ul class="side-nav-list">
        <li class="side-nav-item"><ion-icon name="home"></ion-icon><a href="<?= base_url("/") ?>" class="side-nav-link">Home</a></li>
        <li class="side-nav-item"><ion-icon name="search-outline"></ion-icon><a href="#" class="side-nav-link">Search</a></li>
        <li class="side-nav-item"><ion-icon name="add-circle-outline"></ion-icon><a href="#" class="side-nav-link">Create</a></li>
        <li class="side-nav-item"><img src="<?= base_url(session()->get("profile")); ?>" alt="Profile Picture" id="side-nav-profile"><a href="<?= base_url(session()->get("username")) ?>" class="side-nav-link">Profile</a></li>
    </ul>
</div>