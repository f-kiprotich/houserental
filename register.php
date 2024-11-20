<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <?php include('./header.php'); ?>
</head>
<body>
    <main id="main" class="bg-light">
        <div id="register-form" class="container">
            <div class="card col-md-6 mx-auto mt-5">
                <div class="card-body">
                    <h4 class="text-center">Create an Account</h4>
                    <form id="signup-form">
                        <div class="form-group">
                            <form action="login.php" method="post">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" name="role" class="form-control" required>
                                <option value="admin">Administrator</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="login.php">Already have an account? Login</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<script>
    $('#signup-form').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: 'ajax.php?action=signup',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp){
                if(resp == 1){
                    alert("Registration successful.");
                    location.href = 'login.php';
                } else {
                    alert("Registration failed. Please try again.");
                }
            }
        });
    });
</script>
</html>
