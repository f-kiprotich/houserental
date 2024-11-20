<?php
// Include header and any required authentication checks
include 'header.php'; // Replace with your header file if needed
?>

<h2>Request Rent Payment</h2>
<form action="process_stk_push.php" method="POST">
    <label for="amount">Rent Amount:</label>
    <input type="number" id="amount" name="amount" required><br><br>

    <label for="phone">Phone Number (format 2547XXXXXXXX):</label>
    <input type="text" id="phone" name="phone" required pattern="2547[0-9]{8}"><br><br>

    <button type="submit">Request Payment</button>
</form>

<?php
// Include footer if needed
include 'footer.php';
?>
