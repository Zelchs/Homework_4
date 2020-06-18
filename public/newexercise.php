<h2>Add new note:</h2>
<form action="../src/addnote.php" method="post">
    <input type="text" name="headline" placeholder="To do!" required/>
    <label for="tododate">Date</label>
    <input type="date"
       name="todoDate"
       value="2020-06-18"
       min="2020-06-07" max="2025-06-14">
    <br>
    <textarea name="noteContent" cols="40" rows="5" placeholder="Add notes here"></textarea>
    <button type="submit" name="addnote" class="button">Add note</button>
</form>
