<?php
require 'auth.php';
require 'config.php';
$majors = mysqli_query($conn, 'SELECT id, name FROM majors ORDER BY name');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = trim($_POST['nim'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $major_id = filter_input(INPUT_POST, 'major_id', FILTER_VALIDATE_INT);
    if ($nim === '' || !ctype_digit($nim)) $error = 'NIM must contain digits only.';
    elseif ($name === '' || !$major_id) $error = 'Please complete all fields.';
    else {
        $stmt = mysqli_prepare($conn, 'INSERT INTO students (nim, name, major_id) VALUES (?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'ssi', $nim, $name, $major_id);
        mysqli_stmt_execute($stmt);
        header('Location: index.php'); exit;
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Add Student</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="bg-light"><?php include 'navbar.php'; ?><div class="container mt-4"><div class="row justify-content-center"><div class="col-md-6"><div class="card shadow-sm"><div class="card-header bg-success text-white"><h5 class="mb-0">Add New Student</h5></div><div class="card-body">
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
<form method="post"><div class="mb-3"><label for="nim" class="form-label">NIM</label><input type="text" inputmode="numeric" pattern="[0-9]+" class="form-control" id="nim" name="nim" required value="<?= htmlspecialchars($_POST['nim'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></div><div class="mb-3"><label for="name" class="form-label">Name</label><input class="form-control" id="name" name="name" required value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"></div><div class="mb-4"><label for="major_id" class="form-label">Major</label><select class="form-select" id="major_id" name="major_id" required><option value="">Select Major...</option><?php while ($m = mysqli_fetch_assoc($majors)): ?><option value="<?= (int)$m['id'] ?>" <?= (string)($_POST['major_id'] ?? '') === (string)$m['id'] ? 'selected' : '' ?>><?= htmlspecialchars($m['name'], ENT_QUOTES, 'UTF-8') ?></option><?php endwhile; ?></select></div><div class="d-flex justify-content-end gap-2"><a href="index.php" class="btn btn-secondary">Cancel</a><button type="submit" class="btn btn-success">Save Data</button></div></form>
</div></div></div></div></div></body></html>
