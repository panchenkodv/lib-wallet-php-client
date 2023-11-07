<?php

/**
 * Paysera_WalletApi_Entity_ClientWalletPermissions
 */
class Paysera_WalletApi_Entity_ClientWalletPermissions
{
    /**
     * Scopes
     */
    const SCOPE_BALANCE = 'balance';
    const SCOPE_STATEMENTS = 'statements';

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
    protected $scopes = array();

    /**
     * @return Paysera_WalletApi_Entity_ClientWalletPermissions
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param int $walletId
     * @return Paysera_WalletApi_Entity_ClientWalletPermissions
     */
    public function setWalletId(int $walletId)
    {
        $this->walletId = $walletId;

        return $this;
    }

    /**
     * @return int
     */
    public function getWalletId(): int
    {
        return $this->walletId;
    }

    /**
     * @param string $accountNumber
     * @return Paysera_WalletApi_Entity_ClientWalletPermissions
     */
    public function setAccountNumber(string $accountNumber)
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
     * @return Paysera_WalletApi_Entity_ClientWalletPermissions
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
        return $this->isGranted(self::SCOPE_BALANCE);
    }

    /**
     * @return bool
     */
    public function isStatementsGranted()
    {
        return $this->isGranted(self::SCOPE_STATEMENTS);
    }

    /**
     * @return Paysera_WalletApi_Entity_ClientWalletPermissions
     */
    public function grantBalance()
    {
        return $this->grant(self::SCOPE_BALANCE);
    }

    /**
     * @return Paysera_WalletApi_Entity_ClientWalletPermissions
     */
    public function grantStatements()
    {
        return $this->grant(self::SCOPE_STATEMENTS);
    }

    /**
     * @return Paysera_WalletApi_Entity_ClientWalletPermissions
     */
    public function revokeBalance()
    {
        return $this->revoke(self::SCOPE_BALANCE);
    }

    /**
     * @return Paysera_WalletApi_Entity_ClientWalletPermissions
     */
    public function revokeStatements()
    {
        return $this->revoke(self::SCOPE_STATEMENTS);
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
     * @return Paysera_WalletApi_Entity_ClientWalletPermissions
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
     * @return Paysera_WalletApi_Entity_ClientWalletPermissions
     */
    protected function grant($scope)
    {
        if (!$this->isGranted($scope)) {
            $this->scopes[] = $scope;
        }

        return $this;
    }
}
