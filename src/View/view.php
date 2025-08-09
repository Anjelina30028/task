<?php

namespace View;

class View
{
    public $tmpPath;

    public function __construct(string $tmpPath)
    {
        $this->tmpPath = $tmpPath;
    }

    public function render(string $tmpName, array $params = [], int $status = 200)
    {
        http_response_code($status);
        extract($params);
        ob_start();
        include $this->tmpPath . '/' . $tmpName;
        $buff = ob_get_contents();
        ob_end_clean();
        echo $buff;
    }
}
