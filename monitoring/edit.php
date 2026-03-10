<?php
// edit.php - Updated with text input for priority sector
session_start();
require_once 'database.php';

$id = $_GET['id'] ?? 0;

// Fetch project data
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) {
    $_SESSION['message'] = "Project not found";
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $year_approved = $_POST['year_approved'];
    $beneficiary = $_POST['beneficiary'];
    $contact_person = $_POST['contact_person'];
    $fund_amount = $_POST['fund_amount'];
    $email = $_POST['email'];
    $contact_details = $_POST['contact_details'];
    $address = $_POST['address'];
    $city_municipality = $_POST['city_municipality'];
    $district = $_POST['district'];
    $priority_sector = $_POST['priority_sector'];

    $sql = "UPDATE projects SET 
            year_approved = ?, beneficiary = ?, contact_person = ?, 
            fund_amount = ?, email = ?, contact_details = ?, 
            address = ?, city_municipality = ?, district = ?, 
            priority_sector = ? WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$year_approved, $beneficiary, $contact_person, $fund_amount, $email, $contact_details, $address, $city_municipality, $district, $priority_sector, $id]);
        $_SESSION['message'] = "Project updated successfully";
        header('Location: index.php');
        exit();
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2><i class="fas fa-edit"></i> Edit Project</h2>
                <hr>
            </div>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Year Approved <span class="text-danger">*</span></label>
                    <input type="number" name="year_approved" class="form-control" value="<?php echo htmlspecialchars($project['year_approved']); ?>" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Beneficiary <span class="text-danger">*</span></label>
                    <input type="text" name="beneficiary" class="form-control" value="<?php echo htmlspecialchars($project['beneficiary']); ?>" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Contact Person <span class="text-danger">*</span></label>
                    <input type="text" name="contact_person" class="form-control" value="<?php echo htmlspecialchars($project['contact_person']); ?>" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Fund Amount (₱) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="fund_amount" class="form-control" value="<?php echo htmlspecialchars($project['fund_amount']); ?>" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($project['email']); ?>" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Contact Details <span class="text-danger">*</span></label>
                    <input type="text" name="contact_details" class="form-control" value="<?php echo htmlspecialchars($project['contact_details']); ?>" required>
                </div>
                
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Address <span class="text-danger">*</span></label>
                    <textarea name="address" class="form-control" rows="2" required><?php echo htmlspecialchars($project['address']); ?></textarea>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">City/Municipality <span class="text-danger">*</span></label>
                    <input type="text" name="city_municipality" class="form-control" value="<?php echo htmlspecialchars($project['city_municipality']); ?>" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">District <span class="text-danger">*</span></label>
                    <input type="text" name="district" class="form-control" value="<?php echo htmlspecialchars($project['district']); ?>" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Priority Sector <span class="text-danger">*</span></label>
                    <input type="text" name="priority_sector" class="form-control" value="<?php echo htmlspecialchars($project['priority_sector']); ?>" required 
                           placeholder="e.g., AGRICULTURE, POULTRY, MEALS AND MINING">
                    <small class="text-muted">You can type any sector</small>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Project
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>