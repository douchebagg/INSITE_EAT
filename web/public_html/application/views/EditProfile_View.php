<?php
    $session = $this->session->userdata('user_data');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="icon" href="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/dinner.png">
    <link rel="stylesheet" href="<?= base_url('js/profile.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container" style="padding-top: 80px">
        <div class="row">
            <div class="container">
                <div class="card"></div>
                <div class="card">
                    <h1 class="title">Edit Profile</h1>
                    <form method="post" action="<?php echo base_url('Profile/edit'); ?>">
                        <div class="input-container">
                            <input type="text" name="USERNAME" required="required" disabled value="<?= $session['username'] ?>" />
                            <label for="Username">Username</label>
                            <div class="bar"></div>
                        </div>
                        <div class="input-container">
                            <input type="text" name="DISPLAY_NAME" required="required" value="<?= $session['name'] ?>" />
                            <label for="Username">Displayname</label>
                            <div class="bar"></div>
                        </div>
                        <div class="button-container">
                            <button>
                                <span >Next</span>
                            </button>
                        </div>
                    </form>
                </div>
                <a class="card alt" href="<?= base_url('home') ?>">
                    <div class="home"></div>
                </a>
            </div>
        </div>
        <?php if(isset($status) && $status === 1) { ?>
        <div class="alert alert-success fade in">
            Register is <strong>successfully</strong>, return to <a href="<?= base_url('Login') ?>" class="alert-link">login</a> page.
        </div>
        <?php } ?>
    </div>
</body>
</html>