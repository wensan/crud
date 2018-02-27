<?php
function _getLoggedUser() {
    $user = \JWTAuth::toUser();
    return $user;
}
