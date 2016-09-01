<?php

  namespace Vaszev\CrudBundle\Entity;

  use Doctrine\ORM\Mapping as ORM;
  use Doctrine\ORM\Mapping\GeneratedValue;
  use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
  use Doctrine\ORM\Mapping\MappedSuperclass;

//use Knp\DoctrineBehaviors\Model as ORMBehaviors;

  /**
   * @MappedSuperclass
   * @HasLifecycleCallbacks
   */
  class Base implements SoftDeleteInterface {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deleted;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $edited;



    public function __construct() {
      if ($this->isNew()) {
        $this->created = $this->edited = new \DateTime ();
      }
    }



    /**
     * Get the entity id
     * @return int
     */
    public function getId() {
      return ( int )$this->id;
    }



    /**
     * Get the time of deletion
     * @return \DateTime|null
     */
    public function getDeleted() {
      return $this->deleted;
    }



    /**
     * Get the time of creation
     * @return \DateTime
     */
    public function getCreated() {
      return $this->created;
    }



    /**
     * Get the time of edition
     * @return \DateTime
     */
    public function getEdited() {
      return $this->edited;
    }



    /**
     * Check if the entity is new
     * @return bool
     */
    public function isNew() {
      return (empty ($this->id));
    }



    /**
     * Set the time of deletion
     * @param \DateTime $deleted
     */
    public function setDeleted(\DateTime $deleted = null) {
      $this->deleted = $deleted;

      return $this;
    }



    /**
     * Set the time of creation
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created) {
      $this->created = $created;

      return $this;
    }



    /**
     * Set the time of edition
     * @param \DateTime $edited
     */
    public function setEdited(\DateTime $edited) {
      $this->edited = $edited;

      return $this;
    }



    /**
     * Set the time of edition
     * @param \DateTime $edited
     * @ORM\PreUpdate
     */
    public function updateEdited() {
      $this->edited = new \DateTime ();
    }



    /**
     * Bind data
     * @param array $array
     */
    public function bind($array) {
      $ref = new \ReflectionClass ($this);
      $pros = $ref->getDefaultProperties();
      foreach (array_intersect_key($array, $pros) as $key => $value) {
        if (is_string($value)) {
          $value = trim($value);
        }
        $method = "set" . ucfirst($key);
        $ref->hasMethod($method) ? $this->{$method} ($value) : $this->{$key} = $value;
      }

      return $this;
    }

  }
