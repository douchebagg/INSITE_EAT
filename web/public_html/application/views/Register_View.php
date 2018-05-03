<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="<?= base_url('js/login.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container" style="padding-top: 80px">
        <div class="row">
            <div class="container">
                <div class="card"></div>
                <div class="card">
                    <h1 class="title">Register</h1>
                    <form>
                        <div class="input-container">
                            <input type="text" id="Username" required="required" />
                            <label for="Username">Username</label>
                            <div class="bar"></div>
                        </div>
                        <div class="input-container">
                            <input type="password" id="Password" required="required" />
                            <label for="Password">Password</label>
                            <div class="bar"></div>
                        </div>
                        <div class="input-container">
                            <input type="password" id="Repeat Password" required="required" />
                            <label for="Repeat Password">Repeat Password</label>
                            <div class="bar"></div>
                        </div>
                        <div class="button-container">
                            <button>
                                <span>Next</span>
                            </button>
                        </div>
                    </form>
                </div>
                <a class="card alt" href="<?= base_url('login') ?>">
                    <div class="login"></div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>