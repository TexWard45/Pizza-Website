<?php
include('../api.php');
include('../connection.php');
include('../object/user.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
    if (User::hasUsername($_POST['username'])) {
        echo 'exists';
        exit();
    }

    $user = new User($_POST['username'], 1, null, null, null, null, null, null);

    User::add($user, $_POST['password']);
    echo 'success';
    exit();
}
echo 'fail';
exit();
?>