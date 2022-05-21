<?php
function http_responder($result, $body) {
    echo json_encode(['result' => $result, 'body' => $body]);
}