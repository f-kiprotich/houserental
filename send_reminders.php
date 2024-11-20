<?php
// Include database connection
include 'db_connect.php'; // Adjust path as necessary

// Set reminder criteria (e.g., rent due in the next 5 days)
$today = date('Y-m-d');
$dueSoonDate = date('Y-m-d', strtotime('+5 days'));

// Query to find tenants with due rent within the specified period
$query = "SELECT * FROM tenants WHERE due_date BETWEEN '$today' AND '$dueSoonDate'";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $tenantName = $row['tenant_name'];
    $dueDate = $row['due_date'];
    $phone = $row['phone_number'];

    // Send reminder (Example using Twilio SMS)
    $message = "Dear $tenantName, this is a reminder that your rent is due on $dueDate. Please make payment to avoid penalties.";
    sendSMS($phone, $message); // Assuming a sendSMS function is implemented
}

// Function to send SMS (Example placeholder)
function sendSMS($phone, $message) {
    // SMS API logic (e.g., Twilio or other SMS API)
    // Example with Twilio:
    // $twilio = new Client($sid, $token);
    // $twilio->messages->create($phone, ['from' => $fromNumber, 'body' => $message]);
}

// Close database connection
mysqli_close($conn);
