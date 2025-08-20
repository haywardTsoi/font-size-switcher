<div class="filament-font-size-switcher">
    @foreach($fontSizes as $size => $multiplier)
        <button class="filament-font-size-btn {{ $size === $defaultSize ? 'active' : '' }}" 
                data-size="{{ $size }}" 
                data-multiplier="{{ $multiplier }}"
                type="button"
                title="Font Size: {{ ucfirst($size) }}">
            <span class="font-size-label">A</span>
        </button>
    @endforeach
</div>

@push('styles')
<style>
/* Filament Font Size Switcher Styles */
.filament-font-size-switcher {
    display: flex;
    gap: 4px;
    align-items: center;
    margin-left: 12px;
    padding: 4px;
    background: rgb(255 255 255 / 0.05);
    border-radius: 6px;
    border: 1px solid rgb(255 255 255 / 0.1);
}

.filament-font-size-btn {
    width: 32px;
    height: 32px;
    border: 1px solid rgb(255 255 255 / 0.1);
    background: rgb(255 255 255 / 0.05);
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    transition: all 0.15s ease;
    color: rgb(156 163 175);
    position: relative;
}

.filament-font-size-btn[data-size="xs"] .font-size-label {
    font-size: 10px;
}

.filament-font-size-btn[data-size="sm"] .font-size-label {
    font-size: 11px;
}

.filament-font-size-btn[data-size="md"] .font-size-label {
    font-size: 13px;
}

.filament-font-size-btn[data-size="lg"] .font-size-label {
    font-size: 15px;
}

.filament-font-size-btn[data-size="xl"] .font-size-label {
    font-size: 17px;
}

.filament-font-size-btn:hover {
    background: rgb(255 255 255 / 0.1);
    border-color: rgb(255 255 255 / 0.2);
    color: rgb(209 213 219);
}

.filament-font-size-btn.active {
    background: rgb(34 197 94);
    color: white;
    border-color: rgb(34 197 94);
}

/* Font size application classes */
.filament-font-xs {
    font-size: 0.8rem !important;
}

.filament-font-xs * {
    font-size: inherit !important;
}

.filament-font-sm {
    font-size: 0.875rem !important;
}

.filament-font-sm * {
    font-size: inherit !important;
}

.filament-font-md {
    font-size: 1rem !important;
}

.filament-font-md * {
    font-size: inherit !important;
}

.filament-font-lg {
    font-size: 1.125rem !important;
}

.filament-font-lg * {
    font-size: inherit !important;
}

.filament-font-xl {
    font-size: 1.25rem !important;
}

.filament-font-xl * {
    font-size: inherit !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .filament-font-size-switcher {
        gap: 2px;
        padding: 3px;
    }
    
    .filament-font-size-btn {
        width: 28px;
        height: 28px;
    }
}

/* Dark mode styles */
.dark .filament-font-size-switcher {
    background: rgb(0 0 0 / 0.1);
    border-color: rgb(0 0 0 / 0.2);
}

.dark .filament-font-size-btn {
    background: rgb(0 0 0 / 0.1);
    border-color: rgb(0 0 0 / 0.2);
    color: rgb(156 163 175);
}

.dark .filament-font-size-btn:hover {
    background: rgb(0 0 0 / 0.2);
    border-color: rgb(0 0 0 / 0.3);
    color: rgb(209 213 219);
}

.dark .filament-font-size-btn.active {
    background: rgb(34 197 94);
    color: white;
    border-color: rgb(34 197 94);
}
</style>
@endpush

@push('scripts')
<script>
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
    const savedFontSize = localStorage.getItem(STORAGE_KEY) || '{{ $defaultSize }}';
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
}
</script>
@endpush
