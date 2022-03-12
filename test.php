<?php

# load config
require 'config.php';

# load mail sender
require_once 'gmail.php';

# get github data
require_once 'github.php';

# test mail sender
sendgmail();

# test github data
echo count(get_events());