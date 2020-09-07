<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 */
final class User implements UserInterface
{
    const USER_ROLES = [
      'admin' => 'admin',
      'host' => 'host',
      'guest' => 'guest',
      'both' => 'both',
    ];

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(type="string", length=100, unique=true) */
    private $username;

    /** @ORM\Column(type="string", length=255) */
    private $password;

    /** @ORM\Column(type="string", length=100) */
    private $firstName;

    /** @ORM\Column(type="string", length=100) */
    private $lastName;

    /** @ORM\Column(type="string", length=100) */
    private $email;

    /** @return mixed */
    public function getId()
    {
        return $this->id;
    }

    /** @param mixed $id */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /** @return string */
    public function getUsername(): string
    {
        return $this->username;
    }

    /** @param string $username */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /** @return mixed */
    public function getPassword()
    {
        return $this->password;
    }

    /** @param mixed $password */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /** @return mixed */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /** @param mixed $firstName */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /** @return mixed */
    public function getLastName()
    {
        return $this->lastName;
    }

    /** @param mixed $lastName */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /** @return mixed */
    public function getEmail()
    {
        return $this->email;
    }

    /** @param mixed $email */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /** @return mixed */
    public function getPhone()
    {
        return $this->phone;
    }

    /** @param mixed $phone */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /** @return mixed */
    public function getRole()
    {
        return $this->role;
    }

    /** @param mixed $role */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /** @return mixed */
    public function getPhoto()
    {
        return $this->photo;
    }

    /** @param mixed $photo */
    public function setPhoto($photo): void
    {
        $this->photo = $photo;
    }

    /** @ORM\Column(type="string", length=13) */
    private $phone;

    //TODO: Do we need an anonymous user role? Do we need both user role ?
    /** @ORM\Column(
     *     type="string",
     *     length=100,
     *     columnDefinition="ENUM(
     *      'admin',
     *      'host,
     *      'guest,
     *      'both'
     *     )"
     * )
     */
    private $role;

    /** @ORM\Column(type="string") */
    private $photo;

    /** @ORM\Column(type="datetime") */
    private $createdAt;

    /** @ORM\Column(type="datetime") */
    private $updatedAt;

    public function __construct(string $username)
    {
        $this->username = $username;
    }

    /** @return mixed */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    //TODO: Why return self ??
    /** @param mixed $createdAt */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /** @return mixed */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /** @param mixed $updatedAt */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    //TODO: Do we need it ?
    /**
     * @return string|null
     */
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        // No action
    }

    public function getRoles()
    {
        return self::USER_ROLES;
    }
}
