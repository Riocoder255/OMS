<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GCash Payment Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="form-title">GCash Payment</h2>
        <form action="./process_gcash_payment.php" method="POST">
            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label"><strong>Your Name</strong></label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label"><strong>Email</strong></label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <!-- Amount -->
            <div class="mb-3">
                <label for="amount" class="form-label"><strong>Amount (₱)</strong></label>
                <input type="number" class="form-control" id="amount" name="amount" required min="1" step="0.01">
            </div>

            <button type="submit" class="btn btn-primary">Proceed to Pay via GCash</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
