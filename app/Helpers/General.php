<?php


function SaveImage($folder , $image )
{
    Image::make($image)->resize(300, null, function ($constraint) {
        $constraint->aspectRatio();
    })->save(public_path($folder .$image->hashName()));
}