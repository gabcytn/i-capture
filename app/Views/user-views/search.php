<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search</title>
    <?php include "includes/bootstrap.php"; ?>
    <?php include "includes/ionicons.php"; ?>
    <?php include "includes/lobster-two.php"; ?>
    <link rel="stylesheet" href="<?= base_url("css/side-nav.css")?> " />

    <style>
        .container {
            max-width: 650px !important;
        }

        #search-image {
            width: 150px;
            height: 150px;
            border-radius: 100%;
        }
    </style>
</head>
<body>
    <?php include "includes/side-nav.php" ?>

    <div class="container">
        <div class="row">
            <?php if (sizeof($users) > 0): ?>
                <h2 class="text-center">Users</h2>
                <?php foreach ($users as $user): ?>
                    <div class="col-12 mt-3">
                        <a href="<?= base_url("/" . esc($user->id)) ?>" class="d-flex align-items-center">
                            <img id="search-image" src="<?= esc($user->profile_pic) ?>" alt="User profile pic"/>
                            <p class="ms-3" id="search-username">@<strong><?= esc($user->id) ?></strong></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h2 class="text-center">No users found</h2>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>