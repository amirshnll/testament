<?php

function get_events() {
    $github_header = [
        'http' => [
                'method' => 'GET',
                'header' => [
                        'User-Agent: PHP'
                ]
        ]
    ];

    $min_data = DEATH_BOUND * MIN_COMMIT_PER_DAY;
    if($min_data < 100) {
        $loop_counter = 1;   
    } else {
        $loop_counter = round($min_data / 100) + 1;
    }

    $data = null;
    for($i=1; $i <= $loop_counter; $i++) {
        $github_data = stream_context_create($github_header);
        $github_data = file_get_contents('https://api.github.com/search/commits?q=author:' . YOUR_GITHUB_ID . '&sort=author-date&order=desc&page=' . $i . '&per_page=100', false, $github_data);
        $github_data = json_decode($github_data, TRUE);

        if(!is_null($github_data['items'])) {
            if(is_null($data)) {
                $data = $github_data['items'];
            } else {
                $data = array_merge($data, $github_data['items']);
            }
        }
    }

    return $data;
}