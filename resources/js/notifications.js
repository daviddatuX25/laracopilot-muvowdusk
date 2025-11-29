// Request permission for browser notifications
if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
}

// Listen for new alerts
document.addEventListener('livewire:updated', function() {
    // Check if this is an alert-related update
    if (window.location.href.includes('alerts') || document.querySelector('[wire\\:id]')) {
        const notificationCenter = document.querySelector('[wire\\:component="notification-center"]');
        if (notificationCenter) {
            // Trigger browser notification if available
            showBrowserNotification();
        }
    }
});

function showBrowserNotification() {
    if ('Notification' in window && Notification.permission === 'granted') {
        // Get the latest notification from the DOM
        const latestAlert = document.querySelector('.notification-item');
        if (latestAlert) {
            const title = latestAlert.querySelector('.alert-title')?.textContent || 'New Alert';
            const message = latestAlert.querySelector('.alert-message')?.textContent || 'You have a new inventory alert';

            new Notification('Inventory Alert', {
                body: message,
                icon: '/favicon.ico',
                tag: 'inventory-alert',
                requireInteraction: true,
            });
        }
    }
}

// Listen for Livewire events
document.addEventListener('livewire:message.received', function(event) {
    if (event.detail.response?.effects?.notifications) {
        const notification = event.detail.response.effects.notifications[0];
        if (notification) {
            showBrowserNotification();
        }
    }
});
