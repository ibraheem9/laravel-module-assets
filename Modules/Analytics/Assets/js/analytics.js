/**
 * Analytics Module JavaScript
 * 
 * Handles analytics tracking and reporting
 * Separate module with its own assets
 */

class Analytics {
    constructor() {
        this.events = [];
        this.init();
    }

    init() {
        console.log('Analytics module initialized');
        this.setupTracking();
        this.loadAnalyticsData();
    }

    setupTracking() {
        // Track page views
        window.addEventListener('load', () => {
            this.trackEvent('page_view', {
                url: window.location.href,
                title: document.title,
                timestamp: new Date().toISOString()
            });
        });

        // Track user interactions
        document.addEventListener('click', (e) => {
            if (e.target.dataset.track) {
                this.trackEvent('user_click', {
                    element: e.target.dataset.track,
                    timestamp: new Date().toISOString()
                });
            }
        });
    }

    trackEvent(eventName, data) {
        const event = {
            name: eventName,
            data: data,
            timestamp: new Date().toISOString()
        };
        this.events.push(event);
        console.log('Event tracked:', event);
    }

    loadAnalyticsData() {
        console.log('Loading analytics data...');
        fetch('/api/analytics/data')
            .then(response => response.json())
            .then(data => {
                console.log('Analytics data:', data);
                this.renderCharts(data);
            })
            .catch(error => console.error('Error loading analytics:', error));
    }

    renderCharts(data) {
        console.log('Rendering analytics charts');
        const container = document.getElementById('analytics-charts');
        if (container) {
            container.innerHTML = `
                <div class="chart-container">
                    <h3>Page Views</h3>
                    <div class="chart" id="pageviews-chart">
                        <p>Chart would render here with Chart.js or similar</p>
                    </div>
                </div>
                <div class="chart-container">
                    <h3>User Activity</h3>
                    <div class="chart" id="activity-chart">
                        <p>Chart would render here with Chart.js or similar</p>
                    </div>
                </div>
            `;
        }
    }

    getEventsByType(eventType) {
        return this.events.filter(e => e.name === eventType);
    }

    sendEvents() {
        console.log('Sending tracked events to server...');
        fetch('/api/analytics/events', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ events: this.events })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Events sent successfully:', data);
            this.events = [];
        })
        .catch(error => console.error('Error sending events:', error));
    }
}

// Initialize analytics when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.analytics = new Analytics();
    });
} else {
    window.analytics = new Analytics();
}
