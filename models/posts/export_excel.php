<?php

$excel = new COM("Excel.Application");
$excel->Visible = 1;
$excel->DisplayAlerts = 1;
$workbook = $excel->Workbooks->Open("http://localhost/amin/models/Posts/Post.xlsx", -4143) or die('Did not open filename');
$sheet = $workbook->Worksheets('Posts');
$sheet->activate;
$br = 1;
foreach ($posts as $post) {

    $cell = $sheet->Range("A{$br}");
    $cell->activate;
    $cell->value = $post->title;


    $cell = $sheet->Range("B{$br}");
    $cell->activate;
    $cell->value = $post->category;


    $cell = $sheet->Range("C{$br}");
    $cell->activate;
    $cell->value = $post->content;


    $cell = $sheet->Range("D{$br}");
    $cell->activate;
    $cell->value = $post->created_at;

    $br++;
}
