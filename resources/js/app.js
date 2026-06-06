// public/js/app.js

console.log("Floral Shop Loaded");

document.addEventListener('DOMContentLoaded', function () {
    initCurrency();
});

function initCurrency() {
    let currentCurrency = localStorage.getItem('currency') || 'VND';
    updateCurrencyUI(currentCurrency);
    if (currentCurrency === 'USD') {
        applyUSDExchange();
    }
}

function changeCurrency(currency) {
    localStorage.setItem('currency', currency);
    location.reload(); // Reload page to apply changes cleanly across all elements
}

function updateCurrencyUI(currency) {
    let label = document.getElementById('currentCurrencyLabel');
    if (label) {
        label.textContent = currency === 'USD' ? 'USD ($)' : 'VND (đ)';
    }
}

function applyUSDExchange() {
    let rate = localStorage.getItem('usd_rate');
    let rateTime = localStorage.getItem('usd_rate_time');
    let now = new Date().getTime();

    // Cache rate for 1 hour (3600000 ms) in localStorage
    if (rate && rateTime && (now - rateTime < 3600000)) {
        convertPrices(parseFloat(rate));
    } else {
        axios.get('/api/exchange-rate')
            .then(response => {
                let usdRate = response.data.usd_rate;
                localStorage.setItem('usd_rate', usdRate);
                localStorage.setItem('usd_rate_time', now);
                convertPrices(usdRate);
            })
            .catch(error => {
                console.error("Failed to fetch exchange rate, using fallback", error);
                convertPrices(0.000041); // Fallback: 1 USD = 24,400 VND
            });
    }
}

// Convert prices
function convertPrices(rate) {
    let priceElements = document.querySelectorAll('.price-amount');
    priceElements.forEach(el => {
        let vndVal = parseFloat(el.getAttribute('data-vnd') || el.getAttribute('data-price'));
        if (!isNaN(vndVal)) {
            let usdVal = vndVal * rate;
            el.textContent = '$' + usdVal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
    });
}