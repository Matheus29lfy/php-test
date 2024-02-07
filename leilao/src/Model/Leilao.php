<?php

namespace Alura\Leilao\Model;

class Leilao
{
    /** @var Lance[] */
    private $lances;
    /** @var string */
    private $descricao;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
    }

    public function recebeLance(Lance $lance)
    {
        if(!empty($this->lances) && $this->ehDoUltimoUsuario($lance)){
            throw new \DomainException('Usuário não pode propor 2 lances consecutivos');
        }

        $totalLancesUsuario =  $this->qtdLancesPorUsuario($lance->getUsuario());

        if($totalLancesUsuario >= 5){
            throw new \DomainException('Usuário não pode propor mais de 5 lances por leilão');
        }

        $this->lances[] = $lance;
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }

    private function ehDoUltimoUsuario($lance): bool
    {
        $ultimoLance = $this->lances[count($this->lances) - 1 ]->getUsuario();
        return  $lance->getUsuario() == $ultimoLance;
    }


    
    private function qtdLancesPorUsuario(Usuario $usuario): int
    {
        $totalLancesUsuario = array_reduce(
            $this->lances,
            function(int $totalAcumulado, Lance $lanceAtual) use ($usuario){
                if($lanceAtual->getUsuario() == $usuario){
                    return $totalAcumulado + 1;
                }
                return $totalAcumulado;
            },
            0
        );

        return $totalLancesUsuario;
    }
}
