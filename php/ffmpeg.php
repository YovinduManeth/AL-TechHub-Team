<?php

$ffmpeg_path = "C:\\ffmpeg\\ffmpeg.exe";

function generateAudioFromVideo($video_path, $audio_path)
{
    global $ffmpeg_path;

    if (!file_exists($ffmpeg_path)) {
        return [
            "success" => false,
            "error" => "FFmpeg not found: " . $ffmpeg_path
        ];
    }

    if (!file_exists($video_path)) {
        return [
            "success" => false,
            "error" => "Video not found: " . $video_path
        ];
    }

    $input = '"' . $video_path . '"';
    $output = '"' . $audio_path . '"';

    $command =
        '"' . $ffmpeg_path . '"' .
        ' -i ' . $input .
        ' -vn' .
        ' -ac 1' .
        ' -b:a 64k' .
        ' -y' .
        ' ' . $output .
        ' 2>&1';

    $output_lines = [];

    exec($command, $output_lines, $return_code);

    return [
        "success" => ($return_code === 0),
        "return_code" => $return_code,
        "command" => $command,
        "output" => $output_lines
    ];
}

function generateVideoQuality($video_path, $output_path, $height)
{
    global $ffmpeg_path;

    if (!file_exists($ffmpeg_path)) {
        return [
            "success" => false,
            "error" => "FFmpeg not found: " . $ffmpeg_path
        ];
    }

    if (!file_exists($video_path)) {
        return [
            "success" => false,
            "error" => "Video not found: " . $video_path
        ];
    }

    $input = '"' . $video_path . '"';
    $output = '"' . $output_path . '"';

    $command =
        '"' . $ffmpeg_path . '"' .
        ' -i ' . $input .
        ' -vf "scale=-2:' . (int)$height . '"' .
        ' -c:v libx264' .
        ' -preset medium' .
        ' -crf 23' .
        ' -c:a aac' .
        ' -b:a 128k' .
        ' -y' .
        ' ' . $output .
        ' 2>&1';

    $output_lines = [];

    exec($command, $output_lines, $return_code);

    return [
        "success" => ($return_code === 0),
        "return_code" => $return_code,
        "command" => $command,
        "output" => $output_lines
    ];
}


function getVideoDuration($video_path)
{
    global $ffmpeg_path;

    if (!file_exists($ffmpeg_path)) {
        return false;
    }

    if (!file_exists($video_path)) {
        return false;
    }

    $input = '"' . $video_path . '"';

    $command =
        '"' . $ffmpeg_path . '"' .
        ' -i ' . $input .
        ' 2>&1';

    $output = [];
    exec($command, $output);

    foreach ($output as $line) {

        if (preg_match(
            '/Duration:\s*(\d+):(\d+):(\d+(?:\.\d+)?)/',
            $line,
            $matches
        )) {

            $hours = (int)$matches[1];
            $minutes = (int)$matches[2];
            $seconds = (float)$matches[3];

            return
                ($hours * 3600) +
                ($minutes * 60) +
                $seconds;
        }
    }

    return false;
}
