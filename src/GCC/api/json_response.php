<?php

function jsonResponse($data, int $code = 200): never {
    http_response_code($code);
    echo json_encode($data);
    exit;
}

?>