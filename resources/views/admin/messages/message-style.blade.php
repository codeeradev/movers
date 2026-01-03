<style>
    /* Modern Color Palette */
    :root {
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --secondary: #8b5cf6;
        --success: #10b981;
        --background: #f8fafc;
        --card-bg: #ffffff;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --border: #e2e8f0;
        --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }

    /* Page Container */
    .message-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem 0;
        animation: gradientShift 15s ease infinite;
        background-size: 200% 200%;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Modern Card */
    .modern-card {
        border: none;
        border-radius: 24px;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        background: var(--card-bg);
        animation: slideUp 0.6s ease-out;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .modern-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card Header */
    .card-header-modern {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border: none;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .card-header-modern::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 3s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    .card-header-modern h4 {
        margin: 0;
        color: white;
        font-size: 1.75rem;
        font-weight: 700;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-header-modern h4::before {
        content: '📨';
        font-size: 2rem;
        animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    /* Card Body */
    .card-body-modern {
        padding: 2.5rem;
    }

    /* Form Groups */
    .form-group-modern {
        margin-bottom: 1.75rem;
        animation: fadeIn 0.5s ease-out backwards;
    }

    .form-group-modern:nth-child(1) { animation-delay: 0.1s; }
    .form-group-modern:nth-child(2) { animation-delay: 0.2s; }
    .form-group-modern:nth-child(3) { animation-delay: 0.3s; }
    .form-group-modern:nth-child(4) { animation-delay: 0.4s; }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .form-group-modern label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.95rem;
        transition: color 0.3s ease;
    }

    /* Radio Buttons - Modern Toggle Style */
    .radio-group {
        display: flex;
        gap: 1rem;
        margin-top: 0.75rem;
    }

    .radio-option {
        flex: 1;
        position: relative;
    }

    .radio-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .radio-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        border: 2px solid var(--border);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        font-weight: 500;
        color: var(--text-secondary);
    }

    .radio-label:hover {
        border-color: var(--primary);
        background: #f0f4ff;
        transform: translateY(-2px);
    }

    .radio-option input[type="radio"]:checked + .radio-label {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border-color: var(--primary);
        color: white;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        transform: scale(1.02);
    }

    /* Form Controls */
    .form-select, .form-control {
        border: 2px solid var(--border);
        border-radius: 12px;
        padding: 0.875rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: white;
        color: var(--text-primary);
    }

    .form-select:focus, .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        outline: none;
        transform: translateY(-1px);
    }

    .form-select:hover, .form-control:hover {
        border-color: var(--primary);
    }

    /* Select2 Customization */
    .select2-container--default .select2-selection--multiple {
        border: 2px solid var(--border) !important;
        border-radius: 12px !important;
        padding: 0.5rem !important;
        min-height: 48px;
        transition: all 0.3s ease;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%) !important;
        border: none !important;
        color: white !important;
        border-radius: 8px !important;
        padding: 4px 12px !important;
        margin: 4px !important;
        animation: chipAppear 0.3s ease;
    }

    @keyframes chipAppear {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Range Selector */
    .range-selector {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        margin-bottom: 1.5rem;
        animation: fadeIn 0.5s ease-out 0.5s backwards;
    }

    .range-input {
        flex: 1;
    }

    .range-separator {
        color: var(--text-secondary);
        font-weight: 600;
        padding: 0 0.5rem;
    }

    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-primary:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-send {
        font-size: 1.1rem;
        padding: 1.25rem 2rem;
        margin-top: 1rem;
        animation: fadeIn 0.5s ease-out 0.6s backwards;
    }

    /* Section Transitions */
    #propertySection, #phoneSection {
        animation: sectionFadeIn 0.4s ease-out;
    }

    @keyframes sectionFadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Loading State */
    .btn-primary:disabled {
        background: var(--text-secondary);
        cursor: not-allowed;
        transform: none;
    }

    .btn-primary.loading {
        position: relative;
        color: transparent;
    }

    .btn-primary.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Textarea */
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .message-container {
            padding: 1rem;
        }

        .card-body-modern {
            padding: 1.5rem;
        }

        .card-header-modern {
            padding: 1.5rem;
        }

        .card-header-modern h4 {
            font-size: 1.5rem;
        }

        .range-selector {
            flex-direction: column;
        }

        .range-separator {
            display: none;
        }
    }

    /* Success Animation */
    @keyframes successPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .success-feedback {
        animation: successPulse 0.5s ease;
    }
</style>