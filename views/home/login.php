    
    <?php if(Conqui\Session::get('error')): ?>
        <h1 style="color:white;background-color:red"><?= Conqui\Session::get('error') ?></h1>
    <?php endif; ?>

    <?php print_r(session_id()) ?>
    <h1>ok</h1>
    <?php print_r(\Conqui\CSRF::get()) ?>
    <h1>ok</h1>
    <?php print_r(session_name()) ?>
    <form action="/conqui/public/login" method="post">
        <input type="hidden" name="token" value="<?=\Conqui\CSRF::get()?>">
        <label for="">Email:</label>        
        <input type="text" name="email" id="">
        <label for="">Password:</label>        
        <input type="text" name="password" id="">
        <button type="submit">Submit</button>
    </form>

