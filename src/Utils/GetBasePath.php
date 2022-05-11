<?php

function getBasePath($path)
{
    return $_SERVER["DOCUMENT_ROOT"]
        . DIRECTORY_SEPARATOR . "VChat"
        . DIRECTORY_SEPARATOR . "src"
        . DIRECTORY_SEPARATOR . $path;
}
