<?php

namespace Hub\NewsBundle\Entity;

use Hub\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Hub\NewsBundle\Entity\CrudItem
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Hub\NewsBundle\Entity\CrudItemRepository")
 */
class CrudItem
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $subject
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var text $body
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var datetimetz $date_created
     *
     * @ORM\Column(name="date_created", type="datetimetz")
     */
    private $date_created;

    /**
     * @ORM\ManyToOne(targetEntity="Hub\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     *
     * @var User $user
     */
    private $author;

    /**
     * @var boolean $visible
     *
     * @ORM\Column(name="visible", type="boolean")
     */
    private $visible;

    public function __construct()
    {
        $this->setDateCreated(new \DateTime());
        $this->setVisible(false);
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set subject
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body
     *
     * @param text $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Get body
     *
     * @return text 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set date_created
     *
     * @param datetimetz $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;
    }

    /**
     * Get date_created
     *
     * @return datetimetz 
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Set author
     *
     * @param User $author
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    /**
     * Get author
     *
     * @return User 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
    }
}