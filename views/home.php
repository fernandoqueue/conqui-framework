<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="/conqui/public/register"><button>Register</button></a>
    <a href="/conqui/public/login"><button>Login</button></a>
    <?php if(Conqui\Authentication::isLoggedIn()): ?>
    <form id="logoutform" action="<?= Conqui\URL::route('logout') ?>" method="post">
        <input type="hidden" name="token" value="<?=Conqui\CSRF::get()?>">
    </form>
    <button onclick="document.getElementById('logoutform').submit()">Logout</button>
    <?php endif; ?>
    <?php if(Conqui\Session::get('success')): ?>
        <h1 style="color:white;background-color:green"><?= Conqui\Session::get('success') ?></h1>
    <?php endif; ?>
    <h5><?php print_r($_SESSION) ?> </h5>
</body>
</html>