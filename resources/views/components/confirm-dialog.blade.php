@props([
    'id' => 'confirm-dialog-' . uniqid(),
    'title' => 'Confirm Action',
    'message' => 'Are you sure you want to proceed?',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'type' => 'danger', // danger, warning, info
    'icon' => null
])

@php
    $typeClasses = [
        'danger' => [
            'bg' => 'var(--red)',
            'border' => 'var(--red)',
            'text' => 'var(--red)',
            'btnBg' => 'var(--red)',
            'btnHover' => '#dc2626'
        ],
        'warning' => [
            'bg' => 'var(--amber)',
            'border' => 'var(--amber)',
            'text' => 'var(--amber)',
            'btnBg' => 'var(--amber)',
            'btnHover' => '#d97706'
        ],
        'info' => [
            'bg' => 'var(--blue)',
            'border' => 'var(--blue)',
            'text' => 'var(--blue)',
            'btnBg' => 'var(--blue)',
            'btnHover' => '#2563eb'
        ]
    ];
    
    $colors = $typeClasses[$type] ?? $typeClasses['danger'];
    
    $defaultIcons = [
        'danger' => '<svg viewBox="0 0 24 24" style="width:24px;height:24px;stroke:currentColor;fill:none;stroke-width:2;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
        'warning' => '<svg viewBox="0 0 24 24" style="width:24px;height:24px;stroke:currentColor;fill:none;stroke-width:2;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/></svg>',
        'info' => '<svg viewBox="0 0 24 24" style="width:24px;height:24px;stroke:currentColor;fill:none;stroke-width:2;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>'
    ];
    
    $iconHtml = $icon ?? $defaultIcons[$type] ?? $defaultIcons['danger'];
@endphp

<!-- Modal Container -->
<div id="{{ $id }}" class="confirm-dialog-overlay" style="display:none;">
    <div class="confirm-dialog-backdrop" onclick="closeConfirmDialog('{{ $id }}')"></div>
    <div class="confirm-dialog">
        <!-- Icon -->
        <div class="confirm-dialog-icon" style="background:{{ $colors['bg'] }}20; border:2px solid {{ $colors['border'] }}; color:{{ $colors['text'] }};">
            {!! $iconHtml !!}
        </div>
        
        <!-- Content -->
        <div class="confirm-dialog-content">
            <h3 class="confirm-dialog-title">{{ $title }}</h3>
            <p class="confirm-dialog-message">{{ $message }}</p>
        </div>
        
        <!-- Actions -->
        <div class="confirm-dialog-actions">
            <button type="button" 
                    class="confirm-dialog-btn confirm-dialog-btn-cancel" 
                    onclick="closeConfirmDialog('{{ $id }}')">
                {{ $cancelText }}
            </button>
            <button type="button" 
                    class="confirm-dialog-btn confirm-dialog-btn-confirm" 
                    style="background:{{ $colors['btnBg'] }}; border-color:{{ $colors['border'] }};"
                    onmouseover="this.style.background='{{ $colors['btnHover'] }}'"
                    onmouseout="this.style.background='{{ $colors['btnBg'] }}'"
                    onclick="confirmDialogAction('{{ $id }}')">
                {{ $confirmText }}
            </button>
        </div>
    </div>
</div>

<style>
.confirm-dialog-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.15s ease-out;
}

.confirm-dialog-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
}

.confirm-dialog {
    position: relative;
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 64px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(0, 0, 0, 0.1);
    padding: 32px;
    max-width: 420px;
    width: 90%;
    text-align: center;
    animation: slideUp 0.25s ease-out;
}

.confirm-dialog-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.confirm-dialog-content {
    margin-bottom: 24px;
}

.confirm-dialog-title {
    font-family: 'Sora', sans-serif;
    font-size: 18px;
    font-weight: 700;
    color: var(--ink);
    margin: 0 0 12px;
    line-height: 1.3;
}

.confirm-dialog-message {
    font-size: 14px;
    font-weight: 500;
    color: var(--ink3);
    margin: 0;
    line-height: 1.5;
}

.confirm-dialog-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
}

.confirm-dialog-btn {
    padding: 12px 24px;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
    border: 2px solid;
    min-width: 100px;
}

.confirm-dialog-btn-cancel {
    background: var(--bg);
    border-color: var(--border);
    color: var(--ink2);
}

.confirm-dialog-btn-cancel:hover {
    background: var(--ink4);
    border-color: var(--ink3);
    color: var(--ink);
}

.confirm-dialog-btn-confirm {
    color: white;
    border-color: var(--red);
}

.confirm-dialog-btn-confirm:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@media (max-width: 480px) {
    .confirm-dialog {
        padding: 24px;
        margin: 20px;
        width: calc(100% - 40px);
    }
    
    .confirm-dialog-actions {
        flex-direction: column;
    }
    
    .confirm-dialog-btn {
        width: 100%;
    }
}
</style>

<script>
// Global confirmation dialog system
window.confirmDialogs = {};

window.showConfirmDialog = function(options) {
    const {
        title = 'Confirm Action',
        message = 'Are you sure you want to proceed?',
        confirmText = 'Confirm',
        cancelText = 'Cancel',
        type = 'danger',
        icon = null,
        onConfirm = null,
        onCancel = null
    } = options;
    
    const dialogId = 'confirm-dialog-' + Date.now();
    
    // Store callbacks
    window.confirmDialogs[dialogId] = {
        onConfirm,
        onCancel
    };
    
    // Create and show dialog
    const dialogHtml = `
        <div id="${dialogId}" class="confirm-dialog-overlay" style="display:flex;">
            <div class="confirm-dialog-backdrop" onclick="closeConfirmDialog('${dialogId}')"></div>
            <div class="confirm-dialog">
                <div class="confirm-dialog-icon" style="background:${type === 'danger' ? 'var(--red)' : type === 'warning' ? 'var(--amber)' : 'var(--blue)'}20; border:2px solid ${type === 'danger' ? 'var(--red)' : type === 'warning' ? 'var(--amber)' : 'var(--blue)'}; color:${type === 'danger' ? 'var(--red)' : type === 'warning' ? 'var(--amber)' : 'var(--blue)'};">
                    ${icon || (type === 'danger' ? '<svg viewBox="0 0 24 24" style="width:24px;height:24px;stroke:currentColor;fill:none;stroke-width:2;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>' : type === 'warning' ? '<svg viewBox="0 0 24 24" style="width:24px;height:24px;stroke:currentColor;fill:none;stroke-width:2;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/></svg>' : '<svg viewBox="0 0 24 24" style="width:24px;height:24px;stroke:currentColor;fill:none;stroke-width:2;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>')}
                </div>
                <div class="confirm-dialog-content">
                    <h3 class="confirm-dialog-title">${title}</h3>
                    <p class="confirm-dialog-message">${message}</p>
                </div>
                <div class="confirm-dialog-actions">
                    <button type="button" class="confirm-dialog-btn confirm-dialog-btn-cancel" onclick="closeConfirmDialog('${dialogId}')">${cancelText}</button>
                    <button type="button" class="confirm-dialog-btn confirm-dialog-btn-confirm" style="background:${type === 'danger' ? 'var(--red)' : type === 'warning' ? 'var(--amber)' : 'var(--blue)'}; border-color:${type === 'danger' ? 'var(--red)' : type === 'warning' ? 'var(--amber)' : 'var(--blue)'};" onmouseover="this.style.background='${type === 'danger' ? '#dc2626' : type === 'warning' ? '#d97706' : '#2563eb'}'" onmouseout="this.style.background='${type === 'danger' ? 'var(--red)' : type === 'warning' ? 'var(--amber)' : 'var(--blue)'}'" onclick="confirmDialogAction('${dialogId}')">${confirmText}</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', dialogHtml);
    
    // Focus management
    document.getElementById(dialogId).focus();
    document.body.style.overflow = 'hidden';
};

window.closeConfirmDialog = function(dialogId) {
    const dialog = document.getElementById(dialogId);
    if (dialog) {
        dialog.remove();
        document.body.style.overflow = '';
        
        // Call cancel callback if exists
        if (window.confirmDialogs[dialogId] && window.confirmDialogs[dialogId].onCancel) {
            window.confirmDialogs[dialogId].onCancel();
        }
        
        // Clean up
        delete window.confirmDialogs[dialogId];
    }
};

window.confirmDialogAction = function(dialogId) {
    if (window.confirmDialogs[dialogId] && window.confirmDialogs[dialogId].onConfirm) {
        window.confirmDialogs[dialogId].onConfirm();
    }
    closeConfirmDialog(dialogId);
};

// Keyboard support
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const dialogs = document.querySelectorAll('.confirm-dialog-overlay');
        if (dialogs.length > 0) {
            const lastDialog = dialogs[dialogs.length - 1];
            closeConfirmDialog(lastDialog.id);
        }
    }
});
</script>
