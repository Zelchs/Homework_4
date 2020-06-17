<?php
include "src/header.php";
?>
<main>
<h1>Signup</h1>
<form action="src/signup.php" method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="pwd" placeholder="Password" required>
    <button type="submit" name="signup-submit">Signup</button>
</form>
</main>

<?php
include "src/footer.php";
?>