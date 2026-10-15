<?php
require 'auth.php';
require 'config.php';
$sql = 'SELECT s.id, s.nim, s.name, m.name AS major_name FROM students s JOIN majors m ON s.major_id = m.id ORDER BY s.id DESC';
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Student Dashboard</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="bg-light">
<?php include 'navbar.php'; ?>
<div class="container mt-4"><div class="card shadow-sm"><div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2"><h4 class="mb-0">Student Management</h4><a href="create.php" class="btn btn-success btn-sm">+ Add Student</a></div><div class="card-body"><div class="table-responsive"><table class="table table-bordered table-striped table-hover align-middle"><thead class="table-dark"><tr><th>No</th><th>NIM</th><th>Name</th><th>Major</th><th class="text-center">Actions</th></tr></thead><tbody>
<?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?><tr><td><?= $no++ ?></td><td><?= htmlspecialchars($row['nim'], ENT_QUOTES, 'UTF-8') ?></td><td><?= htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') ?></td><td><?= htmlspecialchars($row['major_name'], ENT_QUOTES, 'UTF-8') ?></td><td class="text-center"><a href="edit.php?id=<?= (int)$row['id'] ?>" class="btn btn-warning btn-sm">Edit</a> <?php if (is_admin()): ?><a href="delete.php?id=<?= (int)$row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a><?php endif; ?></td></tr><?php endwhile; ?>
<?php if (mysqli_num_rows($result) === 0): ?><tr><td colspan="5" class="text-center">No students found.</td></tr><?php endif; ?>
</tbody></table></div></div></div></div></body></html>
