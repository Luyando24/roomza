// Check for unread messages and update the counter
function updateUnreadCount() {
    // Only proceed if the user is authenticated
    if (!document.querySelector('meta[name="url"]')) {
        return;
    }
    
    $.ajax({
        url: '/chatify/api/unread-count',
        method: 'GET',
        dataType: 'JSON',
        success: (data) => {
            // Update desktop unread count
            const unreadCountElement = document.getElementById('unread-count');
            if (unreadCountElement) {
                if (data.count > 0) {
                    unreadCountElement.textContent = data.count;
                    unreadCountElement.style.display = 'flex';
                } else {
                    unreadCountElement.style.display = 'none';
                }
            }
            
            // Update mobile unread count
            const mobileUnreadCountElement = document.getElementById('mobile-unread-count');
            if (mobileUnreadCountElement) {
                if (data.count > 0) {
                    mobileUnreadCountElement.textContent = data.count;
                    mobileUnreadCountElement.style.display = 'flex';
                } else {
                    mobileUnreadCountElement.style.display = 'none';
                }
            }
        },
        error: (error) => {
            console.error('Error fetching unread count:', error);
        }
    });
}

// Initialize Pusher for real-time updates
document.addEventListener('DOMContentLoaded', function() {
    // Only run this if the user is authenticated
    const metaUrl = document.querySelector('meta[name="url"]');
    if (metaUrl) {
        // Check for unread messages initially
        updateUnreadCount();
        
        // Set up interval to check for unread messages
        setInterval(updateUnreadCount, 30000); // Check every 30 seconds
        
        // Listen for new messages via Pusher
        const auth_id = metaUrl.getAttribute('data-user');
        if (auth_id && window.pusher) {
            const channel = pusher.subscribe(`private-chatify.${auth_id}`);
            channel.bind('messaging', function(data) {
                // Update unread count when a new message is received
                updateUnreadCount();
                
                // Play notification sound if not on the chat page
                if (!window.location.href.includes('/chat')) {
                    playNotificationSound('new_message_notification');
                }
            });
        }
    }
});



