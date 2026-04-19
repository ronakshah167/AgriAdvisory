<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Share your feedback with AgriAdvisory Hub. Help us improve our services for farmers.">
    <title>Feedback — AgriAdvisory Hub</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .rating-stars {
            display: flex;
            gap: 8px;
            margin: 12px 0;
            justify-content: center;
        }

        .rating-stars input {
            display: none;
        }

        .rating-stars label {
            font-size: 2rem;
            color: var(--border-color);
            cursor: pointer;
            transition: var(--transition-fast);
        }

        .rating-stars label:hover,
        .rating-stars label:hover~label,
        .rating-stars input:checked~label {
            color: #f1c40f;
        }

        .rating-stars {
            flex-direction: row-reverse;
        }
    </style>
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
        <a href="feedback.php" class="active">Feedback</a>
        <a href="privacy.php">Privacy</a>
    </nav>

    <header class="header-slim">
        <span class="badge">Share Your Thoughts</span>
        <h1>Farmer Feedback</h1>
        <p>Your suggestions help us build better tools for the farming community.</p>
    </header>

    <main class="section">
        <form id="feedbackForm">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group" style="text-align: center; margin-top: 20px;">
                <label>Overall Experience</label>
                <div class="rating-stars">
                    <input type="radio" id="star5" name="rating" value="5" required><label for="star5">★</label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                </div>
            </div>

            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="message" placeholder="What can we do better? Or what do you love about us?"
                    required></textarea>
            </div>

            <button type="submit" style="width: 100%; margin-top: 12px; padding: 14px;">Submit Feedback</button>
            <div id="msg"></div>
        </form>
    </main>

    <footer>
        <p>&copy; 2026 AgriAdvisory Hub. <a href="report_issue.php">Report an Issue</a> | <a
                href="privacy.php">Privacy Policy</a></p>
    </footer>

    <script>
        document.getElementById('feedbackForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const msgDiv = document.getElementById('msg');
            msgDiv.textContent = 'Submitting...';

            const formData = new FormData(e.target);
            try {
                const response = await fetch('submit_feedback.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                msgDiv.textContent = result.message;
                if (result.success) {
                    e.target.reset();
                    msgDiv.style.color = 'var(--accent-primary)';
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