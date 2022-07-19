<?php

return [

    //list of parameters to avoid logging either in query parameter or body
    "avoids" => [
        'password',
        'pin',
        'security_key',
        'token'
    ]
];
