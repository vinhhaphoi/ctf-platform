<?php
// Database Connection
require_once __DIR__ . '/config.php';

function getDBConnection() {
    static $conn = null;

    if ($conn === null) {
        // Debug environment variables
        if (DEBUG_MODE) {
            echo "<!-- DEBUG: DB_HOST=" . DB_HOST . ", DB_USER=" . DB_USER . ", DB_NAME=" . DB_NAME . " -->\n";
            echo "<!-- DEBUG: Attempting to connect to MySQL... -->\n";
            
            // Check if host is resolvable
            $host_ip = gethostbyname(DB_HOST);
            echo "<!-- DEBUG: Host IP resolved to: " . $host_ip . " -->\n";
        }

        // Retry logic for Docker container startup
        $max_retries = 30;
        $retry_delay = 3; // seconds
        $last_error = '';

        for ($i = 0; $i < $max_retries; $i++) {
            try {
                // Suppress connection errors to handle them gracefully
                mysqli_report(MYSQLI_REPORT_OFF);
                $conn = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                if ($conn && !$conn->connect_error) {
                    $conn->set_charset("utf8mb4");
                    if (DEBUG_MODE) {
                        echo "<!-- DEBUG: Connection successful after " . ($i + 1) . " attempt(s) -->\n";
                    }
                    break; // Connection successful
                }

                $last_error = $conn ? $conn->connect_error : 'Failed to create mysqli object';
                $conn = null;
            } catch (Exception $e) {
                $last_error = $e->getMessage();
            }

            if ($i < $max_retries - 1) {
                if (DEBUG_MODE) {
                    echo "<!-- DEBUG: Connection attempt " . ($i + 1) . " failed: " . htmlspecialchars($last_error) . ", retrying in {$retry_delay}s... -->\n";
                    flush();
                }
                sleep($retry_delay);
            }
        }

        if ($conn === null || (isset($conn->connect_error) && $conn->connect_error)) {
            $error_msg = "Connection failed after {$max_retries} attempts. Last error: " . $last_error;
            $error_msg .= "\n\nPlease check:\n";
            $error_msg .= "1. MySQL container is running: docker ps\n";
            $error_msg .= "2. Containers are on same network\n";
            $error_msg .= "3. DB_HOST (" . DB_HOST . ") is correct\n";
            $error_msg .= "4. MySQL is accepting connections\n";
            die($error_msg);
        }
    }

    return $conn;
}

// Get connection
$conn = getDBConnection();

// Helper function for vulnerable queries (NO INPUT SANITIZATION)
function executeQuery($sql) {
    global $conn;

    if (DEBUG_MODE) {
        // Intentionally show query for debugging (information disclosure)
        echo "<!-- DEBUG: SQL Query: " . htmlspecialchars($sql) . " -->\n";
    }

    $result = $conn->query($sql);

    if (!$result && DEBUG_MODE) {
        echo "<!-- DEBUG: SQL Error: " . htmlspecialchars($conn->error) . " -->\n";
    }

    return $result;
}

// Vulnerable function - direct string concatenation
function getUserByCredentials($username, $password) {
    global $conn;

    // VULNERABILITY: SQL Injection - no parameterization
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = MD5('$password')";

    if (DEBUG_MODE) {
        echo "<!-- DEBUG: Login Query: " . htmlspecialchars($sql) . " -->\n";
    }

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return false;
}

// Vulnerable search function
function searchProducts($search_term) {
    global $conn;

    // VULNERABILITY: SQL Injection in LIKE clause
    $sql = "SELECT * FROM products WHERE name LIKE '%$search_term%' OR description LIKE '%$search_term%'";

    return executeQuery($sql);
}

// Vulnerable product detail function
function getProductById($id) {
    global $conn;

    // VULNERABILITY: SQL Injection - numeric parameter not validated
    $sql = "SELECT * FROM products WHERE id = $id";

    return executeQuery($sql);
}

// Vulnerable admin check
function checkAdminCredentials($username, $password) {
    global $conn;

    // VULNERABILITY: SQL Injection in admin authentication
    $sql = "SELECT * FROM admin_panel WHERE username = '$username' AND password = '$password'";

    if (DEBUG_MODE) {
        echo "<!-- DEBUG: Admin Query: " . htmlspecialchars($sql) . " -->\n";
    }

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return false;
}

// Function to get user by ID (also vulnerable)
function getUserById($user_id) {
    global $conn;

    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = executeQuery($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return false;
}

// Function to log user action (for trigger challenge)
function logUserAction($user_id, $action, $ip_address) {
    global $conn;

    $sql = "INSERT INTO user_logs (user_id, action, ip_address) VALUES ($user_id, '$action', '$ip_address')";
    return executeQuery($sql);
}
?>
