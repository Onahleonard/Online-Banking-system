<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support - Meridian Online Banking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="newcss.css">
    <style>
        .chat-box { height: 220px; overflow-y: auto; background: #f8f9fa; border-radius: 12px; }
    </style>
</head>
<body class="bg-light">

    <?php include 'header.php'; ?>

    <main class="container my-5" style="max-width: 550px;">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h1 class="h4 fw-bold text-dark mb-1">Customer Assistance</h1>
            <p class="text-muted small mb-4">Contact our support center or use live chat below.</p>

            <div class="chat-box p-3 mb-3 border">
                <div class="p-2 mb-2 bg-white rounded-3 shadow-sm text-dark small">
                    <strong>Support Agent:</strong> Hello! How can we assist with your account today?
                </div>
            </div>

            <form onsubmit="event.preventDefault(); alert('Message sent to customer support.');">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Type your message here..." required>
                    <button class="btn btn-primary" type="submit">Send</button>
                </div>
            </form>

            <a href="dashboard.php" class="btn btn-link text-decoration-none text-muted small p-0">← Return to Dashboard</a>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
