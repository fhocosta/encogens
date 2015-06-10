<?php
/**
 * Created by PhpStorm.
 * User: berredo
 * Date: 10/06/15
 * Time: 11:12
 */

namespace ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Tipo
 * @ORM\Table(name="tbl_pacote")
 * @ORM\Entity
 */
class Pacote
{
    /**
     * @var guid
     *
     * @ORM\Column(name="pac_id", type="guid", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pac_item", referencedColumnName="ite_id")
     * })
     */
    private $item;

    /**
     * @var string
     *
     * @ORM\Column(name="pac_quantidade", type="float", nullable=true)
     */
    private $quantidade;

    /**
     * @var string
     *
     * @ORM\Column(name="pac_valor_unitario", type="float", nullable=true)
     */
    private $valorUnitario;

    /**
     * @ORM\OneToMany(targetEntity="Nota", mappedBy="pacote")
     */
    private $notas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->notas = new ArrayCollection();
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
     * Set quantidade
     *
     * @param float $quantidade
     * @return Pacote
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    /**
     * Get quantidade
     *
     * @return float 
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set valorUnitario
     *
     * @param float $valorUnitario
     * @return Pacote
     */
    public function setValorUnitario($valorUnitario)
    {
        $this->valorUnitario = $valorUnitario;

        return $this;
    }

    /**
     * Get valorUnitario
     *
     * @return float 
     */
    public function getValorUnitario()
    {
        return $this->valorUnitario;
    }

    /**
     * Set item
     *
     * @param \ApiBundle\Entity\Item $item
     * @return Pacote
     */
    public function setItem(Item $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \ApiBundle\Entity\Item 
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Add notas
     *
     * @param \ApiBundle\Entity\Nota $notas
     * @return Pacote
     */
    public function addNota(Nota $notas)
    {
        $this->notas[] = $notas;

        return $this;
    }

    /**
     * Remove notas
     *
     * @param \ApiBundle\Entity\Nota $notas
     */
    public function removeNota(Nota $notas)
    {
        $this->notas->removeElement($notas);
    }

    /**
     * Get notas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotas()
    {
        return $this->notas;
    }
}
