<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="address")
 */
class Address
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    protected $street;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $zip;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $country;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $phoneNo;

    /**
     * @ORM\Column(type="date")
     */
    protected $birthday;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $email;
}
