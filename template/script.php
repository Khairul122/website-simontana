<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="assets/vendors/chart.js/Chart.min.js"></script>
<script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
<script src="assets/js/off-canvas.js"></script>
<script src="assets/js/hoverable-collapse.js"></script>
<script src="assets/js/template.js"></script>
<script src="assets/js/settings.js"></script>
<script src="assets/js/todolist.js"></script>
<script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
<script src="assets/js/dashboard.js"></script>
<script src="assets/js/proBanner.js"></script>

<!-- Dashboard API Debug Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Log dashboard data to console for debugging
    function logDashboardData() {
        <?php if (isset($dashboard)): ?>
        console.log('=== DASHBOARD DATA DEBUG ===');
        console.log('Dashboard Stats:', <?php echo json_encode($dashboard['stats'] ?? []); ?>);
        console.log('Recent Laporan:', <?php echo json_encode($dashboard['recent_laporan'] ?? []); ?>);
        console.log('Recent Monitoring:', <?php echo json_encode($dashboard['recent_monitoring'] ?? []); ?>);
        console.log('BMKG Info:', <?php echo json_encode($dashboard['bmkg_info'] ?? null); ?>);
        console.log('BMKG Warnings:', <?php echo json_encode($dashboard['bmkg_warnings'] ?? []); ?>);
        console.log('Pending Laporan:', <?php echo json_encode($dashboard['pending_laporan'] ?? []); ?>);
        console.log('Desa Laporan:', <?php echo json_encode($dashboard['desa_laporan'] ?? []); ?>);
        console.log('Pending Monitoring:', <?php echo json_encode($dashboard['pending_monitoring'] ?? []); ?>);
        console.log('Local BMKG:', <?php echo json_encode($dashboard['local_bmkg'] ?? []); ?>);
        console.log('Full Dashboard Object:', <?php echo json_encode($dashboard ?? []); ?>);
        console.log('=== END DASHBOARD DATA DEBUG ===');
        <?php endif; ?>

        <?php if (isset($user)): ?>
        console.log('Current User:', <?php echo json_encode($user); ?>);
        console.log('User Role:', <?php echo json_encode($role ?? ''); ?>);
        <?php endif; ?>
    }

    // Log session and authentication info
    function logAuthInfo() {
        console.log('=== AUTHENTICATION DEBUG ===');
        console.log('Session ID:', '<?php echo session_id(); ?>');
        <?php if (isset($_SESSION)): ?>
        console.log('Session Data:', <?php echo json_encode($_SESSION); ?>);
        <?php endif; ?>
        console.log('=== END AUTHENTICATION DEBUG ===');
    }

    // Test API connection
    function testAPIConnection() {
        console.log('=== API CONNECTION TEST ===');

        // Test basic API connectivity
        fetch('http://127.0.0.1:8000/api/test', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('API Test Response Status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('API Test Response Data:', data);
        })
        .catch(error => {
            console.error('API Test Error:', error);
        });

        // Test specific endpoints
        <?php if (isset($_SESSION['bencana_api_token'])): ?>
        const token = '<?php echo $_SESSION["bencana_api_token"]; ?>';
        console.log('Testing with token:', token.substring(0, 10) + '...');

        // Test multiple endpoints
        const endpoints = [
            '/api/laporan/statistics',
            '/api/laporan?limit=5',
            '/api/monitoring?limit=5',
            '/api/admin/users',
            '/api/bmkg/dashboard'
        ];

        endpoints.forEach(endpoint => {
            fetch('http://127.0.0.1:8000' + endpoint, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            })
            .then(response => {
                console.log(`Response Status [${endpoint}]:`, response.status);
                return response.json().catch(() => response.text());
            })
            .then(data => {
                console.log(`Response Data [${endpoint}]:`, data);

                // Analyze response structure
                if (typeof data === 'object' && data !== null) {
                    console.log(`Response Structure [${endpoint}]:`, {
                        hasData: 'data' in data,
                        hasSuccess: 'success' in data,
                        hasMessage: 'message' in data,
                        keys: Object.keys(data),
                        sampleFirstKey: Object.keys(data)[0],
                        sampleFirstValue: data[Object.keys(data)[0]]
                    });
                }
            })
            .catch(error => {
                console.error(`API Error [${endpoint}]:`, error);
            });
        });
        <?php else: ?>
        console.log('No API token found in session');
        <?php endif; ?>

        console.log('=== END API CONNECTION TEST ===');
    }

    // Log environment info
    function logEnvironmentInfo() {
        console.log('=== ENVIRONMENT DEBUG ===');
        console.log('Current URL:', window.location.href);
        console.log('User Agent:', navigator.userAgent);
        console.log('Timestamp:', new Date().toISOString());
        console.log('PHP Memory Limit:', '<?php echo ini_get("memory_limit"); ?>');
        console.log('PHP Max Execution Time:', '<?php echo ini_get("max_execution_time"); ?>');
        console.log('=== END ENVIRONMENT DEBUG ===');
    }

    // Run all debug functions
    logDashboardData();
    logAuthInfo();
    testAPIConnection();
    logEnvironmentInfo();

    // Auto-refresh data every 30 seconds (optional)
    setInterval(function() {
        console.log('=== AUTO REFRESH DEBUG ===', new Date().toISOString());
        // You can add auto-refresh logic here if needed
    }, 30000);
});

// Global error handler
window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', {
        message: e.message,
        filename: e.filename,
        lineno: e.lineno,
        colno: e.colno,
        stack: e.error ? e.error.stack : null
    });
});

// Global unhandled promise rejection handler
window.addEventListener('unhandledrejection', function(e) {
    console.error('Unhandled Promise Rejection:', {
        reason: e.reason,
        promise: e.promise
    });
});
</script>