<?php
    include "config/config.php";
    include "src/header.php";
    
?>
<main>

<?php
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (isset($_SESSION['user'])) {
        echo "<h2>Hello " . $_SESSION['user'] . "!</h2><br>";
        echo "<p class='logged-in'>You are logged in!</p>";
        include "newexercise.php";
        echo "<hr>";
        include "filterForm.php";
        if (isset($_GET['exercise'])) {
            $aName = "%" . $_GET['exercise'] . "%";
            $stmt = $conn->prepare("SELECT *
            FROM todo
            WHERE exercise
            LIKE (?)
            AND userid = (?)");
            $stmt->bind_param("sd", $aName, $_SESSION['id']); 
            $stmt->execute();
            $result = $stmt->get_result();
        } 
        else {
            $stmt = $conn->prepare("SELECT *
            FROM todo
            WHERE userid = (?)");
            $stmt->bind_param("d", $_SESSION['id']); 
            $stmt->execute();
            $result = $stmt->get_result();
        }
        if ($result->num_rows > 0) {
            echo "<h2 id='my-form'>Your notes:</h2>";
            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $checked = "";
                $exClass = "unmarked";
                $exercise = $row['exercise'];
                $note = $row['note'];
                if ($row['done']) {
                    $checked = "checked";
                    $exClass .= " marked";
                }
                if (isset($row['tododate'])) {
                    $tododate = $row['tododate'];
                }
            $html = "<div class='$exClass'>"; 
            $html .= "<form action='src/updatedata.php' method='post'>";
            $html .= "<input class='done' type='checkbox' name='done' $checked>";
            $html .= "<input class='exercise' name='exercise' placeholder='exercise' value='$exercise'>";
            $html .= "<input class='note' name='note' placeholder='note' value='$note' size='60'>";
            $html .= "<input type='date' class='tododate' name='tododate' value='$tododate'>";
            $html .= "<button type='submit' class='update button' name='updatedata' value='$id'>Update your note</button>";
            $html .= "</form>";
            $html .= "<form action='src/deletedata.php' method='post'>";
            $html .= "<button type='submit' name='deletedata' value='$id' class='delete-button'>";
            $html .= "Delete exercise</button>";
            $html .= "</form>";
            $html .= "</div>";
            echo $html;
            }
        } 
        else {
            echo "0 results";
        }
    }
    else {
        echo "<p class='logged-out'>You are logged out!</p>";
    }
?>
</main>


<?php
    include "src/footer.php";
?>