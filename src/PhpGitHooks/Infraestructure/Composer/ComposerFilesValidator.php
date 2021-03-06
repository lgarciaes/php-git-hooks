<?php

namespace PhpGitHooks\Infraestructure\Composer;

use PhpGitHooks\Infraestructure\Common\ToolHandler;

/**
 * Class ComposerFilesValidator
 * @package PhpGitHooks\Infraestructure\Composer
 */
class ComposerFilesValidator extends ToolHandler
{
    /** @var array  */
    private $files;

    public function validate()
    {
        $this->outputHandler->setTitle('Checking composer files');
        $this->output->write($this->outputHandler->getTitle());

        $composerJsonDetected = false;
        $composerLockDetected = false;

        foreach ($this->files as $file) {
            if ($file === 'composer.json') {
                $composerJsonDetected = true;
            }

            if ($file === 'composer.lock') {
                $composerLockDetected = true;
            }
        }

        if ($composerJsonDetected && !$composerLockDetected) {
            throw new ComposerJsonNotCommitedException();
        }

        $this->output->writeln($this->outputHandler->getSuccessfulStepMessage());
    }

    /**
     * @param array $files
     */
    public function setFiles(array $files)
    {
        $this->files = $files;
    }
}
