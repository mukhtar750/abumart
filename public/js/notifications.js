// Initialize Pusher
const pusher = new Pusher(PUSHER_APP_KEY, {
    cluster: PUSHER_APP_CLUSTER,
    encrypted: true
});

// Admin notifications
if (USER_ROLE === 'admin') {
    // Listen for new orders on the admin-notifications channel
    const adminChannel = pusher.subscribe('admin-notifications');
    
    adminChannel.bind('new.order', function(data) {
        showNotification(data.message, 'New Order', {
            icon: 'shopping_cart',
            color: 'blue',
            link: `/admin/orders/${data.order.id}`
        });
    });
}

// User notifications - requires authentication
if (USER_ID) {
    // Listen for order status changes on user's private channel
    const userChannel = pusher.subscribe(`private-user.${USER_ID}`);
    
    userChannel.bind('order.status.changed', function(data) {
        showNotification(data.message, 'Order Update', {
            icon: 'local_shipping',
            color: getStatusColor(data.status),
            link: `/orders/${data.order.id}`
        });
    });
}

// General notifications for all users
const generalChannel = pusher.subscribe('general');

generalChannel.bind('new.product', function(data) {
    showNotification(data.message, 'New Product', {
        icon: 'shopping_bag',
        color: 'green',
        link: `/shop/${data.product.id}`
    });
});

// Helper function to display notifications
function showNotification(message, title, options = {}) {
    // Check if the browser supports notifications
    if (!("Notification" in window)) {
        console.log("This browser does not support desktop notifications");
        return;
    }

    // Default values
    const defaults = {
        icon: 'info',
        color: 'blue',
        link: '#'
    };

    // Merge options with defaults
    const config = { ...defaults, ...options };

    // Create toast notification
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 max-w-sm w-full 
                      border-l-4 border-${config.color}-500 transform transition-transform duration-300 ease-in-out`;
    toast.style.zIndex = '9999';
    toast.innerHTML = `
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <span class="material-icons text-${config.color}-500">${config.icon}</span>
            </div>
            <div class="ml-3 w-0 flex-1">
                <p class="text-sm font-medium text-gray-900 dark:text-white">${title}</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">${message}</p>
                <div class="mt-2">
                    <a href="${config.link}" class="text-sm font-medium text-${config.color}-600 hover:text-${config.color}-500">
                        View details
                    </a>
                </div>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button class="rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none">
                    <span class="sr-only">Close</span>
                    <span class="material-icons">close</span>
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Slide in animation
    setTimeout(() => {
        toast.classList.add('translate-y-2');
    }, 100);
    
    // Add click event to close button
    const closeButton = toast.querySelector('button');
    closeButton.addEventListener('click', () => {
        toast.classList.remove('translate-y-2');
        toast.classList.add('-translate-y-full');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    });
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        if (document.body.contains(toast)) {
            toast.classList.remove('translate-y-2');
            toast.classList.add('-translate-y-full');
            setTimeout(() => {
                if (document.body.contains(toast)) {
                    document.body.removeChild(toast);
                }
            }, 300);
        }
    }, 5000);
    
    // Also try browser notifications if permissions are granted
    if (Notification.permission === "granted") {
        const notification = new Notification(title, {
            body: message,
            icon: '/favicon.ico'
        });
        
        notification.onclick = function() {
            window.open(config.link);
        };
    }
    // If the user hasn't given permission for notifications, ask for it
    else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(permission => {
            if (permission === "granted") {
                const notification = new Notification(title, {
                    body: message,
                    icon: '/favicon.ico'
                });
                
                notification.onclick = function() {
                    window.open(config.link);
                };
            }
        });
    }
}

// Helper function to get color based on order status
function getStatusColor(status) {
    switch(status) {
        case 'pending': return 'yellow';
        case 'processing': return 'blue';
        case 'shipped': return 'purple';
        case 'delivered': return 'green';
        case 'cancelled': return 'red';
        default: return 'gray';
    }
}

// Refresh notification counts periodically
function refreshNotificationCount() {
    if (USER_ROLE === 'admin') {
        fetch('/admin/notifications/unread-count')
            .then(response => response.json())
            .then(data => {
                const countElement = document.getElementById('admin-notification-count');
                if (countElement) {
                    if (data.count > 0) {
                        countElement.textContent = data.count;
                        countElement.classList.remove('hidden');
                    } else {
                        countElement.classList.add('hidden');
                    }
                }
            });
    } else if (USER_ID) {
        fetch('/notifications/unread-count')
            .then(response => response.json())
            .then(data => {
                const countElement = document.getElementById('notification-count');
                if (countElement) {
                    if (data.count > 0) {
                        countElement.textContent = data.count;
                        countElement.classList.remove('hidden');
                    } else {
                        countElement.classList.add('hidden');
                    }
                }
            });
    }
}

// Refresh notification count every 30 seconds
if (USER_ID || USER_ROLE === 'admin') {
    setInterval(refreshNotificationCount, 30000);
} 