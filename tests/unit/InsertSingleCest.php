<?php

use Doctrine\DBAL\DriverManager;
use Pharako\DBAL\Connection;

class InsertSingleCest
{
    public function _before(UnitTester $I)
    {
        $this->dbal = new Connection(DriverManager::getConnection([
            'dbname' => 'testdb',
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'driver' => 'pdo_mysql'
        ]));

        $this
            ->dbal
            ->getConfiguration()
            ->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
    }

    public function _after(UnitTester $I)
    {
    }

    /**
     * @group insert
     * @group single
     */
    public function insertSingleTest(UnitTester $I)
    {
        $hero = [
            'name' => 'Coxo',
            'pseudonym' => null,
            'date_of_birth' => '1800-04-04',
            'genociders_knocked_down' => 100
        ];

        $this->dbal->insert('heroes', $hero);

        $I->seeInDatabase('heroes', $hero);
    }

    /**
     * Passing an array with Doctrine types guarantees parameter binding
     * @group insert
     * @group single
     */
    public function insertSingleWitTypesTest(UnitTester $I)
    {
        $hero = ['name' => 'Pindobusu', 'genociders_knocked_down' => 100];

        $this->dbal->insert('heroes', $hero, ['string', 'integer']);

        $I->seeInDatabase('heroes', $hero);
    }
}