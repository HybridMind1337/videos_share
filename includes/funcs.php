<?php
/**
 * @param null $location
 * @param $alert
 * @param $message
 */
function msg($location = null, $alert, $message)
{

    $_SESSION['alert'] = array(
        'status' => true,
        'message' => $message,
        'alert' => $alert,
    );

    header('Location: ' . $location);
    exit();

}

/**
 *
 */
function showMessage()
{
    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert']['alert'];
        $message = $_SESSION['alert']['message'];
        echo "<div class=\"alert alert-$alert mt-1 mb-1\">";
        echo "<p class=\"card-text text-center\"> $message </p>";
        echo '</div>';
    }

}


/**
 * @param $name
 */
function deleteSession($name)
{
    if (isset($_SESSION[$name])) {
        unset($_SESSION[$name]);
    }
}

/**
 * @param $id
 * @return bool|mysqli_result
 */
function userbyid($id)
{
    global $conn;
    $userid = mysqli_query($conn, "SELECT * FROM phpbb_users WHERE user_id = " . $id);
    $row = mysqli_fetch_assoc($userid);
    return $row;
}