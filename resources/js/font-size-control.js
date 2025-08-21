document.addEventListener('DOMContentLoaded', function() {
    const fontSizeControl = document.querySelector('.font-size-control');
    if (!fontSizeControl) return;
    
    const buttons = fontSizeControl.querySelectorAll('.font-size-btn');
    
    // Default Filament font sizes (in rem)
    const defaultFontSizes = {
        'text-xs': 0.75,
        'text-sm': 0.875,
        'text-base': 1,
        'text-lg': 1.125,
        'text-xl': 1.25,
        'text-2xl': 1.5,
        'text-3xl': 1.875
    };
    
    // Default line heights
    const defaultLineHeights = {
        'text-xs': 1 / 0.75,
        'text-sm': 1.25 / 0.875,
        'text-base': 1.5,
        'text-lg': 1.75 / 1.125,
        'text-xl': 1.75 / 1.25,
        'text-2xl': 2 / 1.5,
        'text-3xl': 1.2
    };
    
    // Load saved font size
    const savedFontSize = localStorage.getItem('filament-font-size') || getDefaultSize();
    const savedMultiplier = parseFloat(localStorage.getItem('filament-font-multiplier') || '1');
    applyFontSize(savedFontSize, savedMultiplier);
    updateActiveButton(savedFontSize);
    
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const size = this.dataset.size;
            const multiplier = parseFloat(this.dataset.multiplier);
            applyFontSize(size, multiplier);
            updateActiveButton(size);
            localStorage.setItem('filament-font-size', size);
            localStorage.setItem('filament-font-multiplier', multiplier);
        });
    });
    
    function applyFontSize(size, multiplier) {
        const root = document.documentElement;
        
        // Apply the multiplier to all Filament text size custom properties
        Object.entries(defaultFontSizes).forEach(([property, baseSize]) => {
            const newSize = baseSize * multiplier;
            root.style.setProperty(`--${property}`, `${newSize}rem`);
        });
        
        // Apply the multiplier to line heights as well
        Object.entries(defaultLineHeights).forEach(([property, baseLineHeight]) => {
            const newLineHeight = baseLineHeight; // Keep line heights proportional
            root.style.setProperty(`--${property}--line-height`, newLineHeight);
        });
        
        // Store the current multiplier for reference
        root.style.setProperty('--font-scale-multiplier', multiplier);
    }
    
    function updateActiveButton(size) {
        buttons.forEach(btn => btn.classList.remove('active'));
        const activeBtn = fontSizeControl.querySelector(`[data-size="${size}"]`);
        if (activeBtn) {
            activeBtn.classList.add('active');
        }
    }

    function getDefaultSize() {
        const firstBtn = fontSizeControl.querySelector('.font-size-btn.active');
        return firstBtn ? firstBtn.dataset.size : 'normal';
    }
});
