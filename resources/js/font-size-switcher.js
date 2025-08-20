document.addEventListener('DOMContentLoaded', function() {
    initializeFontSizeSwitcher();
    
    // Listen for Livewire updates to re-initialize if needed
    document.addEventListener('livewire:navigated', function() {
        initializeFontSizeSwitcher();
    });
});

function initializeFontSizeSwitcher() {
    const fontSizeControl = document.querySelector('.filament-font-size-switcher');
    if (!fontSizeControl) return;
    
    const buttons = fontSizeControl.querySelectorAll('.filament-font-size-btn');
    const STORAGE_KEY = 'filament-font-size';
    
    // Load saved font size
    const savedFontSize = localStorage.getItem(STORAGE_KEY) || getDefaultSize();
    applyFontSize(savedFontSize);
    updateActiveButton(savedFontSize);
    
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const size = this.dataset.size;
            const multiplier = parseFloat(this.dataset.multiplier);
            
            applyFontSize(size);
            updateActiveButton(size);
            localStorage.setItem(STORAGE_KEY, size);
            
            // Optional: Dispatch event for other components to listen
            window.dispatchEvent(new CustomEvent('filament-font-size-changed', {
                detail: { size, multiplier }
            }));
        });
    });
    
    function applyFontSize(size) {
        // Remove all existing font size classes
        document.body.classList.remove(
            'filament-font-xs', 
            'filament-font-sm', 
            'filament-font-md', 
            'filament-font-lg', 
            'filament-font-xl'
        );
        
        // Add the new font size class
        document.body.classList.add(`filament-font-${size}`);
        
        // Store current size for reference
        document.body.setAttribute('data-font-size', size);
    }
    
    function updateActiveButton(size) {
        buttons.forEach(btn => btn.classList.remove('active'));
        const activeBtn = fontSizeControl.querySelector(`[data-size="${size}"]`);
        if (activeBtn) {
            activeBtn.classList.add('active');
        }
    }
    
    function getDefaultSize() {
        // Try to get default from first active button or fallback to 'md'
        const activeBtn = fontSizeControl.querySelector('.active');
        return activeBtn ? activeBtn.dataset.size : 'md';
    }
}
