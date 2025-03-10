<?php
namespace Dotenv;

class Parser
{
    public function parse(string $line)
    {
        $line = trim($line);
        if (strpos($line, '=') === false) {
            return null;
        }

        list($key, $value) = explode('=', $line, 2);
        return [$key => $value];
    }
}
