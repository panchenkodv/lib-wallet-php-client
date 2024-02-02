<?php

/**
 * Entity representing Client
 */
class Paysera_WalletApi_Entity_Client
{
    const TYPE_PRIVATE_CLIENT = 'private_client';
    const TYPE_APPLICATION = 'application';
    const TYPE_APP_CLIENT = 'app_client';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     * @readonly
     */
    protected $title;

    /**
     * @var Paysera_WalletApi_Entity_ClientPermissions
     */
    protected $permissions;

    /**
     * @var Paysera_WalletApi_Entity_Client_Host[]
     */
    protected $hosts = array();

    /**
     * @var string
     */
    protected $type;

    /**
     * @var Paysera_WalletApi_Entity_Project
     */
    protected $mainProject;

    /**
     * @var int
     */
    protected $mainProjectId;

    /**
     * @var int
     */
    protected $serviceAgreementId;

    /**
     * @var Paysera_WalletApi_Entity_MacCredentials
     */
    protected $credentials;

    /**
     * @var Paysera_WalletApi_Entity_ClientPermissionsToWallet[]
     */
    protected $permissionsToWallets;

    public function __construct()
    {
        $this->permissions = new Paysera_WalletApi_Entity_ClientPermissions();
        $this->permissionsToWallets = [];
    }

    /**
     * @return self
     */
    static public function create()
    {
        return new static();
    }

    /**
     * Set id
     *
     * @param int $id
     *
     * @return Paysera_WalletApi_Entity_Client
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set permissions
     *
     * @param \Paysera_WalletApi_Entity_ClientPermissions $permissions
     *
     * @return Paysera_WalletApi_Entity_Client
     */
    public function setPermissions(Paysera_WalletApi_Entity_ClientPermissions $permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * Get permissions
     *
     * @return \Paysera_WalletApi_Entity_ClientPermissions
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Set mainProject
     *
     * @param \Paysera_WalletApi_Entity_Project $mainProject
     *
     * @return Paysera_WalletApi_Entity_Client
     */
    public function setMainProject($mainProject)
    {
        $this->mainProject = $mainProject;

        return $this;
    }

    /**
     * Get mainProject
     *
     * @return \Paysera_WalletApi_Entity_Project
     */
    public function getMainProject()
    {
        return $this->mainProject;
    }

    /**
     * Set mainProjectId
     *
     * @param int $mainProjectId
     *
     * @return Paysera_WalletApi_Entity_Client
     */
    public function setMainProjectId($mainProjectId)
    {
        $this->mainProjectId = $mainProjectId;

        return $this;
    }

    /**
     * Get mainProjectId
     *
     * @return int
     */
    public function getMainProjectId()
    {
        return $this->mainProjectId;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Paysera_WalletApi_Entity_Client
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set hosts
     *
     * @param \Paysera_WalletApi_Entity_Client_Host[] $hosts
     *
     * @return Paysera_WalletApi_Entity_Client
     */
    public function setHosts(array $hosts)
    {
        $this->hosts = $hosts;

        return $this;
    }

    /**
     * Get hosts
     *
     * @return \Paysera_WalletApi_Entity_Client_Host[]
     */
    public function getHosts()
    {
        return $this->hosts;
    }

    /**
     * Set credentials
     *
     * @param \Paysera_WalletApi_Entity_MacCredentials $credentials
     *
     * @return Paysera_WalletApi_Entity_Client
     */
    public function setCredentials(Paysera_WalletApi_Entity_MacCredentials $credentials)
    {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * Get credentials
     *
     * @return \Paysera_WalletApi_Entity_MacCredentials
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @return int
     */
    public function getServiceAgreementId()
    {
        return $this->serviceAgreementId;
    }

    /**
     * @param int $serviceAgreementId
     *
     * @return $this
     */
    public function setServiceAgreementId($serviceAgreementId)
    {
        $this->serviceAgreementId = $serviceAgreementId;

        return $this;
    }

    /**
     * @return Paysera_WalletApi_Entity_ClientPermissionsToWallet[]
     */
    public function getPermissionsToWallets()
    {
        return $this->permissionsToWallets;
    }

    /**
     * @param Paysera_WalletApi_Entity_ClientPermissionsToWallet[] $permissionsToWallets
     * @return self
     */
    public function setPermissionsToWallets($permissionsToWallets)
    {
        $this->permissionsToWallets = $permissionsToWallets;

        return $this;
    }

    /**
     * @param Paysera_WalletApi_Entity_ClientPermissionsToWallet $permissionsToWallet
     * @return self
     */
    public function addPermissionsToWallet(Paysera_WalletApi_Entity_ClientPermissionsToWallet $permissionsToWallet)
    {
        $this->permissionsToWallets[] = $permissionsToWallet;

        return $this;
    }
}
