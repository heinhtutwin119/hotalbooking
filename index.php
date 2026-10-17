<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link rel= "stylesheet" href="css/bootstrap.min.css">
    <!-- <style>
     .hero {
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
    background-size: cover;
    background-position: center;
    height: 100%;
    display: flex;
    align-items: center;
    color: var(--white-color);
    text-align: center;
    margin-top: 160px;
    }      
    </style> -->

    <style>
        div h1 {
            color:rgba(red, green, blue, alpha)
        }
    </style>

</head>


<body class="hero" style="background:black;" >
    <div class="container text-center" style= "max-width: 600px;">
    <h1 class="h3 my-4" style= "color:white;

        font-weight: bold;">Login</h1>

    <?php if (isset($_GET['incorrect'])) :?>

    <div class= "alert alert-warning" >
        Incorrect email or password
    </div>
    <?php endif ?>

    <?php if (isset($_GET['register'])) :?>

    <div class= "alert alert-info" >
    Account created, please login</div>
    <?php endif ?>

    <?php if (isset($_GET['suspended'])) :?>

    <div class= "alert alert-danger" >
    Account suspended!</div>
    <?php endif ?>

    <form action="_actions/login.php" method="post" class= "mb-2">
        <input type="email" class="form-control mb-3 p-3" name= "email" placeholder= "Email" required>
        <input type="password" class="form-control mb-3 p-3" name= "password" placeholder= "Password" required>
        <button class="btn btn-primary w-100" >Login</button>
    </form>
    <a href="register.php" style="color:black ; font-size:18px; ">Register</a>
    
    </div>
    
</body>
</html>