<?php

class Account
{
    const OID = 'oid';

    const DATABASE_NAME = 'innoTech';
    const COLLECTION_NAME = 'account';
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const NAME = 'name';
    const EMAIL = 'email';
    const CREATED_AT = 'created_at';
    const ACTIVE = 'active';
    const ID = '_id';

    public $username;
    public $password;
    public $name;
    public $email;
    public $created_at;
    public $active;
    public $id;


    public static function authenticate(string $login, string $password):Account
    {

        $collection = Account::getCollection(self::DATABASE_NAME, self::COLLECTION_NAME);

        $criteria = array('$or' => array(
            array(self::USERNAME => $login),
            array(self::EMAIL => $login)
        ));

        $fields = array(
            self::USERNAME,
            self::PASSWORD,
            self::NAME,
            self::EMAIL,
            self::CREATED_AT,
            self::ACTIVE,
            self::ID,
        );

        $record = $collection->findOne($criteria, $fields);
        $candidate = self::RecordToAccount($record);

        $isSuccess = password_verify($password, $candidate->password);
        $result = new Account();
        if ($isSuccess) {
            $result = $candidate;
        }

        return $result;

    }

    /**
     * @param $candidate
     * @return Account
     */
    public static function RecordToAccount($candidate):Account
    {
        $isSuccess = !empty($candidate);
        $account = new Account();
        if ($isSuccess) {

            foreach ($candidate as $key => $element) {
                switch ($key) {
                    case self::USERNAME:
                        $account->username = $element;
                        break;
                    case self::PASSWORD:
                        $account->password = $element;
                        break;
                    case self::NAME:
                        $account->name = $element;
                        break;
                    case self::EMAIL:
                        $account->email = $element;
                        break;
                    case self::CREATED_AT:
                        $account->created_at = $element;
                        break;
                    case self::ACTIVE:
                        $account->active = $element;
                        break;
                    case self::ID:
                        $idObject = $element;
                        $account->id = $idObject;

                        $isObject = is_object($idObject);
                        if ($isObject) {
                            foreach ($idObject as $index => $objectElement) {
                                if ($index == self::OID) {
                                    $account->id = $objectElement;
                                }
                            }
                        }

                        break;
                }
            }
        }
        return $account;
    }

    public static function RecordToArray($account):array
    {
        $isSuccess = !empty($account);
        $fields = array();
        if ($isSuccess) {

            foreach ($account as $key => $element) {

                if ($key == self::ID) {

                    $idObject = $element;
                    $fields[self::ID] = $idObject;

                    $isObject = is_object($idObject);
                    if ($isObject) {
                        foreach ($idObject as $index => $objectElement) {
                            if ($index == self::OID) {
                                $fields[self::ID] = $objectElement;
                            }
                        }
                    }

                }
                if ($key != self::ID) {
                    $fields[$key] = $element;
                }

            }
        }
        return $fields;
    }

    public function register():bool
    {

        $collection = Account::getCollection(self::DATABASE_NAME, self::COLLECTION_NAME);

        $affected = $collection->insertOne(
            [self::USERNAME => $this->username,
                self::PASSWORD => $this->password,
                self::NAME => $this->name,
                self::EMAIL => $this->email,
                self::CREATED_AT => $this->created_at,
                self::ACTIVE => $this->active,

            ]);

        $isAcknowledged = $affected->isAcknowledged();
        $insertCount = 0;
        if ($isAcknowledged) {
            $insertCount = $affected->getInsertedCount();
        }

        $isSuccess = $insertCount > 0;
        if ($isSuccess) {
            $this->id = $affected->getInsertedId();
        }

        $isSuccess = !empty($this->id);

        return $isSuccess;
    }

    /** Get object for interact collection
     * @param string $databaseName
     * @param string $collectionName
     * @return \MongoDB\Collection
     */
    private static function getCollection(string $databaseName, string $collectionName):\MongoDB\Collection
    {

        $client = new MongoDB\Client("mongodb://localhost:27017");
        $collection = $client->selectCollection($databaseName, $collectionName);

        return $collection;
    }

    /** Присваиает значение элемента с заданным индексом
     * @param $thisArray mixed массив элементов
     * @param string $arrayIndex индекс элемента
     * @return string значение элемента с индексом
     */
    private static function setIfExists($thisArray, string $arrayIndex)
    {
        $isExists = false;
        $isSuccess = is_array($thisArray);
        if ($isSuccess) {
            $isExists = array_key_exists($arrayIndex, $thisArray);
        }

        $value = '';
        if ($isExists) {
            $value = $thisArray[$arrayIndex];
        }
        return $value;
    }

    public static function findAll()
    {
        $collection = Account::getCollection(self::DATABASE_NAME, self::COLLECTION_NAME);
        $records = $collection->find();

        return $records;
    }
}

