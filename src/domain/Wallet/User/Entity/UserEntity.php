<?php


namespace Payment\Wallet\User\Entity;


class UserEntity implements UserEntityInterface
{
    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var array
     */
    private $address;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phoneNumber;

    /**
     * @var string
     */
    private $mobileNumber;

    /**
     * @var string
     */
    private $language;

    /**
     * @var array
     */
    private $walletOrganizations;

    /**
     * @var string
     */
    private $userId;

    /**
     * UserEntity constructor.
     * @param string|null $lastName
     * @param string|null $firstName
     * @param array|null $address
     * @param string|null $email
     * @param string|null $phoneNumber
     * @param string|null $mobileNumber
     * @param string|null $language
     * @param array|null $walletOrganizations
     * @param string|null $userId
     */
    public function __construct(
        ?string $lastName,
        ?string $firstName,
        ?array $address,
        ?string $email,
        ?string $phoneNumber,
        ?string $mobileNumber,
        ?string $language,
        ?array $walletOrganizations,
        ?string $userId){
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->address = $address;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->mobileNumber = $mobileNumber;
        $this->language = $language;
        $this->walletOrganizations = $walletOrganizations;
        $this->userId = $userId;
    }

    public static function fromArray(
        array $data
    ){
        return new static(
            $data['lastName'] ?? null,
            $data['firstName'] ?? null,
            $data['address'] ?? null,
            $data['email'] ?? null,
            $data['phoneNumber'] ?? null,
            $data['mobileNumber'] ?? null,
            $data['language'] ?? null,
            $data['walletOrganizations'] ?? null,
            $data['userId'] ?? null
        );
    }

}
