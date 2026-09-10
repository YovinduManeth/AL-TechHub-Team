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

