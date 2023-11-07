<?php

namespace Paysera\WalletApi;

use DateTime;
use Exception;
use Paysera_WalletApi_Entity_ClientWalletPermissions;
use Paysera_WalletApi_Entity_Location_SearchFilter;
use Paysera_WalletApi_Entity_Transaction;
use Paysera_WalletApi_Entity_User_Identity;
use Paysera_WalletApi_Exception_LogicException;
use Paysera_WalletApi_Mapper;
use Paysera_WalletApi_Mapper_IdentityMapper;

class MapperTest extends \PHPUnit_Framework_TestCase
{
    private $mapper;

    public function setUp()
    {
        $this->mapper = new Paysera_WalletApi_Mapper();
        parent::setUp();
    }

    public function testMapperJoinsLocationSearchFilterStatusesArray()
    {
        $filter = new Paysera_WalletApi_Entity_Location_SearchFilter();
        $filter->setStatuses(['a','b']);

        $mapper = new Paysera_WalletApi_Mapper();
        $encoded = $mapper->encodeLocationFilter($filter);

        $statuses = explode(',', $encoded['status']);
        $this->assertCount(2, $statuses);
        $this->assertContains('a', $statuses);
        $this->assertContains('b', $statuses);
    }

    public function testIdentityMapperEncoding()
    {
        $identity = new Paysera_WalletApi_Entity_User_Identity();
        $identity
            ->setName('Name')
            ->setSurname("Surname")
            ->setCode(9999999)
            ->setNationality("LT")
        ;

        $mapper = new Paysera_WalletApi_Mapper_IdentityMapper();
        $result = $mapper->mapFromEntity($identity);

        $this->assertSame($identity->getName(), $result['name']);
        $this->assertSame($identity->getSurname(), $result['surname']);
        $this->assertSame($identity->getCode(), $result['code']);
        $this->assertSame($identity->getNationality(), $result['nationality']);
    }

    public function testIdentityMapperDecoding()
    {
        $identity = [
            'name' => 'Name',
            'surname' => 'Surname',
            'code' => 9999999,
            'nationality' => 'LT'
        ];

        $mapper = new Paysera_WalletApi_Mapper_IdentityMapper();
        $result = $mapper->mapToEntity($identity);

        $this->assertSame($identity['name'], $result->getName());
        $this->assertSame($identity['surname'], $result->getSurname());
        $this->assertSame($identity['code'], $result->getCode());
        $this->assertSame($identity['nationality'], $result->getNationality());
    }

    public function testDecodesTransactionWithReserveUntil()
    {
        $until = new DateTime('+1 day');
        $data = [
            'transaction_key' => 'abc',
            'created_at' => (new DateTime('-1 day'))->getTimestamp(),
            'status' => Paysera_WalletApi_Entity_Transaction::STATUS_NEW,
            'reserve' => [
                'until' => $until->getTimestamp(),
            ],
        ];

        $mapper = new Paysera_WalletApi_Mapper();
        $transaction = $mapper->decodeTransaction($data);

        $this->assertEquals($until->getTimestamp(), $transaction->getReserveUntil()->getTimestamp());
    }

    public function testDecodesTransactionWithReserveFor()
    {
        $for = 10;
        $data = [
            'transaction_key' => 'abc',
            'created_at' => (new DateTime('-1 day'))->getTimestamp(),
            'status' => Paysera_WalletApi_Entity_Transaction::STATUS_NEW,
            'reserve' => [
                'for' => $for,
            ],
        ];

        $mapper = new Paysera_WalletApi_Mapper();
        $transaction = $mapper->decodeTransaction($data);

        $this->assertEquals($for, $transaction->getReserveFor());
    }

    public function testDecodesPep()
    {
        $data = [
            'name' => 'nameValue',
            'relation' => 'relationValue',
            'positions' => [
                'positionAValue',
            ],
        ];

        $mapper = new Paysera_WalletApi_Mapper();
        $pepObj = $mapper->decodePep($data);
        self::assertEquals('nameValue', $pepObj->getName());
        self::assertEquals('relationValue', $pepObj->getRelation());
        self::assertEquals('positionAValue', $pepObj->getPositions()[0]);
    }

    /**
     * @param $input
     * @param $expected
     * @return void
     * @dataProvider decodeClientWalletPermissionsDataProvider
     */
    public function testDecodeClientWalletPermissions($input, $expected)
    {
        self::assertEquals($expected, $this->mapper->decodeClientWalletPermissions($input));
    }

    /**
     * @param $input
     * @param $expected
     * @return void
     * @dataProvider encodeClientWalletPermissionsDataProvider
     * @throws Paysera_WalletApi_Exception_LogicException
     */
    public function testEncodeClientWalletPermissions($input, $expected)
    {
        if ($expected instanceof Exception) {
            self::setExpectedException(get_class($expected), $expected->getMessage());
        }
        self::assertEquals($expected, $this->mapper->encodeClientWalletPermissions($input));
    }

    public function decodeClientWalletPermissionsDataProvider()
    {
        return [
            'case_1_empty_scopes' => [
                'input' => [
                    'id' => 1,
                    'account' => 'EVP1',
                    'balance' => false,
                    'statements' => false,
                ],
                'expected' => Paysera_WalletApi_Entity_ClientWalletPermissions::create()
                    ->setWalletId(1)
                    ->setAccountNumber('EVP1')
                    ->setScopes([]),
            ],
            'case_2_balance_only' => [
                'input' => [
                    'id' => 1,
                    'account' => 'EVP1',
                    'balance' => true,
                    'statements' => false,
                ],
                'expected' => Paysera_WalletApi_Entity_ClientWalletPermissions::create()
                    ->setWalletId(1)
                    ->setAccountNumber('EVP1')
                    ->setScopes([Paysera_WalletApi_Entity_ClientWalletPermissions::SCOPE_BALANCE]),
            ],
            'case_3_statements_only' => [
                'input' => [
                    'id' => 1,
                    'account' => 'EVP1',
                    'balance' => false,
                    'statements' => true,
                ],
                'expected' => Paysera_WalletApi_Entity_ClientWalletPermissions::create()
                    ->setWalletId(1)
                    ->setAccountNumber('EVP1')
                    ->setScopes([Paysera_WalletApi_Entity_ClientWalletPermissions::SCOPE_STATEMENTS]),
            ],
            'case_4_balance_and_statements' => [
                'input' => [
                    'id' => 1,
                    'account' => 'EVP1',
                    'balance' => true,
                    'statements' => true,
                ],
                'expected' => Paysera_WalletApi_Entity_ClientWalletPermissions::create()
                    ->setWalletId(1)
                    ->setAccountNumber('EVP1')
                    ->setScopes([
                        Paysera_WalletApi_Entity_ClientWalletPermissions::SCOPE_BALANCE,
                        Paysera_WalletApi_Entity_ClientWalletPermissions::SCOPE_STATEMENTS,
                    ]),
            ],
        ];
    }

    public function encodeClientWalletPermissionsDataProvider()
    {
        return [
            'case_1_exception' => [
                'input' => Paysera_WalletApi_Entity_ClientWalletPermissions::create()
                    ->setAccountNumber('EVP1')
                    ->setScopes([]),
                'expected' => new Paysera_WalletApi_Exception_LogicException('Wallet ID must be provided'),
            ],
            'case_2_empty_scopes' => [
                'input' => Paysera_WalletApi_Entity_ClientWalletPermissions::create()
                    ->setWalletId(1)
                    ->setAccountNumber('EVP1')
                    ->setScopes([]),
                'expected' => [
                    'wallet' => 1,
                    'account_number' => 'EVP1',
                    'scopes' => [],
                ],
            ],
            'case_3_balance_only' => [
                'input' => Paysera_WalletApi_Entity_ClientWalletPermissions::create()
                    ->setWalletId(1)
                    ->setAccountNumber('EVP1')
                    ->setScopes([Paysera_WalletApi_Entity_ClientWalletPermissions::SCOPE_BALANCE]),
                'expected' => [
                    'wallet' => 1,
                    'account_number' => 'EVP1',
                    'scopes' => [Paysera_WalletApi_Entity_ClientWalletPermissions::SCOPE_BALANCE],
                ],
            ],
            'case_4_statements_only' => [
                'input' => Paysera_WalletApi_Entity_ClientWalletPermissions::create()
                    ->setWalletId(1)
                    ->setAccountNumber('EVP1')
                    ->setScopes([Paysera_WalletApi_Entity_ClientWalletPermissions::SCOPE_STATEMENTS]),
                'expected' => [
                    'wallet' => 1,
                    'account_number' => 'EVP1',
                    'scopes' => [Paysera_WalletApi_Entity_ClientWalletPermissions::SCOPE_STATEMENTS],
                ],
            ],
            'case_5_balance_and_statements' => [
                'input' => Paysera_WalletApi_Entity_ClientWalletPermissions::create()
                    ->setWalletId(1)
                    ->setAccountNumber('EVP1')
                    ->setScopes([
                        Paysera_WalletApi_Entity_ClientWalletPermissions::SCOPE_BALANCE,
                        Paysera_WalletApi_Entity_ClientWalletPermissions::SCOPE_STATEMENTS,
                    ]),
                'expected' => [
                    'wallet' => 1,
                    'account_number' => 'EVP1',
                    'scopes' => [
                        Paysera_WalletApi_Entity_ClientWalletPermissions::SCOPE_BALANCE,
                        Paysera_WalletApi_Entity_ClientWalletPermissions::SCOPE_STATEMENTS,
                    ],
                ],
            ],
        ];
    }
}
