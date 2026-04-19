<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Login to AgriAdvisory Hub to access personalized farming advice and your farm profile.">
    <title>Login — AgriAdvisory Hub</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav>
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
        <a href="login.php" class="active">Login</a>
        <a href="products.php">Products</a>
        <a href="advisory.php">Advisory</a>
        <a href="weather.php">Weather</a>
        <a href="soil.php">Soil Test</a>
        <a href="checkout.php">Cart</a>
        <a href="feedback.php">Feedback</a>
        <a href="privacy.php">Privacy</a>
    </nav>

    <header class="header-slim">
        <h1>Farmer Login</h1>
        <p>Access your advisory dashboard and farm insights</p>
    </header>

    <div class="section">
        <h2>Sign In to Your Account</h2>

        <form id="login-form">
            <div class="form-group">
                <label for="login-email">Email Address</label>
                <input type="email" id="login-email" placeholder="you@example.com" required>
            </div>

            <div class="form-group">
                <label for="login-pass">Password</label>
                <input type="password" id="login-pass" placeholder="Enter your password" required>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" id="remember-me" style="width: auto; margin: 0;">
                    <label for="remember-me"
                        style="font-size: 0.85rem; color: var(--text-secondary); cursor: pointer;">Remember Me</label>
                </div>
                <a href="#" style="font-size: 0.85rem; color: var(--accent-primary); text-decoration: none;">Forgot
                    Password?</a>
            </div>

            <button type="submit" style="margin-top: 24px; width: 100%;">Sign In</button>
        </form>

        <p style="text-align: center; margin-top: 24px; color: var(--text-muted); font-size: 0.9rem;">
            Don't have an account? <a href="register.php"
                style="color: var(--accent-primary); text-decoration: none; font-weight: 600;">Register Now</a>
        </p>

        <p id="msg"></p>
    </div>

    <footer>
        <div style="margin-bottom: 15px;">
            <a href="feedback.php">Give Feedback</a> |
            <a href="report_issue.php">Report Issue</a> |
            <a href="privacy.php">Privacy Policy</a>
        </div>
        <p>&copy; 2026 AgriAdvisory Hub. Built for farmers, by farmers.</p>
    </footer>

    <script src="script.js"></script>

</body>

</html>