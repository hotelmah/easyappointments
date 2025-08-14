// JavaScript Document

window.App.Utils.Currency = (function () {
    /**
    * Format service price with appropriate currency symbol and formatting.
    *
    * @param {number|string} price - The price value
    * @param {string} currency - The currency code (e.g., 'USD', 'EUR', 'GBP')
    * @param {string} [locale] - Optional locale for formatting (defaults to browser locale)
    * @return {string} Formatted price with currency symbol
    */
    function formatServicePrice(price, currency, locale = null) {
        // Convert price to number if it's a string
        const numericPrice = parseFloat(price);

        // Handle invalid price
        if (isNaN(numericPrice)) {
            return currency ? `0 ${currency}` : '0';
        }

        // Handle missing currency
        if (!currency || currency.trim() === '') {
            return numericPrice.toFixed(2);
        }

        if (numericPrice === 0.00) {
            return 'Free'; // Special case for free services
        }

        // Get the current locale (from browser or provided)
        const currentLocale = locale ||
                            vars('locale') ||
                            navigator.language ||
                            'en-US';

        try {
            // Use Intl.NumberFormat for proper currency formatting
            const formatter = new Intl.NumberFormat(currentLocale, {
                style: 'currency',
                currency: currency.toUpperCase(),
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            return formatter.format(numericPrice);
        } catch (error) {
            // Fallback for unsupported currencies or locales
            return fallbackCurrencyFormat(numericPrice, currency);
        }
    }

    /**
    * Fallback currency formatting for unsupported currencies.
    *
    * @param {number} price - The numeric price
    * @param {string} currency - The currency code
    * @return {string} Formatted price with symbol
    */
    function fallbackCurrencyFormat(price, currency) {
        // Common currency symbols mapping
        const currencySymbols = {
            'USD': '$',
            'EUR': '€',
            'GBP': '£',
            'JPY': '¥',
            'CAD': 'C$',
            'AUD': 'A$',
            'CHF': 'CHF',
            'CNY': '¥',
            'SEK': 'kr',
            'NOK': 'kr',
            'MXN': '$',
            'INR': '₹',
            'BRL': 'R$',
            'KRW': '₩',
            'SGD': 'S$',
            'NZD': 'NZ$',
            'ZAR': 'R',
            'HKD': 'HK$',
            'TRY': '₺',
            'RUB': '₽',
            'PLN': 'zł',
            'CZK': 'Kč',
            'DKK': 'kr',
            'HUF': 'Ft',
            'ILS': '₪',
            'CLP': '$',
            'PHP': '₱',
            'AED': 'د.إ',
            'SAR': '﷼',
            'THB': '฿'
        };

        const symbol = currencySymbols[currency.toUpperCase()] || currency;
        const formattedPrice = price.toFixed(2);

        // For most currencies, symbol goes before the amount
        // Exception: some European currencies go after
        const symbolAfter = ['SEK', 'NOK', 'DKK', 'PLN', 'CZK', 'HUF'].includes(currency.toUpperCase());

        return symbolAfter ?
            `${formattedPrice} ${symbol}` :
            `${symbol}${formattedPrice}`;
    }

    return {
        formatServicePrice
    };
})();