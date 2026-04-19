<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Expert agricultural advisory and crop management tips on AgriAdvisory Hub.">
    <title>Expert Advisory — AgriAdvisory Hub</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .experts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 18px;
            margin-top: 24px;
        }

        .expert-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 22px;
            transition: var(--transition-fast);
        }

        .expert-card:hover {
            border-color: var(--accent-secondary);
        }

        .expert-badge {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--accent-primary);
            background: rgba(45, 106, 79, 0.08);
            border-radius: 4px;
            padding: 3px 9px;
            margin-bottom: 10px;
        }

        .expert-name {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .expert-qual {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .expert-meta {
            font-size: 0.82rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .expert-exp {
            font-size: 0.78rem;
            color: var(--accent-primary);
            font-weight: 600;
            margin-top: 10px;
        }

        .request-form-wrap {
            max-width: 620px;
        }

        .input-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        @media (max-width: 600px) {
            .input-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <nav>
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
        <a href="products.php">Products</a>
        <a href="advisory.php" class="active">Advisory</a>
        <a href="weather.php">Weather</a>
        <a href="soil.php">Soil Test</a>
        <a href="checkout.php">Cart</a>
        <a href="feedback.php">Feedback</a>
        <a href="privacy.php">Privacy</a>
    </nav>

    <header class="header-slim">
        <h1>Crop Advisory</h1>
        <p>Expert insights for sustainable farming</p>
    </header>

    <div class="section">
        <h2>Farming Essentials</h2>
        <p>Success in farming starts with the right knowledge. Explore our curated guides to improve your yield and farm
            health.</p>

        <div class="features" style="margin-top: 30px;">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m16 11 1.5 1.5 3-3" />
                        <path d="M5 22h14" />
                        <path d="M5 2h14" />
                        <path d="M12 2v20" />
                        <path d="m5 7 2 2 4-4" />
                    </svg>
                </div>
                <h3>Seasonal Planning</h3>
                <p>Learn which crops are best for the current monsoon or winter season in your region.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2" />
                        <path d="M7 2v20" />
                        <path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7" />
                    </svg>
                </div>
                <h3>Pest Control</h3>
                <p>Identify common pests and learn organic ways to protect your crops without harmful chemicals.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M7 16.3c2.2 0 4-1.8 4-4 0-2.2-1.8-4-4-4s-4 1.8-4 4c0 2.2 1.8 4 4 4Z" />
                        <path d="M12 12h9" />
                        <path d="M18 8l3 4-3 4" />
                    </svg>
                </div>
                <h3>Water Management</h3>
                <p>Efficient irrigation techniques like drip and sprinkler systems to save water and cost.</p>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Our Agricultural Experts</h2>
        <p>Connect with our certified scientists for personalised crop consultation.</p>
        <div id="experts-grid" class="experts-grid">
            <p style="color: var(--text-muted);">Loading experts...</p>
        </div>
    </div>

    <div class="section">
        <h2>Request Expert Consultation</h2>
        <p style="margin-bottom: 24px;">Fill in the form below and one of our experts will reach out to you within 24
            hours.</p>
        <div class="request-form-wrap">
            <form id="advisory-form">
                <div class="input-row">
                    <div class="form-group">
                        <label for="adv-name">Full Name</label>
                        <input type="text" id="adv-name" placeholder="Your name" required>
                    </div>
                    <div class="form-group">
                        <label for="adv-phone">Phone Number</label>
                        <input type="text" id="adv-phone" placeholder="+91 XXXXX XXXXX" required>
                    </div>
                </div>
                <div class="input-row">
                    <div class="form-group">
                        <label for="adv-email">Email</label>
                        <input type="email" id="adv-email" placeholder="you@example.com">
                    </div>
                    <div class="form-group">
                        <label for="adv-crop">Crop Type</label>
                        <input type="text" id="adv-crop" placeholder="e.g. Paddy, Cotton">
                    </div>
                </div>
                <div class="form-group">
                    <label for="adv-issue">Describe Your Issue</label>
                    <textarea id="adv-issue" rows="4"
                        placeholder="Describe the problem you are facing with your farm or crop..." required></textarea>
                </div>
                <div class="form-group">
                    <label for="adv-date">Preferred Consultation Date</label>
                    <input type="date" id="adv-date">
                </div>
                <button type="submit" id="adv-submit-btn">Submit Request</button>
            </form>
            <p id="adv-msg" style="margin-top: 14px; color: var(--accent-primary); font-weight: 500;"></p>
        </div>
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
    <script>
        // Load experts from database
        (async function loadExperts() {
            const grid = document.getElementById('experts-grid');
            try {
                const res = await fetch('get_advisory.php');
                const data = await res.json();

                if (!data || data.length === 0) {
                    grid.innerHTML = '<p style="color:var(--text-muted);">No experts listed yet.</p>';
                    return;
                }

                grid.innerHTML = '';
                data.forEach(expert => {
                    const card = document.createElement('div');
                    card.className = 'expert-card';
                    card.innerHTML = `
                        <div class="expert-badge">${expert.specialisation || 'Agriculture'}</div>
                        <div class="expert-name">${expert.name}</div>
                        <div class="expert-qual">${expert.qualification || ''}</div>
                        <div class="expert-meta">📍 ${expert.state_coverage || 'Pan India'}</div>
                        <div class="expert-exp">${expert.experience_yrs} yrs experience</div>
                    `;
                    grid.appendChild(card);
                });
            } catch (err) {
                grid.innerHTML = '<p style="color:var(--text-muted);">Could not load experts. Please ensure the database is running.</p>';
            }
        })();

        // Advisory consultation request form
        const advisoryForm = document.getElementById('advisory-form');
        if (advisoryForm) {
            advisoryForm.onsubmit = async function (e) {
                e.preventDefault();
                const btn = document.getElementById('adv-submit-btn');
                btn.innerText = 'Submitting...';
                btn.disabled = true;

                const farmerId = getCookie('farmerId') || '';
                const body = [
                    `farmer_id=${encodeURIComponent(farmerId)}`,
                    `farmer_name=${encodeURIComponent(document.getElementById('adv-name').value.trim())}`,
                    `farmer_phone=${encodeURIComponent(document.getElementById('adv-phone').value.trim())}`,
                    `farmer_email=${encodeURIComponent(document.getElementById('adv-email').value.trim())}`,
                    `crop_type=${encodeURIComponent(document.getElementById('adv-crop').value.trim())}`,
                    `issue_desc=${encodeURIComponent(document.getElementById('adv-issue').value.trim())}`,
                    `preferred_date=${encodeURIComponent(document.getElementById('adv-date').value)}`
                ].join('&');

                try {
                    const res = await fetch('request_advisory.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: body
                    });
                    const result = await res.json();
                    const msg = document.getElementById('adv-msg');

                    if (result.status === 'success') {
                        msg.innerText = '✅ Request submitted! Our expert will contact you within 24 hours.';
                        advisoryForm.reset();
                        showToast('Consultation request saved.');
                    } else {
                        msg.innerText = result.message || 'Something went wrong.';
                        showToast('Request failed. Please try again.');
                    }
                } catch (err) {
                    showToast('Network error. Please check your connection.');
                } finally {
                    btn.innerText = 'Submit Request';
                    btn.disabled = false;
                }
            };
        }
    </script>

</body>

</html>