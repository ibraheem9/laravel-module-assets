/**
 * Settings Module JavaScript
 * 
 * Handles application settings and preferences
 * Separate module with independent assets
 */

class Settings {
    constructor() {
        this.settings = {};
        this.init();
    }

    init() {
        console.log('Settings module initialized');
        this.loadSettings();
        this.setupFormHandlers();
    }

    loadSettings() {
        console.log('Loading settings...');
        fetch('/api/settings')
            .then(response => response.json())
            .then(data => {
                this.settings = data;
                console.log('Settings loaded:', this.settings);
                this.renderSettings();
            })
            .catch(error => console.error('Error loading settings:', error));
    }

    renderSettings() {
        console.log('Rendering settings form');
        const container = document.getElementById('settings-form');
        if (container) {
            container.innerHTML = `
                <form id="settings-form-element" class="settings-form">
                    <div class="form-group">
                        <label for="app-name">Application Name</label>
                        <input type="text" id="app-name" name="app_name" 
                               value="${this.settings.app_name || ''}" 
                               class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="theme">Theme</label>
                        <select id="theme" name="theme" class="form-control">
                            <option value="light" ${this.settings.theme === 'light' ? 'selected' : ''}>Light</option>
                            <option value="dark" ${this.settings.theme === 'dark' ? 'selected' : ''}>Dark</option>
                            <option value="auto" ${this.settings.theme === 'auto' ? 'selected' : ''}>Auto</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="notifications">Enable Notifications</label>
                        <input type="checkbox" id="notifications" name="notifications" 
                               ${this.settings.notifications ? 'checked' : ''} 
                               class="form-checkbox">
                    </div>
                    
                    <div class="form-group">
                        <label for="language">Language</label>
                        <select id="language" name="language" class="form-control">
                            <option value="en" ${this.settings.language === 'en' ? 'selected' : ''}>English</option>
                            <option value="es" ${this.settings.language === 'es' ? 'selected' : ''}>Spanish</option>
                            <option value="fr" ${this.settings.language === 'fr' ? 'selected' : ''}>French</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn-primary">Save Settings</button>
                </form>
            `;
            
            this.setupFormHandlers();
        }
    }

    setupFormHandlers() {
        const form = document.getElementById('settings-form-element');
        if (form) {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.saveSettings(form);
            });
        }
    }

    saveSettings(form) {
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        console.log('Saving settings:', data);
        
        fetch('/api/settings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            console.log('Settings saved successfully:', data);
            this.showNotification('Settings saved successfully!', 'success');
            this.settings = data;
        })
        .catch(error => {
            console.error('Error saving settings:', error);
            this.showNotification('Error saving settings', 'error');
        });
    }

    showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: ${type === 'success' ? '#4caf50' : '#f44336'};
            color: white;
            border-radius: 4px;
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    getSetting(key, defaultValue = null) {
        return this.settings[key] || defaultValue;
    }

    setSetting(key, value) {
        this.settings[key] = value;
    }
}

// Initialize settings when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.settings = new Settings();
    });
} else {
    window.settings = new Settings();
}
