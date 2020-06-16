<?php
include "src/templates/header.php";
?>
<main>
<h1>Signup</h1>
<form action="src/templates/signup.php" method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="text" name="email" placeholder="E-mail">
    <input type="password" name="pwd" placeholder="Password">
    <button type="submit" name="signup-submit">Signup</button>
</form>
</main>

<?php
include "src/templates/footer.php";
?>