<?php
require 'auth.php';
require 'config.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { http_response_code(400); exit('Invalid student ID.'); }
$stmt = mysqli_prepare($conn, 'SELECT id, nim, name, major_id FROM students WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id); mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$data) { http_response_code(404); exit('Student not found.'); }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = trim($_POST['nim'] ?? ''); $name = trim($_POST['name'] ?? ''); $major_id = filter_input(INPUT_POST, 'major_id', FILTER_VALIDATE_INT);
    if ($nim === '' || !ctype_digit($nim)) $error = 'NIM must contain digits only.';
    elseif ($name === '' || !$major_id) $error = 'Please complete all fields.';
    else { $stmt = mysqli_prepare($conn, 'UPDATE students SET nim = ?, name = ?, major_id = ? WHERE id = ?'); mysqli_stmt_bind_param($stmt, 'ssii', $nim, $name, $major_id, $id); mysqli_stmt_execute($stmt); header('Location: index.php'); exit; }
}
$majors = mysqli_query($conn, 'SELECT id, name FROM majors ORDER BY name');
$nim_value = $_POST['nim'] ?? $data['nim']; $name_value = $_POST['name'] ?? $data['name']; $major_value = $_POST['major_id'] ?? $data['major_id'];
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Edit Student</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="bg-light"><?php include 'navbar.php'; ?><div class="container mt-4"><div class="row justify-content-center"><div class="col-md-6"><div class="card shadow-sm"><div class="card-header bg-warning"><h5 class="mb-0">Edit Student Data</h5></div><div class="card-body">
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
<form method="post"><div class="mb-3"><label for="nim" class="form-label">NIM</label><input class="form-control" id="nim" name="nim" inputmode="numeric" pattern="[0-9]+" value="<?= htmlspecialchars((string)$nim_value, ENT_QUOTES, 'UTF-8') ?>" required></div><div class="mb-3"><label for="name" class="form-label">Name</label><input class="form-control" id="name" name="name" value="<?= htmlspecialchars((string)$name_value, ENT_QUOTES, 'UTF-8') ?>" required></div><div class="mb-4"><label for="major_id" class="form-label">Major</label><select class="form-select" id="major_id" name="major_id" required><?php while ($m = mysqli_fetch_assoc($majors)): ?><option value="<?= (int)$m['id'] ?>" <?= (string)$major_value === (string)$m['id'] ? 'selected' : '' ?>><?= htmlspecialchars($m['name'], ENT_QUOTES, 'UTF-8') ?></option><?php endwhile; ?></select></div><div class="d-flex justify-content-end gap-2"><a href="index.php" class="btn btn-secondary">Cancel</a><button type="submit" class="btn btn-warning">Update Data</button></div></form>
</div></div></div></div></div></body></html>
