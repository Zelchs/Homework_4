<?php
include "src/header.php";
?>
<main>
<h1>Signup</h1>
<form action="src/signup.php" method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="email" name="email" placeholder="E-mail">
    <input type="password" name="pwd" placeholder="Password">
    <button type="submit" name="signup-submit">Signup</button>
</form>
</main>

<?php
include "src/footer.php";
?>