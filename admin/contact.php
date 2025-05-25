<?php
// admin/contact.php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/db.php';

// checkAdminAccess();

// Mark message as read
if (isset($_GET['mark_read']) {
    $id = intval($_GET['mark_read']);
    $db->query("UPDATE contacts SET is_read = 1 WHERE id = ?", [$id]);
    $_SESSION['message'] = 'Message marked as read';
    header('Location: contact.php');
    exit;
}

// Delete message
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $db->query("DELETE FROM contacts WHERE id = ?", [$id]);
    $_SESSION['message'] = 'Message deleted successfully';
    header('Location: contact.php');
    exit;
}

// Get all contact messages
$contacts = $db->fetchAll("SELECT * FROM contacts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include '../includes/sidebar.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <h1 class="h2 mb-4">Contact Messages</h1>
                
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-info"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contacts as $contact): ?>
                                    <tr class="<?php echo $contact['is_read'] ? '' : 'table-primary'; ?>">
                                        <td><?php echo $contact['id']; ?></td>
                                        <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                        <td><a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>"><?php echo htmlspecialchars($contact['email']); ?></a></td>
                                        <td><?php echo $contact['phone'] ? htmlspecialchars($contact['phone']) : 'N/A'; ?></td>
                                        <td><?php echo $contact['subject'] ? htmlspecialchars($contact['subject']) : 'No Subject'; ?></td>
                                        <td><?php echo nl2br(htmlspecialchars(substr($contact['message'], 0, 50))); ?>...</td>
                                        <td><?php echo date('M j, Y h:i A', strtotime($contact['created_at'])); ?></td>
                                        <td>
                                            <?php if ($contact['is_read']): ?>
                                                <span class="badge bg-success">Read</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Unread</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="#" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#messageModal<?php echo $contact['id']; ?>">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="contact.php?mark_read=<?php echo $contact['id']; ?>" class="btn btn-success">
                                                    <i class="bi bi-check"></i>
                                                </a>
                                                <a href="contact.php?delete=<?php echo $contact['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this message?');">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                            
                                            <!-- Message Modal -->
                                            <div class="modal fade" id="messageModal<?php echo $contact['id']; ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Message from <?php echo htmlspecialchars($contact['name']); ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($contact['email']); ?></p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><strong>Phone:</strong> <?php echo $contact['phone'] ? htmlspecialchars($contact['phone']) : 'N/A'; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <p><strong>Subject:</strong> <?php echo $contact['subject'] ? htmlspecialchars($contact['subject']) : 'No Subject'; ?></p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <p><strong>Message:</strong></p>
                                                                <div class="p-3 bg-light rounded">
                                                                    <?php echo nl2br(htmlspecialchars($contact['message'])); ?>
                                                                </div>
                                                            </div>
                                                            <div class="text-muted">
                                                                <small>Received on <?php echo date('M j, Y h:i A', strtotime($contact['created_at'])); ?></small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>" class="btn btn-primary">
                                                                <i class="bi bi-reply"></i> Reply
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>