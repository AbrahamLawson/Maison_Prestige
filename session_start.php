<?php
    function session_start_prim () {
        ini_set('session.use_cookies',  true);
        ini_set('session.use_only_cookies', true);
        ini_set('session.cookie_lifetime', 3600);
        session_start();
    }