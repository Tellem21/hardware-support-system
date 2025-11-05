// Main JavaScript for the College of Science Hardware Support System

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initFormValidation();
    initServiceAnimations();
    initMobileMenu();
});

// Form validation
function initFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    showFieldError(field, 'This field is required');
                } else {
                    clearFieldError(field);
                }
                
                // Email validation
                if (field.type === 'email' && field.value.trim()) {
                    if (!isValidEmail(field.value)) {
                        isValid = false;
                        showFieldError(field, 'Please enter a valid email address');
                    }
                }
                
                // Phone validation
                if (field.type === 'tel' && field.value.trim()) {
                    if (!isValidPhone(field.value)) {
                        isValid = false;
                        showFieldError(field, 'Please enter a valid phone number');
                    }
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showNotification('Please fill all required fields correctly', 'error');
            }
        });
    });
}

// Email validation
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Phone validation (Ghanaian format)
function isValidPhone(phone) {
    const phoneRegex = /^(\+233|0)[234567]\d{8}$/;
    return phoneRegex.test(phone.replace(/\s/g, ''));
}

// Show field error
function showFieldError(field, message) {
    clearFieldError(field);
    field.style.borderColor = '#dc3545';
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.style.color = '#dc3545';
    errorDiv.style.fontSize = '0.875rem';
    errorDiv.style.marginTop = '5px';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

// Clear field error
function clearFieldError(field) {
    field.style.borderColor = '';
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// Service card animations
function initServiceAnimations() {
    const serviceCards = document.querySelectorAll('.service-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
    
    serviceCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
}

// Mobile menu functionality
function initMobileMenu() {
    const nav = document.querySelector('nav');
    const menuToggle = document.createElement('button');
    
    menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
    menuToggle.className = 'mobile-menu-toggle';
    menuToggle.style.display = 'none';
    
    // Add styles for mobile menu
    const style = document.createElement('style');
    style.textContent = `
        .mobile-menu-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 10px;
        }
        
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block !important;
            }
            
            nav ul {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #8B0000;
                z-index: 1000;
            }
            
            nav ul.show {
                display: flex;
            }
            
            nav ul li {
                width: 100%;
            }
            
            nav ul li a {
                padding: 15px 20px;
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }
        }
    `;
    document.head.appendChild(style);
    
    // Insert toggle button
    const headerContainer = document.querySelector('header .container');
    headerContainer.appendChild(menuToggle);
    
    // Toggle menu
    menuToggle.addEventListener('click', function() {
        const navList = document.querySelector('nav ul');
        navList.classList.toggle('show');
    });
}

// Notification system
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <span>${message}</span>
        <button class="notification-close">&times;</button>
    `;
    
    // Add notification styles
    if (!document.querySelector('.notification-styles')) {
        const styles = document.createElement('style');
        styles.className = 'notification-styles';
        styles.textContent = `
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                border-radius: 5px;
                color: white;
                z-index: 10000;
                max-width: 400px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                display: flex;
                justify-content: space-between;
                align-items: center;
                animation: slideIn 0.3s ease;
            }
            
            .notification-info { background-color: #17a2b8; }
            .notification-success { background-color: #28a745; }
            .notification-error { background-color: #dc3545; }
            .notification-warning { background-color: #ffc107; color: #333; }
            
            .notification-close {
                background: none;
                border: none;
                color: inherit;
                font-size: 1.2rem;
                cursor: pointer;
                margin-left: 15px;
            }
            
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(styles);
    }
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
    
    // Close button
    notification.querySelector('.notification-close').addEventListener('click', () => {
        notification.remove();
    });
}

// Utility function for making API calls
async function makeApiCall(endpoint, data) {
    try {
        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });
        
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        
        return await response.json();
    } catch (error) {
        console.error('API call failed:', error);
        showNotification('Service temporarily unavailable. Please try again later.', 'error');
        throw error;
    }
}

// Export functions for use in other scripts
window.CollegeSupportSystem = {
    showNotification,
    makeApiCall,
    isValidEmail,
    isValidPhone
};