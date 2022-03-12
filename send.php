<?php

# load config
require 'config.php';

# load mail sender
require_once 'gmail.php';

# get github data
require_once 'github.php';
$github_data = get_events();

$i = 0;
$daily_commit = array();
foreach ($github_data as $key => $val) {
    $commit_author_date = explode("T", $val['commit']['author']['date']);
    $daily_commit[$i] =  $commit_author_date[0];

    # convert user timezone to UTC
    $uk_timezone_date = new DateTimeZone('Europe/London');
    $uk_converted_date = new DateTime($daily_commit[$i]);
    $uk_converted_date->setTimezone($uk_timezone_date);
    $daily_commit[$i] = $uk_converted_date->format('Y-d-m');

    $i+=1;
}

if(!is_array($daily_commit) && count($daily_commit) < 1) {
    die();
}
elseif(strtotime($daily_commit[0]) + (86400 * DEATH_BOUND) < strtotime("today UTC")) {
    sendgmail();
    echo "Testament's mail sent successfully";
    die();
}

$dates = array();
for($i = 1; $i <= DEATH_BOUND; $i++) {
    $loop_date = date("Y-d-m", strtotime("-" . $i . " days",strtotime("today UTC")));
    $daily_count_commits = 0;

    # count daily contribution
    foreach ($daily_commit as $key => $val) {
        if( $val == $loop_date ) {
            $daily_count_commits += 1;
        }
        elseif($daily_count_commits != 0) {
            break;
        }
    }
    
    if($daily_count_commits > MIN_COMMIT_PER_DAY) {
        die();
    }
}

sendgmail();
echo "Testament's mail sent successfully";
die();