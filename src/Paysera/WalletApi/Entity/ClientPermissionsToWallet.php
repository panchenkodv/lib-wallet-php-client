<?php

/**
 * Paysera_WalletApi_Entity_ClientPermissionsToWallet
 */
class Paysera_WalletApi_Entity_ClientPermissionsToWallet
{
    /**
     * @var int
     */
    protected $walletId;

    /**
     * @var string
     */
    protected $accountNumber;

    /**
     * @var array
     */
    protected $scopes = [];

    /**
     * @return self
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param int $walletId
     * @return self
     */
    public function setWalletId($walletId)
    {
        $this->walletId = $walletId;

        return $this;
    }

    /**
     * @return int
     */
    public function getWalletId()
    {
        return $this->walletId;
    }

    /**
     * @param string $accountNumber
     * @return self
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set scopes
     *
     * @param array $scopes
     *
     * @return self
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;

        return $this;
    }

    /**
     * Get scopes
     *
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @return bool
     */
    public function isBalanceGranted()
    {
        return $this->isGranted(Paysera_WalletApi_OAuth_Consumer::SCOPE_BALANCE);
    }

    /**
     * @return bool
     */
    public function isStatementsGranted()
    {
        return $this->isGranted(Paysera_WalletApi_OAuth_Consumer::SCOPE_STATEMENTS);
    }

    /**
     * @return self
     */
    public function grantBalance()
    {
        return $this->grant(Paysera_WalletApi_OAuth_Consumer::SCOPE_BALANCE);
    }

    /**
     * @return self
     */
    public function grantStatements()
    {
        return $this->grant(Paysera_WalletApi_OAuth_Consumer::SCOPE_STATEMENTS);
    }

    /**
     * @return self
     */
    public function revokeBalance()
    {
        return $this->revoke(Paysera_WalletApi_OAuth_Consumer::SCOPE_BALANCE);
    }

    /**
     * @return self
     */
    public function revokeStatements()
    {
        return $this->revoke(Paysera_WalletApi_OAuth_Consumer::SCOPE_STATEMENTS);
    }

    /**
     * Method to check if scope is granted
     *
     * @param string $scope
     *
     * @return bool
     */
    public function isGranted($scope)
    {
        return in_array($scope, $this->scopes);
    }

    /**
     * Revoke
     *
     * @param string $scope
     *
     * @return self
     */
    protected function revoke($scope)
    {
        $index = array_search($scope, $this->scopes);

        if ($index !== false) {
            unset($this->scopes[$index]);
        }

        return $this;
    }

    /**
     * Grant
     *
     * @param string $scope
     *
     * @return self
     */
    protected function grant($scope)
    {
        if (!$this->isGranted($scope)) {
            $this->scopes[] = $scope;
        }

        return $this;
    }
}
