<?php
session_start();
require_once __DIR__ . '/../../config.php';

// Check if the user is logged in and if they are an instructor
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header('Location: /login.php');
    exit();
}

// Fetch the instructor's profile
$stmt = $link->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Handle Profile Update
if (isset($_POST['edit_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    $stmt = $link->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Profile updated successfully.';
        // Return the updated name and email to the page without refresh
        echo json_encode([
            'status' => 'success',
            'name' => $name,
            'email' => $email
        ]);
        exit();
    } else {
        $_SESSION['error'] = 'Error updating profile.';
        echo json_encode(['status' => 'error']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <?php include '../../partials/navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <?php include '../../includes/studentsidebar.php'; ?>

            <div class="col-md-9 col-lg-10 p-4">
                <h3>Your Profile</h3>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" id="profileName"><?= htmlspecialchars($user['name']) ?></h5>
                        <p class="card-text" id="profileEmail">Email: <?= htmlspecialchars($user['email']) ?></p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Profile -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProfileForm">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editName" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Handle Profile Edit Form Submission (AJAX)
        $('#editProfileForm').submit(function (event) {
            event.preventDefault();

            var name = $('#editName').val();
            var email = $('#editEmail').val();

            $.ajax({
                url: 'profile.php',
                type: 'POST',
                data: {
                    edit_profile: true,
                    name: name,
                    email: email
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        // Update the profile name and email without refreshing
                        $('#profileName').text(data.name);
                        $('#profileEmail').text('Email: ' + data.email);
                        $('#editProfileModal').modal('hide'); // Close the modal
                        alert('Profile updated successfully!');
                    } else {
                        alert('Error updating profile.');
                    }
                }
            });
        });
    </script>
</body>
</html>
