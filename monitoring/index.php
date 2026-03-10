<?php
// index.php - Main page with CRUD operations and search
session_start();
require_once 'database.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['message'] = "Record deleted successfully";
    header('Location: index.php');
    exit();
}

// Handle Search
$search = isset($_GET['search']) ? $_GET['search'] : '';
if (!empty($search)) {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE 
                           beneficiary LIKE ? OR 
                           contact_person LIKE ? OR 
                           priority_sector LIKE ? OR 
                           city_municipality LIKE ? OR 
                           district LIKE ? 
                           ORDER BY id DESC");
    $searchTerm = "%$search%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
} else {
    // Fetch all records if no search
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
}
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funded Projects Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .table-wrapper {
            overflow-x: auto;
        }
        .action-btns {
            white-space: nowrap;
        }
        .status-badge {
            background-color: #28a745;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.9em;
        }
        .search-box {
            max-width: 400px;
        }
        .search-highlight {
            background-color: yellow;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="mb-0"><i class="fas fa-project-diagram"></i> Funded Projects Management</h2>
            </div>
            <div class="col-md-4 text-end">
                <a href="add.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Project
                </a>
            </div>
        </div>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <!-- Search Section -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="" class="d-flex">
                    <div class="input-group search-box">
                        <span class="input-group-text bg-primary text-white">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Search by Beneficiary, Contact Person, Priority Sector, City, or District..." 
                               value="<?php echo htmlspecialchars($search); ?>">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <?php if (!empty($search)): ?>
                            <a href="index.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <span class="badge bg-info p-2">
                    <i class="fas fa-database"></i> Total Records: <?php echo count($projects); ?>
                </span>
            </div>
        </div>

        <!-- Results Info -->
        <?php if (!empty($search)): ?>
            <div class="alert alert-info mb-3">
                <i class="fas fa-info-circle"></i> 
                Search results for: <strong>"<?php echo htmlspecialchars($search); ?>"</strong> 
                (Found <?php echo count($projects); ?> records)
            </div>
        <?php endif; ?>

        <div class="table-wrapper">
            <table class="table table-bordered table-striped table-hover" id="projectsTable">
                <thead class="table-dark">
                    <tr>
                        <th>NO</th>
                        <th>YEAR APPROVED</th>
                        <th>BENEFICIARY</th>
                        <th>CONTACT PERSON</th>
                        <th>FUND AMOUNT</th>
                        <th>EMAIL</th>
                        <th>CONTACT DETAILS</th>
                        <th>ADDRESS</th>
                        <th>CITY MUNICIPALITY</th>
                        <th>DISTRICT</th>
                        <th>PRIORITY SECTOR</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($projects)): ?>
                        <tr>
                            <td colspan="12" class="text-center py-4">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No records found</h5>
                                <?php if (!empty($search)): ?>
                                    <p>Try different search terms or <a href="index.php">clear search</a></p>
                                <?php else: ?>
                                    <p>Click "Add New Project" to create your first record</p>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($projects as $index => $project): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($project['year_approved']); ?></td>
                                <td><?php echo htmlspecialchars($project['beneficiary']); ?></td>
                                <td><?php echo htmlspecialchars($project['contact_person']); ?></td>
                                <td class="text-end">₱<?php echo number_format($project['fund_amount'], 2); ?></td>
                                <td><?php echo htmlspecialchars($project['email']); ?></td>
                                <td><?php echo htmlspecialchars($project['contact_details']); ?></td>
                                <td><?php echo htmlspecialchars($project['address']); ?></td>
                                <td><?php echo htmlspecialchars($project['city_municipality']); ?></td>
                                <td><?php echo htmlspecialchars($project['district']); ?></td>
                                <td>
                                    <span class="badge bg-info text-dark p-2">
                                        <?php echo htmlspecialchars($project['priority_sector']); ?>
                                    </span>
                                </td>
                                <td class="action-btns">
                                    <a href="edit.php?id=<?php echo $project['id']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="view.php?id=<?php echo $project['id']; ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="javascript:void(0)" onclick="confirmDelete(<?php echo $project['id']; ?>)" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Live Search Script (Optional - real-time filtering) -->
    <script>
        // For real-time search without page reload (optional)
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('liveSearch');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    let searchValue = this.value.toLowerCase();
                    let tableRows = document.querySelectorAll('#projectsTable tbody tr');
                    
                    tableRows.forEach(row => {
                        let beneficiary = row.cells[2].textContent.toLowerCase();
                        let contactPerson = row.cells[3].textContent.toLowerCase();
                        let prioritySector = row.cells[10].textContent.toLowerCase();
                        let city = row.cells[8].textContent.toLowerCase();
                        let district = row.cells[9].textContent.toLowerCase();
                        
                        if (beneficiary.includes(searchValue) || 
                            contactPerson.includes(searchValue) || 
                            prioritySector.includes(searchValue) ||
                            city.includes(searchValue) ||
                            district.includes(searchValue)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                    
                    // Update record count
                    let visibleRows = document.querySelectorAll('#projectsTable tbody tr:not([style*="display: none"])').length;
                    document.getElementById('recordCount').innerHTML = visibleRows;
                });
            }
        });

        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this record?\nThis action cannot be undone.')) {
                window.location.href = 'index.php?delete=' + id;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>