<?php

/**
 * Class User
 *
 * @package User
 * @copyright: coeus-solutions.de
 * @version 1.0
 * @author Coeus Solutions
 *
 */

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="`users`")
 * @ORM\Entity
 */
class User
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=100, nullable=false, unique=true)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="pass_word", type="string", length=60, nullable=false)
     */
    protected $pass_word;

    /**
     * @var string
     *
     * @ORM\Column(name="activation_code", type="string", length=32, nullable=false)
     */
    protected $activationCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    protected $isActive = 0;

    /**
     * @var \User\Entity\Group
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\Group", inversedBy="user")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $group;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="User\Entity\UserPhone", mappedBy="user")
     */
    protected $phones;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="User\Entity\UserEmail", mappedBy="user")
     */
    protected $emails;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="User\Entity\UserWebsite", mappedBy="user")
     */
    protected $websites;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Company\Entity\Company", mappedBy="user")
     */
    protected $company;

    /**
     * The contructor
     *
     * @author Stoyan Rangelov
     */
    public function __construct()
    {
        $this->phones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->websites = new \Doctrine\Common\Collections\ArrayCollection();
        $this->company = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany(\Doctrine\Common\Collections\Collection $company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * Get id
     *
     * @author Stoyan Rangelov
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get login
     *
     * @author Stoyan Rangelov
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Get password hash
     *
     * @author Stoyan Rangelov
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Get activation code
     *
     * @author Stoyan Rangelov
     * @return string
     */
    public function getActivationCode()
    {
        return $this->activationCode;
    }

    /**
     * Get created at
     *
     * @author Stoyan Rangelov
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }


    /**
     * Set id
     *
     * @author Stoyan Rangelov
     * @param integer $id
     * @return \User\Entity\User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


}
