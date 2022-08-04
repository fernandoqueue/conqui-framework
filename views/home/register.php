
    <?php if(Conqui\Session::get('error')): ?>
        <h1 style="color:white;background-color:red"><?= Conqui\Session::get('error') ?></h1>
    <?php endif; ?>
    <form action="/conqui/public/register" method="post">
        <label for="">First Name:</label>        
        <input type="text" name="first_name" id="">
        <label for="">Last Name:</label>        
        <input type="text" name="last_name" id="">
        <label for="">Email:</label>        
        <input type="text" name="email" id="">
        <label for="">Password:</label>        
        <input type="text" name="password" id="">
        <button type="submit">Submit</button>
    </form>
