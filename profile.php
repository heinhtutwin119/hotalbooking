
<?php
include("vendor/autoload.php");


use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\UsersTable;  
use Libs\Database\MySQL;

$user = Auth::check();

if ($user) {
    $table = new UsersTable(new MySQL());
   
    $currentUser = $table->findById($user->id);
} else {
    HTTP::redirect("/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #007bff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }
        .profile-container {
            max-width: 600px;
            margin-top: 50px;
            text-align: center;
        }
  .profile-img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid #007bff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 15px;
  }

    </style>
</head>

<body>

<div class="container profile-container">

    <h1 class="h3 profile-title mb-4">My Profile</h1>

    <!-- $user အစား $currentUser ကို ပြောင်းသုံးထားသည် -->
    <?php if (!empty($currentUser->photo)): ?>
        <img src="photo/<?= $currentUser->photo; ?>" alt="Profile Photo" class="profile-img">
    <?php else: ?>
        <img src="photo/default.png" alt="Default Photo" class="profile-img">
    <?php endif; ?>
    <form
        action="_actions/upload.php"
        method="post"
        class="profile-form mb-4"
        enctype="multipart/form-data"
    >
        <input
            type="file"
            name="photo"
            class="form-control mb-3"
            accept="image/*"
            required
        >

        <button type="submit" class="btn btn-primary w-100">
            Upload Photo
        </button>
    </form>

    <ul class="list-group mb-3 text-start">
        <li class="list-group-item">
            <strong>Name:</strong>
            <?= htmlspecialchars($currentUser->name ?? '') ?>
        </li>

        <li class="list-group-item">
            <strong>Email:</strong>
            <?= htmlspecialchars($currentUser->email ?? '') ?>
        </li>

        <li class="list-group-item">
            <strong>Phone:</strong>
            <?= htmlspecialchars($currentUser->phone ?? '') ?>
        </li>

        <li class="list-group-item">
            <strong>Address:</strong>
            <?= htmlspecialchars($currentUser->address ?? '') ?>
        </li>
    </ul>

    <div class="profile-links">
        <a href="home.php" class="me-3">Home</a>
        <a href="admin.php" class="me-3">Admin</a>
        <a href="_actions/logout.php" class="text-danger">Logout</a>
    </div>

</div>

</body>
</html>