// Initialize cart from localStorage
let cart = JSON.parse(localStorage.getItem("cart")) || [];

/* ============================================================
   COOKIE UTILITY FUNCTIONS
   setCookie / getCookie / deleteCookie — used across features
   ============================================================ */
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function getCookie(name) {
    const nameEQ = name + "=";
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        let c = cookies[i].trim();
        if (c.indexOf(nameEQ) === 0) {
            return decodeURIComponent(c.substring(nameEQ.length));
        }
    }
    return null;
}

function deleteCookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
}

/* ============================================================
   COOKIE CONSENT BANNER
   Shows on first visit. Stores preference for 365 days.
   ============================================================ */
(function initCookieConsent() {
    const consent = getCookie("cookieConsent");

    // If user already responded, don't show banner
    if (consent) return;

    const banner = document.createElement("div");
    banner.className = "cookie-banner";
    banner.id = "cookie-consent-banner";
    banner.innerHTML = `
        <span class="cookie-banner__icon">🍪</span>
        <div class="cookie-banner__text">
            <p><strong>We use cookies</strong> to remember your preferences, keep you logged in,
            and improve your experience on AgriAdvisory Hub. No third-party tracking — just farm-friendly essentials.</p>
        </div>
        <div class="cookie-banner__actions">
            <button class="cookie-btn-accept" id="cookie-accept">Accept All</button>
            <button class="cookie-btn-decline" id="cookie-decline">Decline</button>
        </div>
    `;
    document.body.appendChild(banner);

    document.getElementById("cookie-accept").addEventListener("click", function () {
        setCookie("cookieConsent", "accepted", 365);
        dismissBanner();
    });

    document.getElementById("cookie-decline").addEventListener("click", function () {
        setCookie("cookieConsent", "declined", 30);
        dismissBanner();
        // If declined, clear any existing farmer name cookie
        deleteCookie("farmerName");
    });

    function dismissBanner() {
        banner.classList.add("hiding");
        setTimeout(() => banner.remove(), 450);
    }
})();

/* ============================================================
   WELCOME BACK BAR
   Reads "farmerName" cookie (set after registration).
   Displays a personalized greeting bar below the navbar.
   ============================================================ */
(function initWelcomeBar() {
    const farmerName = getCookie("farmerName");
    const consent = getCookie("cookieConsent");

    // Only show if cookies were accepted AND farmer name exists
    if (!farmerName || consent !== "accepted") return;

    const nav = document.querySelector("nav");
    if (!nav) return;

    const bar = document.createElement("div");
    bar.className = "welcome-bar";
    bar.id = "welcome-bar";
    bar.innerHTML = `
        <span>🌾</span>
        <span>Welcome back, <span class="welcome-bar__name">${farmerName}</span>! Ready to grow?</span>
        <button class="welcome-bar__dismiss" title="Dismiss" onclick="dismissWelcomeBar()">✕</button>
    `;
    nav.insertAdjacentElement("afterend", bar);
})();

function dismissWelcomeBar() {
    const bar = document.getElementById("welcome-bar");
    if (bar) {
        bar.style.opacity = "0";
        bar.style.transform = "translateY(-10px)";
        bar.style.transition = "0.3s ease";
        setTimeout(() => bar.remove(), 300);
    }
}
window.dismissWelcomeBar = dismissWelcomeBar;

// Update navbar for logged in state
(function updateNav() {
    const farmerName = getCookie("farmerName");
    const nav = document.querySelector("nav");
    if (farmerName && nav) {
        const loginLink = Array.from(nav.querySelectorAll("a")).find(a => a.innerText.toLowerCase().includes("login"));
        if (loginLink) {
            loginLink.innerHTML = `Logout (${farmerName.split(' ')[0]})`;
            loginLink.href = "javascript:logout()";
        }
    }
})();


// Static product catalogue — shown when the database has no entries
const STATIC_PRODUCTS = [
    {
        id: 1,
        name: "Premium Paddy Seeds (1 kg)",
        price: 249,
        image: "images/seeds_paddy.png",
        description: "High-yield HYV paddy seeds suitable for Kharif season."
    },
    {
        id: 2,
        name: "NPK Fertilizer 5 kg Bag",
        price: 595,
        image: "images/fertilizer_npk.png",
        description: "Balanced 19-19-19 granulated fertilizer for all crops."
    },
    {
        id: 3,
        name: "Stainless Steel Hand Tool Set",
        price: 385,
        image: "images/garden_tools.png",
        description: "Trowel and cultivator set with hardwood handles."
    },
    {
        id: 4,
        name: "Knapsack Sprayer 16 L",
        price: 990,
        image: "images/sprayer_pump.png",
        description: "HDPE backpack sprayer with adjustable brass nozzle."
    },
    {
        id: 5,
        name: "Drip Irrigation Kit (50 plants)",
        price: 1250,
        image: "images/drip_irrigation.png",
        description: "Complete drip kit — mainline, emitters and connectors."
    },
    {
        id: 6,
        name: "Digital Soil pH and Moisture Tester",
        price: 749,
        image: "images/soil_tester.png",
        description: "Instant-read dual meter for soil pH and moisture levels."
    }
];

/* ============================================================
   TOAST NOTIFICATION
   Replaces native alert() with a styled floating notification
   ============================================================ */
function showToast(message) {
    let toast = document.querySelector('.toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.className = 'toast';
        document.body.appendChild(toast);
    }

    toast.innerText = message;
    toast.style.display = 'block';
    toast.style.opacity = '1';
    toast.style.transform = 'translateY(0) scale(1)';

    clearTimeout(toast._hideTimeout);
    toast._hideTimeout = setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px) scale(0.9)';
        setTimeout(() => {
            toast.style.display = 'none';
        }, 400);
    }, 3000);
}

/* ============================================================
   FARMER REGISTRATION
   ============================================================ */
const registrationForm = document.getElementById("form");

if (registrationForm) {
    registrationForm.onsubmit = async function (e) {
        e.preventDefault();

        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const pass = document.getElementById("pass").value;
        const address = document.getElementById("address").value.trim();
        const land = document.getElementById("land").value;
        const service = document.getElementById("service").value;

        // Client-side validation
        if (name.length < 3) {
            showToast("Please enter a valid full name (min 3 characters).");
            return;
        }
        if (pass.length < 8) {
            showToast("Password must be at least 8 characters.");
            return;
        }

        // Loading state
        const btn = registrationForm.querySelector('button[type="submit"]');
        const originalText = btn.innerText;
        btn.innerText = "Registering...";
        btn.disabled = true;

        try {
            const response = await fetch("register.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: [
                    `fullname=${encodeURIComponent(name)}`,
                    `email=${encodeURIComponent(email)}`,
                    `phone=${encodeURIComponent(phone)}`,
                    `password=${encodeURIComponent(pass)}`,
                    `address=${encodeURIComponent(address)}`,
                    `land=${encodeURIComponent(land)}`,
                    `service=${encodeURIComponent(service)}`
                ].join("&")
            });

            const result = await response.text();
            const msgEl = document.getElementById("msg");

            if (result.includes("Success")) {
                msgEl.innerText = "Registration successful! Welcome to AgriAdvisory Hub.";
                registrationForm.reset();
                showToast("Account created successfully.");

                // Save farmer name + id cookies (30-day expiry) for welcome-back greeting
                if (getCookie("cookieConsent") === "accepted") {
                    setCookie("farmerName", name, 30);
                    // farmer_id comes back in a separate header or we auto-login;
                    // for registration we keep it minimal and redirect to login
                }
                setTimeout(() => location.href = "login.html", 1800);
            } else {
                msgEl.innerText = "Registration failed. Please try again.";
                showToast("Error during registration. Please try again.");
            }
        } catch (error) {
            showToast("Network error. Please check your connection.");
        } finally {
            btn.innerText = originalText;
            btn.disabled = false;
        }
    };
}

/* ============================================================
   FARMER LOGIN
   ============================================================ */
const loginForm = document.getElementById("login-form");

if (loginForm) {
    loginForm.onsubmit = async function (e) {
        e.preventDefault();

        const email = document.getElementById("login-email").value.trim();
        const pass = document.getElementById("login-pass").value;
        const remember = document.getElementById("remember-me").checked;

        // Loading state
        const btn = loginForm.querySelector('button[type="submit"]');
        const originalText = btn.innerText;
        btn.innerText = "Signing In...";
        btn.disabled = true;

        try {
            const formData = new FormData();
            formData.append("email", email);
            formData.append("password", pass);

            const response = await fetch("login.php", {
                method: "POST",
                body: formData
            });

            const result = await response.json();
            const msgEl = document.getElementById("msg");

            if (result.status === "success") {
                showToast("Welcome back, " + result.name + "!");

                // Save identification cookies
                if (getCookie("cookieConsent") === "accepted" || remember) {
                    setCookie("farmerName", result.name, remember ? 30 : 1);
                    // Store farmer_id for DB-connected features
                    if (result.farmer_id) {
                        setCookie("farmerId", result.farmer_id, remember ? 30 : 1);
                    }
                }

                // Redirect after a short delay
                setTimeout(() => {
                    location.href = "index.html";
                }, 1500);
            } else {
                msgEl.innerText = result.message;
                showToast(result.message);
            }
        } catch (error) {
            showToast("Login failed. Please check your credentials.");
        } finally {
            btn.innerText = originalText;
            btn.disabled = false;
        }
    };
}

/* ============================================================
   PRIVACY SETTINGS
   ============================================================ */
const privacyForm = document.getElementById("privacy-form");

if (privacyForm) {
    // Load existing settings from localStorage
    const savedSettings = JSON.parse(localStorage.getItem("privacySettings")) || {
        shareSoil: true,
        weatherSMS: true,
        storeCookies: true
    };

    document.getElementById("share-soil").checked = savedSettings.shareSoil;
    document.getElementById("weather-sms").checked = savedSettings.weatherSMS;
    document.getElementById("store-cookies").checked = savedSettings.storeCookies;

    privacyForm.onsubmit = async function (e) {
        e.preventDefault();

        const settings = {
            shareSoil: document.getElementById("share-soil").checked,
            weatherSMS: document.getElementById("weather-sms").checked,
            storeCookies: document.getElementById("store-cookies").checked
        };

        // Save locally
        localStorage.setItem("privacySettings", JSON.stringify(settings));

        if (!settings.storeCookies) {
            deleteCookie("farmerName");
            deleteCookie("farmerId");
            setCookie("cookieConsent", "declined", 30);
        }

        // Persist to database if logged in
        const farmerId = getCookie("farmerId");
        if (farmerId) {
            try {
                const body = [
                    `farmer_id=${encodeURIComponent(farmerId)}`,
                    `share_soil=${settings.shareSoil ? 'on' : ''}`,
                    `weather_sms=${settings.weatherSMS ? 'on' : ''}`,
                    `store_cookies=${settings.storeCookies ? 'on' : ''}`
                ].join('&');
                await fetch('save_privacy.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: body
                });
            } catch (err) {
                console.warn('Privacy sync to DB failed (offline?):', err);
            }
        }

        const msg = document.getElementById("privacy-msg");
        msg.innerText = "Privacy settings updated successfully!";
        showToast("Settings Saved.");

        setTimeout(() => msg.innerText = "", 3000);
    };
}

const deleteDataBtn = document.getElementById("delete-data-btn");
if (deleteDataBtn) {
    deleteDataBtn.onclick = function () {
        if (confirm("Are you sure? This will delete your local settings and log you out.")) {
            localStorage.clear();
            deleteCookie("farmerName");
            deleteCookie("cookieConsent");
            showToast("All data cleared.");
            setTimeout(() => location.href = "index.html", 1000);
        }
    };
}

/* ============================================================
   LOGOUT FUNCTIONALITY
   ============================================================ */
function logout() {
    deleteCookie("farmerName");
    // Optionally call a logout.php to destroy server session
    showToast("Logged out successfully.");
    setTimeout(() => {
        location.href = "login.html";
    }, 1000);
}
window.logout = logout;

/* ============================================================
   PRODUCTS — fetch from DB, fall back to static catalogue
   ============================================================ */
const prodList = document.getElementById("products");
const productsEmptyState = document.getElementById("products-empty");

if (prodList) {
    // Attempt to fetch from database, fall back to static catalogue if needed
    (async () => {
        try {
            const response = await fetch("get_products.php");
            const data = await response.json();

            if (data && data.length > 0) {
                renderProducts(data);
            } else {
                renderProducts(STATIC_PRODUCTS);
            }
        } catch (error) {
            console.error("Database fetch failed, using static catalogue:", error);
            renderProducts(STATIC_PRODUCTS);
        }
    })();
}

function renderProducts(products) {
    prodList.innerHTML = "";

    if (!products || products.length === 0) {
        if (productsEmptyState) productsEmptyState.style.display = 'block';
        return;
    }

    if (productsEmptyState) productsEmptyState.style.display = 'none';

    products.forEach((p, index) => {
        const li = document.createElement("li");
        li.style.animationDelay = `${index * 0.1}s`;
        li.innerHTML = `
            <img src="${p.image || 'images/seeds_paddy.png'}" alt="${p.name}">
            <div style="width: 100%; text-align: left; padding: 0 4px;">
                <h4 style="margin: 0 0 4px; font-size: 1rem; color: var(--text-primary); line-height: 1.4;">${p.name}</h4>
                <p style="margin: 0 0 6px; font-size: 0.82rem; color: var(--text-muted); line-height: 1.4;">${p.description || ""}</p>
                <div style="color: var(--accent-primary); font-weight: 700; font-size: 1.05rem;">Rs. ${p.price}</div>
            </div>
            <button onclick="addToCart('${p.name.replace(/'/g, "\\'")}', ${p.price})" style="width: 100%; margin-top: 4px;">Add to Cart</button>
        `;
        prodList.appendChild(li);
    });
}

/* ============================================================
   ADD TO CART
   ============================================================ */
function addToCart(name, price) {
    cart.push({ name, price });
    localStorage.setItem("cart", JSON.stringify(cart));
    showToast(`${name} added to cart.`);
}

/* ============================================================
   CART PAGE
   ============================================================ */
const cartUI = document.getElementById("cart");
const totalUI = document.getElementById("total");
const cartEmptyState = document.getElementById("cart-empty");

if (cartUI) {
    renderCart();
}

function renderCart() {
    cartUI.innerHTML = "";
    let total = 0;

    if (cart.length === 0) {
        if (cartEmptyState) cartEmptyState.style.display = 'block';
        const layout = document.getElementById('checkout-layout');
        if (layout) layout.style.display = 'none';
        if (totalUI) totalUI.style.display = 'none';
        return;
    }

    if (cartEmptyState) cartEmptyState.style.display = 'none';
    const layout = document.getElementById('checkout-layout');
    if (layout) layout.style.display = 'grid';
    if (totalUI) totalUI.style.display = 'block';

    cart.forEach((item, index) => {
        total += Number(item.price);

        const li = document.createElement("li");
        li.innerHTML = `
            <div>
                <span style="display: block; font-size: 0.95rem; color: var(--text-primary); font-weight: 500;">${item.name}</span>
                <span style="font-size: 0.9rem; color: var(--accent-primary); font-weight: 600;">Rs. ${item.price}</span>
            </div>
            <button class="btn-danger" onclick="removeFromCart(${index})">Remove</button>
        `;
        cartUI.appendChild(li);
    });

    if (totalUI) totalUI.innerText = "Total: Rs. " + total;
}

/* ============================================================
   REMOVE FROM CART
   ============================================================ */
function removeFromCart(index) {
    const itemName = cart[index].name;
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCart();
    showToast(`Removed "${itemName}" from cart.`);
}

// Expose to global scope for inline onclick handlers
window.addToCart = addToCart;
window.removeFromCart = removeFromCart;

/* ============================================================
   PLACE ORDER — submits cart + delivery details to place_order.php
   ============================================================ */
const orderForm = document.getElementById("order-form");

if (orderForm) {
    orderForm.onsubmit = async function (e) {
        e.preventDefault();

        if (cart.length === 0) {
            showToast("Your cart is empty.");
            return;
        }

        const custName = document.getElementById("cust-name").value.trim();
        const custPhone = document.getElementById("cust-phone").value.trim();
        const custAddress = document.getElementById("cust-address").value.trim();
        const payMode = document.getElementById("payment-mode").value;

        if (custName.length < 2) {
            showToast("Please enter your full name.");
            return;
        }
        if (custPhone.length < 6) {
            showToast("Please enter a valid phone number.");
            return;
        }

        const btn = document.getElementById("place-order-btn");
        const originalText = btn.innerText;
        btn.innerText = "Placing Order...";
        btn.disabled = true;

        const total = cart.reduce((sum, item) => sum + Number(item.price), 0);
        const itemsJSON = JSON.stringify(cart.map(i => ({ name: i.name, price: i.price })));
        const farmerId = getCookie("farmerId") || '';

        try {
            const res = await fetch("place_order.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: [
                    `customer_name=${encodeURIComponent(custName)}`,
                    `phone=${encodeURIComponent(custPhone)}`,
                    `address=${encodeURIComponent(custAddress)}`,
                    `items=${encodeURIComponent(itemsJSON)}`,
                    `total=${total}`,
                    `payment_mode=${encodeURIComponent(payMode)}`,
                    `farmer_id=${encodeURIComponent(farmerId)}`
                ].join("&")
            });

            const result = await res.json();

            if (result.status === "success") {
                // Clear cart
                cart = [];
                localStorage.removeItem("cart");

                // Hide checkout panels, show success
                const layout = document.getElementById("checkout-layout");
                if (layout) layout.style.display = "none";

                const successPanel = document.getElementById("order-success");
                if (successPanel) successPanel.style.display = "block";

                const refEl = document.getElementById("order-ref");
                if (refEl) refEl.innerText = `Order ID: #${result.order_id}`;

                showToast("Order placed successfully!");
            } else {
                const msgEl = document.getElementById("order-msg");
                if (msgEl) msgEl.innerText = result.message || "Something went wrong. Please try again.";
                showToast(result.message || "Order failed. Please try again.");
                btn.innerText = originalText;
                btn.disabled = false;
            }
        } catch (err) {
            showToast("Network error. Please check your connection.");
            btn.innerText = originalText;
            btn.disabled = false;
        }
    };
}

/* ============================================================
   SOIL-BASED RECOMMENDATIONS — mock tool logic
   ============================================================ */
const soilForm = document.getElementById("soil-calc-form");
const soilResult = document.getElementById("soil-result-panel");

if (soilForm) {
    soilForm.onsubmit = function (e) {
        e.preventDefault();

        const type = document.getElementById("soil-type").value;
        const ph = parseFloat(document.getElementById("soil-ph").value) || 6.5;

        let crop = "Paddy (Rice)";
        let desc = "Ideal for alluvial loamy soils with high moisture retention and neutral pH.";
        let icon = `<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m16 6-4 4-4-4"/><path d="M12 2v8"/><path d="m20 12-8 8-8-8"/></svg>`;

        if (type === "black") {
            crop = "Cotton / Soybean";
            desc = "Black soil (Regur) is rich in clay and moisture, perfect for cotton and soybean crops.";
            icon = `<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>`;
        } else if (type === "red") {
            crop = "Pulses / Tobacco";
            desc = "Red soils are porous and friable. Ideal for pulses with proper irrigation and fertilization.";
            icon = `<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="m5 10 7 7 7-7"/></svg>`;
        } else if (type === "laterite") {
            crop = "Tea / Coffee / Cashew";
            desc = "Laterite soil is acidic and suited for plantation crops like tea and cashews.";
            icon = `<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a2 2 0 1 1-4 0 2 2 0 1 1 4 0Z"/><path d="M10 8a2 2 0 1 1-4 0 2 2 0 1 1 4 0Z"/><path d="M7 16a2 2 0 1 0 4 0 2 2 0 1 0-4 0Z"/><path d="M13 16a2 2 0 1 0 4 0 2 2 0 1 0-4 0Z"/></svg>`;
        } else if (type === "desert") {
            crop = "Millets / Barley";
            desc = "Sandy soils have low water retention. Millets and barley are resilient choices.";
            icon = `<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M21 12H3"/></svg>`;
        }

        // Adjust for pH
        if (ph < 5.5) {
            desc += " Warning: Soil is acidic. Apply lime before sowing.";
            crop = "Potatoes / Oats (Acid Tolerant)";
        } else if (ph > 7.5) {
            desc += " Warning: Soil is alkaline. Consider sulfur application.";
            crop = "Barley / Asparagus (Alkali Tolerant)";
        }

        document.getElementById("soil-result-title").innerText = "Recommended: " + crop;
        document.getElementById("soil-result-desc").innerText = desc;
        document.getElementById("soil-result-icon").innerHTML = icon;

        soilResult.style.display = "block";
        soilResult.scrollIntoView({ behavior: 'smooth', block: 'center' });
        showToast("Recommendation generated for " + crop);
    };
}