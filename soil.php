<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Calculate and predict the best crop based on soil parameters.">
    <title>Soil Intelligence — AgriAdvisory Hub</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .soil-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .soil-grid {
                grid-template-columns: 1fr;
            }
        }

        .result-card-premium {
            background: rgba(45, 106, 79, 0.04);
            border: 1px solid var(--accent-secondary);
            border-radius: var(--radius-lg);
            padding: 28px;
            text-align: left;
            position: relative;
            animation: fadeIn 0.3s ease-out;
        }

        .input-group-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 16px;
        }

        .loader-bar {
            width: 100%;
            height: 3px;
            background: var(--bg-secondary);
            border-radius: 3px;
            margin-top: 8px;
            overflow: hidden;
            display: none;
        }

        .loader-bar::after {
            content: '';
            display: block;
            width: 50%;
            height: 100%;
            background: var(--accent-primary);
            animation: shimmer 1.5s infinite linear;
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
        <a href="soil.php" class="active">Soil Test</a>
        <a href="checkout.php">Cart</a>
        <a href="feedback.php">Feedback</a>
        <a href="privacy.php">Privacy</a>
    </nav>

    <header class="header-slim">
        <h1>Soil Intelligence</h1>
        <p>Match soil chemistry with the right crop for your farm</p>
    </header>

    <div class="section" style="max-width: 960px;">
        <div class="soil-grid">
            <div
                style="background: var(--bg-primary); padding: 28px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                <h2>Soil Profile</h2>
                <p style="margin-bottom: 20px;">Complete the profile to generate a crop prediction.</p>

                <form id="soil-calc-form">
                    <div class="form-group">
                        <label>Soil Type</label>
                        <select id="soil-type" required>
                            <option value="">Select Primary Type</option>
                            <option value="alluvial">Alluvial (Potash Rich)</option>
                            <option value="black">Black Soil (Clay Rich)</option>
                            <option value="red">Red Soil (Iron Rich)</option>
                            <option value="laterite">Laterite (Aluminium Rich)</option>
                        </select>
                    </div>

                    <div class="input-group-row">
                        <div class="form-group">
                            <label>pH Value</label>
                            <input type="number" step="0.1" id="soil-ph" placeholder="6.5" min="3" max="10">
                        </div>
                        <div class="form-group">
                            <label>Nitrogen (mg/kg)</label>
                            <input type="number" id="soil-nit" placeholder="100">
                        </div>
                    </div>

                    <button type="submit" id="recommend-btn"
                        style="width: 100%; margin-top: 8px; height: 46px; font-size: 0.95rem;">
                        Analyze Parameters
                    </button>
                    <div id="soil-loader" class="loader-bar"></div>
                </form>
            </div>

            <div id="soil-placeholder"
                style="display: flex; align-items: center; justify-content: center; background: var(--bg-secondary); border: 1px dashed var(--border-color); border-radius: var(--radius-md); text-align: center; padding: 36px;">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                        stroke="var(--text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        style="margin-bottom: 14px;">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 16v-4" />
                        <path d="M12 8h.01" />
                    </svg>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Enter soil parameters to generate a
                        prediction.</p>
                </div>
            </div>

            <div id="soil-result-panel" class="result-card-premium" style="display: none;">
                <div style="display: flex; align-items: flex-start; gap: 20px;">
                    <div id="soil-result-icon"
                        style="background: var(--bg-card); padding: 10px; border-radius: 10px; border: 1px solid var(--accent-primary); color: var(--accent-primary);">
                    </div>
                    <div>
                        <div
                            style="font-size: 0.7rem; text-transform: uppercase; color: var(--accent-primary); font-weight: 600; letter-spacing: 0.06em; margin-bottom: 4px;">
                            Recommended Crop</div>
                        <h3 id="soil-result-title" style="margin: 0; font-size: 1.5rem; color: var(--text-primary);">
                            Cotton / Soybean</h3>
                        <p id="soil-result-desc"
                            style="font-size: 0.92rem; color: var(--text-secondary); margin-top: 10px; line-height: 1.6;">
                        </p>
                    </div>
                </div>

                <div style="margin-top: 24px; display: flex; gap: 10px;">
                    <a href="products.php" class="btn-outline-link"
                        style="display:inline-block; text-decoration:none; padding: 9px 20px; border: 1px solid var(--accent-primary); color: var(--accent-primary); border-radius: 6px; font-weight: 600; font-size: 0.82rem;">View
                        Suitable Seeds</a>
                    <a href="advisory.php"
                        style="display:inline-block; text-decoration:none; padding: 9px 20px; background: rgba(45, 106, 79, 0.06); color: var(--text-primary); border-radius: 6px; font-weight: 500; font-size: 0.82rem;">Farming
                        Guide</a>
                </div>
            </div>
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
        const formalForm = document.getElementById("soil-calc-form");
        const loader = document.getElementById("soil-loader");
        const placeholder = document.getElementById("soil-placeholder");
        const resPanel = document.getElementById("soil-result-panel");

        if (formalForm) {
            formalForm.onsubmit = function (e) {
                e.preventDefault();
                loader.style.display = "block";
                resPanel.style.display = "none";
                placeholder.style.display = "none";

                setTimeout(async () => {
                    loader.style.display = "none";
                    const type = document.getElementById("soil-type").value;
                    const ph = parseFloat(document.getElementById("soil-ph").value) || 6.5;
                    const nitrogen = parseFloat(document.getElementById("soil-nit").value) || null;

                    let crop = "Paddy (Rice)";
                    let desc = "Ideal for alluvial loamy soils with high moisture retention. Your Nitrogen level indicates strong vegetative potential.";
                    let icon = `<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m16 6-4 4-4-4"/><path d="M12 2v8"/></svg>`;

                    if (type === "black") {
                        crop = "Soybean / Cotton";
                        desc = "Black cotton soil provides deep clay content. Perfect for taproot systems like Soybean during this season.";
                    } else if (type === "red") {
                        crop = "Grapes / Groundnut";
                        desc = "Iron-rich red soil with proper pH (6.0-7.0) supports excellent viticulture and legume production.";
                    } else if (type === "laterite") {
                        crop = "Cashew / Coffee";
                        desc = "Low nutrient laterite soil is best utilized for tree-based plantation crops with high endurance.";
                    }

                    document.getElementById("soil-result-title").innerText = crop;
                    document.getElementById("soil-result-desc").innerText = desc;
                    document.getElementById("soil-result-icon").innerHTML = icon;
                    resPanel.style.display = "block";

                    // Save to database
                    try {
                        const farmerId = getCookie('farmerId') || '';
                        const body = [
                            `farmer_id=${encodeURIComponent(farmerId)}`,
                            `soil_type=${encodeURIComponent(type)}`,
                            `ph_value=${encodeURIComponent(ph)}`,
                            `nitrogen_mg_kg=${encodeURIComponent(nitrogen || '')}`,
                            `recommended_crop=${encodeURIComponent(crop)}`,
                            `recommendation_note=${encodeURIComponent(desc)}`
                        ].join('&');
                        await fetch('save_soil_test.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: body
                        });
                    } catch (err) {
                        console.warn('Soil test not saved to DB (offline?):', err);
                    }
                }, 1200);
            };
        }
    </script>
</body>

</html>