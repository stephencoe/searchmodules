<?php
 
namespace SearchModules\Entity;
 
use Doctrine\ORM\Mapping as ORM,
    Gedmo\Mapping\Annotation as Gedmo;
 
/**
 * An image
 *
 * @ORM\Entity
 * @ORM\Table(name="search_terms")
 *
 */
class SearchTerm 
{
    /**
     * @var int | null
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** 
     * Search term
     * @ORM\Column(type="string")
     * @var string
     */
    protected $term;

    /** 
     * total results
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $count;
    
    /**
     * @var timestamp
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    

    /**
     * Gets the value of id.
     *
     * @return int | null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param int | null $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the Search term.
     *
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Sets the Search term.
     *
     * @param string $term the term
     *
     * @return self
     */
    public function setTerm($term)
    {
        $this->term = $term;

        return $this;
    }

    /**
     * Gets the total results.
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Sets the total results.
     *
     * @param integer $count the count
     *
     * @return self
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Gets the value of created.
     *
     * @return timestamp
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Sets the value of created.
     *
     * @param timestamp $created the created
     *
     * @return self
     */
    public function setCreated(timestamp $created)
    {
        $this->created = $created;

        return $this;
    }
}