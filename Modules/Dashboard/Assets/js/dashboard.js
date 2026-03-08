/**
 * Dashboard Module JavaScript
 * 
 * This file contains all dashboard-related functionality
 * It's loaded separately from the module assets directory
 */

class Dashboard {
    constructor() {
        this.init();
    }

    init() {
        console.log('Dashboard module initialized');
        this.setupEventListeners();
        this.loadDashboardData();
    }

    setupEventListeners() {
        document.addEventListener('DOMContentLoaded', () => {
            console.log('Dashboard DOM ready');
        });
    }

    loadDashboardData() {
        console.log('Loading dashboard data...');
        // Simulate API call
        fetch('/api/dashboard/stats')
            .then(response => response.json())
            .then(data => {
                console.log('Dashboard stats:', data);
                this.renderStats(data);
            })
            .catch(error => console.error('Error loading dashboard:', error));
    }

    renderStats(data) {
        console.log('Rendering dashboard statistics');
        const container = document.getElementById('dashboard-stats');
        if (container) {
            container.innerHTML = `
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Total Users</h3>
                        <p class="stat-value">${data.users || 0}</p>
                    </div>
                    <div class="stat-card">
                        <h3>Active Sessions</h3>
                        <p class="stat-value">${data.sessions || 0}</p>
                    </div>
                </div>
            `;
        }
    }

    refreshData() {
        console.log('Refreshing dashboard data');
        this.loadDashboardData();
    }
}

// Initialize dashboard when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.dashboard = new Dashboard();
    });
} else {
    window.dashboard = new Dashboard();
}
