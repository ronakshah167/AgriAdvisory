<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Report technical issues or problems with AgriAdvisory Hub.">
    <title>Report Issue — AgriAdvisory Hub</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav>
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
        <a href="products.php">Products</a>
        <a href="advisory.php">Advisory</a>
        <a href="weather.php">Weather</a>
        <a href="soil.php">Soil Test</a>
        <a href="checkout.php">Cart</a>
        <a href="report_issue.php" class="active">Report Issue</a>
        <a href="privacy.php">Privacy</a>
    </nav>

    <header class="header-slim"
        style="background: linear-gradient(150deg, #ffe0e0 0%, #fff5f5 100%); border-bottom: 1px solid #ffcccc;">
        <span class="badge"
            style="background: rgba(192, 57, 43, 0.08); color: #c0392b; border-color: rgba(192, 57, 43, 0.15);">Technical
            Support</span>
        <h1>Report an Issue</h1>
        <p>Encountering a bug or technical problem? Let us know so we can fix it.</p>
    </header>

    <main class="section">
        <form id="issueForm">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="issue_type">Type of Issue</label>
                <select id="issue_type" name="issue_type" required>
                    <option value="" disabled selected>Select issue category</option>
                    <option value="Technical Bug">Technical Bug (Website not working)</option>
                    <option value="Data Inquiry">Data Inquiry (Soil/Weather data issue)</option>
                    <option value="Marketplace Issue">Marketplace Issue (Orders/Products)</option>
                    <option value="Account Issue">Account Issue (Login/Registration)</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Detailed Description</label>
                <textarea id="description" name="description"
                    placeholder="Describe the problem in detail. Include what you were doing when it happened."
                    required></textarea>
            </div>

            <button type="submit" style="width: 100%; margin-top: 12px; padding: 14px; background: #c0392b;">Submit
                Issue Report</button>
            <div id="msg"></div>
        </form>
    </main>

    <footer>
        <p>&copy; 2026 AgriAdvisory Hub. <a href="feedback.php">Give Feedback</a> | <a href="privacy.php">Privacy
                Policy</a></p>
    </footer>

    <script>
        document.getElementById('issueForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const msgDiv = document.getElementById('msg');
            msgDiv.textContent = 'Submitting report...';

            const formData = new FormData(e.target);
            try {
                const response = await fetch('submit_issue.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                msgDiv.textContent = result.message;
                if (result.success) {
                    e.target.reset();
                    msgDiv.style.color = '#c0392b';
                } else {
                    msgDiv.style.color = '#c0392b';
                }
            } catch (err) {
                msgDiv.textContent = 'Connection error. Please try again.';
                msgDiv.style.color = '#c0392b';
            }
        });
    </script>
</body>

</html>