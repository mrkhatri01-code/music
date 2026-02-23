/**
 * Auto-transliteration script using Google Input Tools API
 * Handles conversion from English to Nepali for Admin Forms
 */

// Transliterate function
async function transliterate(text, targetElement) {
    if (!text || !text.trim()) return;

    try {
        const response = await fetch(
            `https://inputtools.google.com/request?text=${encodeURIComponent(text)}&itc=ne-t-i0-und&num=1&cp=0&cs=1&ie=utf-8&oe=utf-8&app=demopage`
        );
        const data = await response.json();

        if (data && data[0] === 'SUCCESS') {
            const result = data[1][0][1][0];
            if (result && targetElement) {
                targetElement.value = result;
            }
        }
    } catch (error) {
        console.error('Transliteration failed:', error);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Configuration for fields to watch
    // sourceId: ID of the English input field
    // targetId: ID of the Nepali input field
    const fields = [
        { source: 'name_english', target: 'name_nepali' },   // Artists
        { source: 'title_english', target: 'title_nepali' }  // Songs
    ];

    fields.forEach(field => {
        const sourceInput = document.getElementById(field.source);
        const targetInput = document.getElementById(field.target);

        if (sourceInput && targetInput) {
            sourceInput.addEventListener('blur', function () {
                // Only auto-fill if target is empty to avoid overwriting manual corrections
                if (targetInput.value.trim() === '') {
                    transliterate(sourceInput.value, targetInput);
                }
            });
        }
    });
});
