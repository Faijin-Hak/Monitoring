<?php
// view.php - View single project
require_once 'database.php';

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .detail-label {
            font-weight: bold;
            background-color: #f8f9fa;
            padding: 10px;
            border-right: 2px solid #dee2e6;
        }
        .detail-value {
            padding: 10px;
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Project Details</h2>
        
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><?php echo htmlspecialchars($project['beneficiary']); ?></h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td class="detail-label" width="30%">Year Approved:</td>
                        <td class="detail-value"><?php echo htmlspecialchars($project['year_approved']); ?></td>
                    </tr>
                    <tr>
                        <td class="detail-label">Beneficiary:</td>
                        <td class="detail-value"><?php echo htmlspecialchars($project['beneficiary']); ?></td>
                    </tr>
                    <tr>
                        <td class="detail-label">Contact Person:</td>
                        <td class="detail-value"><?php echo htmlspecialchars($project['contact_person']); ?></td>
                    </tr>
                    <tr>
                        <td class="detail-label">Fund Amount:</td>
                        <td class="detail-value">₱<?php echo number_format($project['fund_amount'], 2); ?></td>
                    </tr>
                    <tr>
                        <td class="detail-label">Email:</td>
                        <td class="detail-value"><?php echo htmlspecialchars($project['email']); ?></td>
                    </tr>
                    <tr>
                        <td class="detail-label">Contact Details:</td>
                        <td class="detail-value"><?php echo htmlspecialchars($project['contact_details']); ?></td>
                    </tr>
                    <tr>
                        <td class="detail-label">Address:</td>
                        <td class="detail-value"><?php echo htmlspecialchars($project['address']); ?></td>
                    </tr>
                    <tr>
                        <td class="detail-label">City/Municipality:</td>
                        <td class="detail-value"><?php echo htmlspecialchars($project['city_municipality']); ?></td>
                    </tr>
                    <tr>
                        <td class="detail-label">District:</td>
                        <td class="detail-value"><?php echo htmlspecialchars($project['district']); ?></td>
                    </tr>
                    <tr>
                        <td class="detail-label">Priority Sector:</td>
                        <td class="detail-value">
                            <span class="badge bg-success"><?php echo htmlspecialchars($project['priority_sector']); ?></span>
                        </td>
                    </tr>
                </table>
                
                <div class="mt-3">
                    <a href="edit.php?id=<?php echo $project['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="index.php" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>