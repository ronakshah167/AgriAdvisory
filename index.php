<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="AgriAdvisory Hub — Smart farming assistant for crop recommendations, farm registration, and agricultural products.">
  <title>AgriAdvisory Hub — Smart Farming Assistant</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <nav>
    <a href="index.php" class="active">Home</a>
    <a href="register.php">Register</a>
    <a href="login.php">Login</a>
    <a href="products.php">Products</a>
    <a href="advisory.php">Advisory</a>
    <a href="weather.php">Weather</a>
    <a href="soil.php">Soil Test</a>
    <a href="checkout.php">Cart</a>
    <a href="feedback.php">Feedback</a>
    <a href="privacy.php">Privacy</a>
  </nav>

  <header style="padding: 0; text-align: left;" class="hero-split">
    <div class="hero-text">
      <span
        style="display:inline-block; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:var(--accent-secondary); margin-bottom:16px;">🌾
        AgriAdvisory Hub</span>
      <h1 style="font-size: clamp(2rem, 4.5vw, 3rem);">From Soil to Harvest,<br>We've Got You Covered.</h1>
      <p style="margin-top:14px; color:var(--text-secondary); max-width:480px; font-size:1.05rem; line-height:1.7;">
        Empowering India's farmers with data-driven crop intelligence and a trusted agricultural marketplace.</p>
      <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 32px;">
        <button onclick="location.href='soil.php'" style="padding: 13px 30px; font-size: 0.95rem;">
          Start Soil Test
        </button>
        <a href="products.php"
          style="padding: 13px 30px; text-decoration: none; color: var(--accent-primary); border: 1px solid var(--accent-primary); border-radius: var(--radius-sm); font-weight: 600; font-size: 0.9rem; transition: 0.2s; display:inline-flex; align-items:center;">
          Shop Marketplace
        </a>
      </div>
    </div>
    <div class="hero-image">
      <img src="images/farm_hero.png" alt="Lush green paddy fields at golden hour">
    </div>
  </header>

  <!-- THE FARMER JOURNEY -->
  <div class="section" style="background: none; border: none; box-shadow: none; padding: 0 20px;">
    <h2 style="justify-content: center; font-size: 1.5rem; opacity: 0.85; margin-bottom: 32px;">
      The Harvest Cycle</h2>
    <div class="features" style="gap: 10px;">
      <div style="text-align: center; flex: 1; padding: 16px; border-radius: 10px;">
        <span style="font-size: 1.4rem; display: block; margin-bottom: 10px;">🌱</span>
        <h4 style="color: var(--accent-primary); margin-bottom: 6px; font-size: 0.95rem;">Analysis</h4>
        <p style="font-size: 0.82rem; color: var(--text-muted);">Predict crops through soil testing</p>
      </div>
      <div style="text-align: center; flex: 0.3; opacity: 0.2; color: var(--text-muted);">→</div>
      <div style="text-align: center; flex: 1; padding: 16px; border-radius: 10px;">
        <span style="font-size: 1.4rem; display: block; margin-bottom: 10px;">🛒</span>
        <h4 style="color: var(--accent-primary); margin-bottom: 6px; font-size: 0.95rem;">Sourcing</h4>
        <p style="font-size: 0.82rem; color: var(--text-muted);">Get quality seeds &amp; fertilizers</p>
      </div>
      <div style="text-align: center; flex: 0.3; opacity: 0.2; color: var(--text-muted);">→</div>
      <div style="text-align: center; flex: 1; padding: 16px; border-radius: 10px;">
        <span style="font-size: 1.4rem; display: block; margin-bottom: 10px;">☀️</span>
        <h4 style="color: var(--accent-primary); margin-bottom: 6px; font-size: 0.95rem;">Monitoring</h4>
        <p style="font-size: 0.82rem; color: var(--text-muted);">Follow live weather advisory</p>
      </div>
    </div>
  </div>

  <div class="section" style="margin-top: 48px;">
    <h2 style="margin-bottom: 8px;">Platform Features</h2>
    <p style="margin-bottom: 32px;">Tools built to maximize yield and minimize chemical risk.</p>

    <div class="features">
      <div class="feature-card" onclick="location.href='soil.php'" style="cursor: pointer;">
        <div class="feature-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2v20" />
            <path d="m5 10 7 7 7-7" />
          </svg>
        </div>
        <h3>Soil Chemistry</h3>
        <p>Soil-to-seed matching for balanced farm nutrition.</p>
        <span
          style="font-size: 0.78rem; color: var(--accent-primary); font-weight: 600; margin-top: 12px; display: block;">Test
          now →</span>
      </div>

      <div class="feature-card" onclick="location.href='weather.php'" style="cursor: pointer;">
        <div class="feature-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2a10 10 0 0 1 10 10" />
            <path d="M2 12C2 6.48 6.48 2 12 2" />
            <path d="M7 20.7a10 10 0 0 0 10-17.4" />
          </svg>
        </div>
        <h3>Weather Station</h3>
        <p>Plan irrigation and fertilizer application cycles.</p>
        <span
          style="font-size: 0.78rem; color: var(--accent-primary); font-weight: 600; margin-top: 12px; display: block;">Check
          weather →</span>
      </div>

      <div class="feature-card" onclick="location.href='products.php'" style="cursor: pointer;">
        <div class="feature-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1" />
            <circle cx="20" cy="21" r="1" />
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
          </svg>
        </div>
        <h3>Marketplace</h3>
        <p>Seeds, fertilizers, and tools from verified suppliers.</p>
        <span
          style="font-size: 0.78rem; color: var(--accent-primary); font-weight: 600; margin-top: 12px; display: block;">Browse
          shop →</span>
      </div>

      <div class="feature-card" onclick="location.href='advisory.php'" style="cursor: pointer;">
        <div class="feature-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
            <circle cx="9" cy="7" r="4" />
          </svg>
        </div>
        <h3>Expert Access</h3>
        <p>Connect with agricultural scientists for crop consultations.</p>
        <span
          style="font-size: 0.78rem; color: var(--accent-primary); font-weight: 600; margin-top: 12px; display: block;">Talk
          to expert →</span>
      </div>
    </div>
  </div>

  <div class="section" style="border-top: 3px solid var(--accent-earth); padding: 40px 32px;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 36px; align-items: center;">
      <div>
        <h2 style="font-size: 1.6rem; color: var(--text-primary);">Protect Your Livelihood</h2>
        <p style="margin-top: 12px; color: var(--text-secondary); line-height: 1.7;">Our expert scientists analyze soil
          chemistries and satellite weather data to ensure your farm stays productive, regardless of shifting monsoon
          patterns.</p>
        <button onclick="location.href='register.php'" style="margin-top: 20px; padding: 12px 32px;">Register Your
          Farm</button>
      </div>
      <div>
        <div
          style="background: var(--bg-primary); border-radius: var(--radius-md); padding: 24px; border: 1px solid var(--border-color);">
          <div style="color: var(--accent-earth); font-size: 1.6rem; margin-bottom: 14px;">"</div>
          <p style="font-style: italic; font-size: 1rem; color: var(--text-primary); line-height: 1.6;">"Ever since
            using the soil test recommendations, our paddy yield has increased by nearly 30% while reducing fertilizer
            costs by half."</p>
          <div style="margin-top: 18px; display: flex; align-items: center; gap: 10px;">
            <div
              style="width: 36px; height: 36px; border-radius: 50%; background: var(--accent-primary); display:flex; align-items:center; justify-content:center; color: #fff; font-weight:600; font-size: 0.8rem;">
              RS</div>
            <div>
              <div style="font-weight: 600; font-size: 0.88rem;">Rahul S.</div>
              <div style="font-size: 0.72rem; color: var(--text-muted);">Maharashtra, India</div>
            </div>
          </div>
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

</body>

</html>