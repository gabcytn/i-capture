<!DOCTYPE html>
<html lang="en">
<head>
    <title>Instaclone</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <?php include "includes/bootstrap.php"; ?>

    <style>
        p {
            margin: 0;
        }
        h1{
            font-family: "Lobster Two", sans-serif;
            text-align: center;
        }
        .container {
            max-width: 750px !important;
            margin-top: 2rem;
        }
        form {
            height: 400px;
            border: 1px solid #CCC;
            margin-top: 2.5rem;
            padding: 2rem 1.5rem;
        }
        .no-account {
            border: 1px solid #CCC;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <img src="<?= base_url("images/insta-login.png"); ?>" alt="Login Image"/>
            </div>
            <div class="col-6">
                <?= helper("form") ?>
                <?= validation_list_errors() ?>
                <form action="<?= base_url("/register") ?>" method="POST">
                    <h1 class="mb-5">Instaclone</h1>
                    <input class="mt-5 form-control" name="username" type="text" id="username-input" required placeholder="Username"/>
                    <input class="mt-3 form-control" name="password" type="password" id="password-input" required placeholder="Password"/>

                    <button type="submit" class="w-100 mt-5 btn btn-primary">Sign up</button>
                </form>
                <div class="no-account d-flex justify-content-center align-items-center p-3 mt-3">
                    <p>Already have an account? <a href="<?= base_url("/login"); ?>">Login</a> </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
