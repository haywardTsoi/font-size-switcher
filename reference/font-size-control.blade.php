<div class="font-size-control">
    @foreach($fontSizes as $size => $multiplier)
        <button class="font-size-btn {{ $size === $defaultSize ? 'active' : '' }}" 
                data-size="{{ $size }}" 
                data-multiplier="{{ $multiplier }}">
            A
        </button>
    @endforeach
</div>

<style>
/* Font size controls positioned next to notification icon */
.font-size-control {
    position: fixed;
    top: 1rem;
    right: 4rem; /* Position to the left of notification icon */
    z-index: 50;
    display: flex;
    gap: 4px;
    background: white;
    padding: 6px;
    border-radius: 6px;
    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
    border: 1px solid rgb(229 231 235);
}

.font-size-btn {
    width: 28px;
    height: 28px;
    border: 1px solid #e5e7eb;
    background: white;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    transition: all 0.15s ease;
    color: #374151;
}

.font-size-btn[data-size="small"] {
    font-size: 11px;
}

.font-size-btn[data-size="normal"] {
    font-size: 13px;
}

.font-size-btn[data-size="large"] {
    font-size: 15px;
}

.font-size-btn:hover {
    background: #f9fafb;
    border-color: #d1d5db;
}

.font-size-btn.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

/* Font size classes */
.font-size-small {
    font-size: 0.8em !important;
}

.font-size-small * {
    font-size: inherit !important;
}

.font-size-normal {
    font-size: 1em !important;
}

.font-size-normal * {
    font-size: inherit !important;
}

.font-size-large {
    font-size: 1.2em !important;
}

.font-size-large * {
    font-size: inherit !important;
}

/* Dark mode support */
.dark .font-size-control {
    background: #1f2937;
    border-color: #374151;
}

.dark .font-size-btn {
    background: #374151;
    border-color: #4b5563;
    color: #f9fafb;
}

.dark .font-size-btn:hover {
    background: #4b5563;
    border-color: #6b7280;
}

.dark .font-size-btn.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .font-size-control {
        right: 3rem;
        gap: 2px;
        padding: 4px;
    }
    
    .font-size-btn {
        width: 24px;
        height: 24px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fontSizeControl = document.querySelector('.font-size-control');
    if (!fontSizeControl) return;
    
    const buttons = fontSizeControl.querySelectorAll('.font-size-btn');
    
    // Load saved font size
    const savedFontSize = localStorage.getItem('filament-font-size') || 'normal';
    applyFontSize(savedFontSize);
    updateActiveButton(savedFontSize);
    
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const size = this.dataset.size;
            const multiplier = parseFloat(this.dataset.multiplier);
            applyFontSize(size, multiplier);
            updateActiveButton(size);
            localStorage.setItem('filament-font-size', size);
        });
    });
    
    function applyFontSize(size, multiplier = null) {
        document.body.classList.remove('font-size-small', 'font-size-normal', 'font-size-large');
        document.body.classList.add(`font-size-${size}`);
        
        // Apply dynamic scaling if multiplier is provided
        if (multiplier) {
            document.documentElement.style.setProperty('--font-scale', multiplier);
        }
    }
    
    function updateActiveButton(size) {
        buttons.forEach(btn => btn.classList.remove('active'));
        const activeBtn = fontSizeControl.querySelector(`[data-size="${size}"]`);
        if (activeBtn) {
            activeBtn.classList.add('active');
        }
    }
});
</script>