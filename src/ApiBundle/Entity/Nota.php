<?php
/**
 * Created by PhpStorm.
 * User: berredo
 * Date: 10/06/15
 * Time: 11:18
 */

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Class Tipo
 * @ORM\Table(name="tbl_nota")
 * @ORM\Entity
 */
class Nota {
    /**
     * @var guid
     *
     * @ORM\Column(name="not_id", type="guid", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var Viagem
     *
     * @ORM\ManyToOne(targetEntity="Viagem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="not_viagem", referencedColumnName="via_id")
     * })
     */
    private $viagem;

    /**
     * @var Cliente
     *
     * @ORM\ManyToOne(targetEntity="Cliente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="not_cliente", referencedColumnName="cli_id")
     * })
     */
    private $cliente;

    /**
     * @var Pacote
     *
     * @ORM\ManyToOne(targetEntity="Pacote")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="not_pacote", referencedColumnName="pac_id")
     * })
     */
    private $pacote;

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
     * Set viagem
     *
     * @param \ApiBundle\Entity\Viagem $viagem
     * @return Nota
     */
    public function setViagem(\ApiBundle\Entity\Viagem $viagem = null)
    {
        $this->viagem = $viagem;

        return $this;
    }

    /**
     * Get viagem
     *
     * @return \ApiBundle\Entity\Viagem 
     */
    public function getViagem()
    {
        return $this->viagem;
    }

    /**
     * Set cliente
     *
     * @param \ApiBundle\Entity\Cliente $cliente
     * @return Nota
     */
    public function setCliente(\ApiBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \ApiBundle\Entity\Cliente 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set pacote
     *
     * @param \ApiBundle\Entity\Pacote $pacote
     * @return Nota
     */
    public function setPacote(Pacote $pacote = null)
    {
        $this->pacote = $pacote;

        return $this;
    }

    /**
     * Get pacote
     *
     * @return \ApiBundle\Entity\Pacote 
     */
    public function getPacote()
    {
        return $this->pacote;
    }
}
