<?php

namespace SiteTool\ResultWriter;

use SiteTool\ResultWriter;
use SiteTool\SiteToolException;




class FileResultWriter implements ResultWriter
{
    private $fileHandle;
    
    public function __construct($filename)
    {
        echo "Filename is $filename ";
        var_dump($filename);
        
        $this->fileHandle = fopen($filename, "w");
        if ($this->fileHandle === false) {
            throw new SiteToolException("Failed to open $filename for writing.");
        }
    }

    public function __destruct()
    {
        if ($this->fileHandle) {
            fclose($this->fileHandle);
        }
        echo  "should be closed.\n";
    }

    public function write($string, ...$otherStrings)
    {
        $line = $string;
        if (count($otherStrings) !== 0) {
            $line .= ", ";
        }

        $line .= implode(", ", $otherStrings);
        $line .= "\n";

        fwrite($this->fileHandle, $line);
    }
}
