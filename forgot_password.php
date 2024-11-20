<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <?php include('./header.php'); ?>
</head>
<body>
    <main id="main" class="bg-light">
        <div class="container">
            <div class="card col-md-6 mx-auto mt-5">
                <div class="card-body">
                    <h4 class="text-center">Reset Password</h4>
                    <form id="reset-password-form">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<script>
    $('#reset-password-form').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: 'ajax.php?action=reset_password',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp){
                if(resp == 1){
                    alert("Password reset successful.");
                    location.href = 'login.php';
                } else {
                    alert("Failed to reset password. Please try again.");
                }
            }
        });
    });
</script>
</html>
