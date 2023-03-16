<?php

namespace classes;

use const LOG_PATH;

class Log {
    private bool $isDebug;

    public function __construct($isDebug) {
        $this->isDebug = $isDebug;
    }

    public function setLog ($theme, $status, $message) {
        $dateClass = new \DateTime();
        $dateNow   = $dateClass->format('d_m_Y');
        $timeNow   = $dateClass->format('H:i:s');

        $path    = LOG_PATH . "$theme-$status-$dateNow.log";
        $message = "[$timeNow] $message";

        if ($this->isDebug) {
            $this->renderLog($theme, $status, $message);
        }

        file_put_contents($path, "$message \n", FILE_APPEND);
    }

    private function renderLog ($theme, $status, $message) {
        $block  = "<div class='system-message'>";
        $block .= "<h2>$theme - $status</h2>";
        $block .= "<pre>$message</pre>";
        $block .= "</div>";

        echo $block;
    }

}