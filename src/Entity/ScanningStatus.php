<?php declare(strict_types=1);

namespace PouleR\LinkfireAPI\Entity;

/**
 * Class ScanningStatus
 */
class ScanningStatus
{
    private string $linkStatus = '';
    private int $totalNumbersOfSteps = 0;
    private int $currentStepNumber = 0;
    private string $currentAction = '';
    private bool $isComplete = false;

    /**
     * @return string
     */
    public function getLinkStatus(): string
    {
        return $this->linkStatus;
    }

    /**
     * @param string $linkStatus
     */
    public function setLinkStatus(string $linkStatus): void
    {
        $this->linkStatus = $linkStatus;
    }

    /**
     * @return int
     */
    public function getTotalNumbersOfSteps(): int
    {
        return $this->totalNumbersOfSteps;
    }

    /**
     * @param int $totalNumbersOfSteps
     */
    public function setTotalNumbersOfSteps(int $totalNumbersOfSteps): void
    {
        $this->totalNumbersOfSteps = $totalNumbersOfSteps;
    }

    /**
     * @return int
     */
    public function getCurrentStepNumber(): int
    {
        return $this->currentStepNumber;
    }

    /**
     * @param int $currentStepNumber
     */
    public function setCurrentStepNumber(int $currentStepNumber): void
    {
        $this->currentStepNumber = $currentStepNumber;
    }

    /**
     * @return string
     */
    public function getCurrentAction(): string
    {
        return $this->currentAction;
    }

    /**
     * @param string $currentAction
     */
    public function setCurrentAction(string $currentAction): void
    {
        $this->currentAction = $currentAction;
    }

    /**
     * @return bool
     */
    public function isComplete(): bool
    {
        return $this->isComplete;
    }

    /**
     * @param bool $isComplete
     */
    public function setIsComplete(bool $isComplete): void
    {
        $this->isComplete = $isComplete;
    }
}
