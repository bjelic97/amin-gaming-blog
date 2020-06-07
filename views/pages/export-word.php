<?php
$word = new COM("word.application");
$word->Visible = 0;
$word->Documents->Add();
$word->Selection->PageSetup->LeftMargin = '2';
$word->Selection->PageSetup->RightMargin = '2';
$word->Selection->Font->Name = 'Arial';
$word->Selection->Font->Size = 10;
$word->Selection->TypeText("Firstname : " . "Aleksa" . "\n");
$word->Selection->TypeText("Lastname : " . "Bjelicic" . "\n");
// $word->Selection->TypeText("About me : \n" .  $about_me);
// $word->Selection->TypeText("About project : \n" .  $about_proj);
$filename = tempnam(sys_get_temp_dir(), "word");
$word->Documents[1]->SaveAs($filename);
$word->quit();
unset($word);
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=author.doc");
readfile($filename);
unlink($filename);
