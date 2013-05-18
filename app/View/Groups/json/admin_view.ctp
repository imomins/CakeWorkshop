<?php

$users = array();

foreach ($groups['User'] as $user) {
    $user['users']['edit'] = Router::url('/admin/users/edit/' . $user['users']['id']);
    array_push($users, $user['users']);
}

echo json_encode(array(
    'aaData' => $users
));