<?php
/**
 * Created by PhpStorm.
 * User: berredo
 * Date: 10/06/15
 * Time: 11:03
 */

namespace ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Tipo
 * @ORM\Table(name="tbl_tipo")
 * @ORM\Entity
 */
class Tipo
{
    /**
     * @var guid
     *
     * @ORM\Column(name="tip_id", type="guid", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tip_nome", type="string", length=100, nullable=true)
     */
    private $nome;

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="tipo")
     */
    private $itens;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->itens = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return guid 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return Tipo
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Add itens
     *
     * @param \ApiBundle\Entity\Item $itens
     * @return Tipo
     */
    public function addIten(Item $itens)
    {
        $this->itens[] = $itens;

        return $this;
    }

    /**
     * Remove itens
     *
     * @param \ApiBundle\Entity\Item $itens
     */
    public function removeIten(Item $itens)
    {
        $this->itens->removeElement($itens);
    }

    /**
     * Get itens
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItens()
    {
        return $this->itens;
    }
}
