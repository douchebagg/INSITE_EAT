<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="494536549078-t2j0ki7i1bjmf5q2a13l5fjilojhifk5.apps.googleusercontent.com">
    <title>Login</title>
    <link rel="icon" href="https://ec2-13-250-12-231.ap-southeast-1.compute.amazonaws.com/images/dinner.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url('js/login.css') ?>">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        function signin(token, name) {
            $.post('<?= base_url() ?>', {
                token: token,
                name: name
            });
        }

        // google signin
        function googleSignIn(googleUser) {
            let profile = googleUser.getBasicProfile();
            signin(
                profile.getId(),
                profile.getName()
            );
            googleSignOut();
            window.location.href = "<?= base_url('home') ?>";
            // console.log("ID: " + profile.getId());
            // console.log('Full Name: ' + profile.getName());
            // console.log('Given Name: ' + profile.getGivenName());
            // console.log('Family Name: ' + profile.getFamilyName());
            // console.log("Image URL: " + profile.getImageUrl());
            // console.log("Email: " + profile.getEmail());
            // var id_token = googleUser.getAuthResponse().id_token;
            // console.log("ID Token: " + id_token);
        };

        function googleSignOut() {
            var auth2 = gapi.auth2.getAuthInstance();
            auth2.signOut();
        }

        function facebookSignIn() {
            FB.api('/me', function (response) {
                console.dir(response);
                signin(
                    response.id,
                    response.name
                );
                FB.api('/' + response.id + '/permissions', 'delete');
                window.location.href = "<?= base_url('home') ?>";
            });
        }

        window.fbAsyncInit = function () {
            FB.init({
                appId: '615044028839963',
                cookie: false,
                xfbml: true,
                version: 'v2.8'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=615044028839963&autoLogAppEvents=1";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
</head>

<body>
    <div class="container" style="padding-top: 50px">
        <div class="container">
            <div class="card"></div>
            <div class="card">
                <h1 class="title">Login</h1>
                <form action="<?= base_url('login') ?>" method="POST">
                    <div class="input-container">
                        <input type="text" name="USERNAME" required="required" />
                        <label for="Username">Username</label>
                        <div class="bar"></div>
                    </div>
                    <div class="input-container">
                        <input type="password" name="PASSWORD" required="required" />
                        <label for="Password">Password</label>
                        <div class="bar"></div>
                    </div>
                    <div class="button-container">
                        <button>
                            <span>Sign In</span>
                        </button>
                    </div>
                </form>
            </div>
            <a class="card alt" href="<?= base_url('register') ?>">
                <div class="register"></div>
            </a>
        </div>
        <div class="container">
            <div class="card"></div>
            <div class="card">
                <div class="button-container">
                    <span class="g-signin2" data-width="360" data-height="60" data-longtitle="true" data-onsuccess="googleSignIn"></span>
                </div>
                <br>
                <div class="button-container">
                    <span class="fb-login-button" data-width="360" data-size="large" data-button-type="login_with" data-scope="public_profile, email" onlogin="facebookSignIn"></span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>