<?php
/**
 * Mage script base
 */
$appFileName = 'app/Mage.php';
$isAppFileIncluded = false;
for ($levelUp = 0; $levelUp < 5; $levelUp++) {
    if (file_exists($appFileName)) {
        include $appFileName;
        $isAppFileIncluded = true;
        break;
    }
    $appFileName = '../' . $appFileName;
}

if (!$isAppFileIncluded) {
    die('Unable to locate "app/Mage.php".');
}

umask(0);

class Timer
{
    var $start;
    var $pause_time;

    /*  start the timer  */
    function Timer($start = 0)
    {
        if ($start) {
            $this->start();
        }
    }

    /*  start the timer  */
    function start()
    {
        $this->start = $this->getTime();
        $this->pause_time = 0;
    }

    /*  pause the timer  */
    function pause()
    {
        $this->pause_time = $this->getTime();
    }

    /*  unpause the timer  */
    function unpause()
    {
        $this->start += ($this->getTime() - $this->pause_time);
        $this->pause_time = 0;
    }

    /*  get the current timer value  */
    function get($decimals = 8)
    {
        return round(($this->getTime() - $this->start), $decimals);
    }

    /*  format the time in seconds  */
    function getTime()
    {
        list($usec, $sec) = explode(' ', microtime());
        return ((float)$usec + (float)$sec);
    }
}

function readLineFromInFile($isResetHeaders = false)
{
    global $csvDelimiter, $csvEnclosure, $inFileHandle, $inFileFieldsToOutputWhileReading,
           $isInFileContainsHeaders, $headers;
    static $isHeaderProcessed = false;
    if ($isResetHeaders) {
        $headers = array();
        $isHeaderProcessed = false;
    }

    $fields = fgetcsv($inFileHandle, 0, $csvDelimiter, $csvEnclosure);
    if ($fields) {
        if ($isInFileContainsHeaders && $headers) {
            $fields = array_combine($headers, $fields);
        }
        if ($inFileFieldsToOutputWhileReading && $fields && $isHeaderProcessed) {
            echo "Processing {$inFileFieldsToOutputWhileReading}: {$fields[$inFileFieldsToOutputWhileReading]}\n";
        }
    }
    if (!$isHeaderProcessed) {
        $isHeaderProcessed = true;
    }
    return $fields;
}

function writeLineToOutFile($fields)
{
    global $csvDelimiter, $csvEnclosure, $outChunkFileHandle;
    fputcsv($outChunkFileHandle, $fields, $csvDelimiter, $csvEnclosure);
}

function timeIntervalStr($secs)
{
    $bit = array(
        'y' => $secs / 31556926 % 12,
        'w' => $secs / 604800 % 52,
        'd' => $secs / 86400 % 7,
        'h' => $secs / 3600 % 24,
        'm' => $secs / 60 % 60,
        's' => $secs % 60
    );

    $ret = array();
    foreach ($bit as $k => $v)
        if ($v > 0) $ret[] = $v . $k;

    return join(' ', $ret);
}

class Colors
{
    private $foreground_colors = array();
    private $background_colors = array();

    public function __construct()
    {
        // Set up shell colors
        $this->foreground_colors['black'] = '0;30';
        $this->foreground_colors['dark_gray'] = '1;30';
        $this->foreground_colors['blue'] = '0;34';
        $this->foreground_colors['light_blue'] = '1;34';
        $this->foreground_colors['green'] = '0;32';
        $this->foreground_colors['light_green'] = '1;32';
        $this->foreground_colors['cyan'] = '0;36';
        $this->foreground_colors['light_cyan'] = '1;36';
        $this->foreground_colors['red'] = '0;31';
        $this->foreground_colors['light_red'] = '1;31';
        $this->foreground_colors['purple'] = '0;35';
        $this->foreground_colors['light_purple'] = '1;35';
        $this->foreground_colors['brown'] = '0;33';
        $this->foreground_colors['yellow'] = '1;33';
        $this->foreground_colors['light_gray'] = '0;37';
        $this->foreground_colors['white'] = '1;37';

        $this->background_colors['black'] = '40';
        $this->background_colors['red'] = '41';
        $this->background_colors['green'] = '42';
        $this->background_colors['yellow'] = '43';
        $this->background_colors['blue'] = '44';
        $this->background_colors['magenta'] = '45';
        $this->background_colors['cyan'] = '46';
        $this->background_colors['light_gray'] = '47';
    }

    // Returns colored string
    public function getColoredString($string, $foreground_color = null, $background_color = null)
    {
        $colored_string = "";

        // Check if given foreground color found
        if (isset($this->foreground_colors[$foreground_color])) {
            $colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
        }
        // Check if given background color found
        if (isset($this->background_colors[$background_color])) {
            $colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
        }

        // Add string and end coloring
        $colored_string .= $string . "\033[0m";

        return $colored_string;
    }

    // Returns all foreground color names
    public function getForegroundColors()
    {
        return array_keys($this->foreground_colors);
    }

    // Returns all background color names
    public function getBackgroundColors()
    {
        return array_keys($this->background_colors);
    }
}

function formatBytes($bytes, $precision = 2)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    // Uncomment one of the following alternatives
    // $bytes /= pow(1024, $pow);
    $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}

// Show progress
declare(ticks = 100000);
$GStatusText = '';
$GStatusTextColor = 'light_green';
$GTimeTextColor = 'red';
$GColors = new Colors();
register_tick_function(function () {
        global $GStatusText;
        global $GStatusTextColor;
        global $GTimeTextColor;
        global $GColors;
        if (!$GStatusText) {
            return;
        }

        static $timer = null;
        if (!$timer) {
            $timer = new Timer(1);
        }

        static $lastTimePhaseChanged = 0;
        if (!$lastTimePhaseChanged) {
            $lastTimePhaseChanged = microtime(1);
        }
        static $phaseLengthUsec = 0.15;
        if (microtime(1) < $lastTimePhaseChanged + $phaseLengthUsec) {
            return;
        }

        $lastTimePhaseChanged = microtime(1);
        static $spinnerChars = array();
        if (!$spinnerChars) {
            $spinnerChars = explode(' ', '| / - \\ | / - \\');
        }
        static $spinnerPhase = 0;
        static $terminalLineLength = 80;
        // Clear line
        echo "\r" . str_repeat(' ', $terminalLineLength);
        // Show spinner phase and status
        $time = $timer->get();
        if ($time >= 1) {
            $timeSpent = timeIntervalStr($timer->get());
        } else {
            $timeSpent = '-';
        }
        $timeSpentText = $GColors->getColoredString("[{$timeSpent}]", $GTimeTextColor);
        $statusText = $GColors->getColoredString($GStatusText, $GStatusTextColor);
        $memUsage = formatBytes(memory_get_usage(true));
        $memUsageText = $GColors->getColoredString("[{$memUsage}]", 'yellow');
        echo "\r{$spinnerChars[$spinnerPhase]} {$timeSpentText} {$memUsageText} {$statusText}";
        // Change phase
        $spinnerPhase = $spinnerPhase < count($spinnerChars) - 1 ? $spinnerPhase + 1 : 0;
    }
);

$GScriptTimer = new Timer(1);
register_shutdown_function(function () use ($GScriptTimer, $GColors) {
        $time = $GScriptTimer->get();
        if ($time >= 1) {
            $timeSpent = timeIntervalStr($time);
        } else {
            $timeSpent = 'less then a second';
        }

        if (is_callable('beforeShutdown')) {
            beforeShutdown();
        }

        $timeText = $GColors->getColoredString($timeSpent, 'light_blue');
        $doneMsg = " DONE. Time spent: {$timeText} ";

        $doneText = str_repeat('*', 3) . $doneMsg;
        echo $GColors->getColoredString("\n{$doneText}\n", 'light_green');
    }
);
