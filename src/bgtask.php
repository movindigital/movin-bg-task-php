<?php

namespace movin\movin_bg_task_php;

/**
 *
 * movin-bg-task-php runs an background php script under Linux/Windows enviroment
 *
 * @author Fernando
 */
class BgTask
{
    /** @var string */
    private $pathToScript;

    /**
     * Constructor.
     *
     * @param string Path to php script to execute
     */
    public function __construct($pathToScript)
    {
        $this->pathToScript = $pathToScript;
    }

    /**
     * Executes the php script in a background process.
     *
     * @param string $outputFile File to write the output of the process to; defaults to /dev/null
     *
     * @return void
     */
    public function run($outputFile = '/dev/null')
    {
		$so = strtolower(php_uname('s'));
		
		if(strpos($so, 'windows') === FALSE){
			$this->pid = shell_exec(sprintf(
	            '%s > %s 2>&1 & echo $!',
	            'php ' . $this->pathToScript,
	            $outputFile
	        ));
		}
		else{
			$WshShell = new \COM("WScript.Shell");
			$oExec = $WshShell->Run("php -f \"" . $this->pathToScript . "\"", 0, false);
		}
		
    }
}
?>