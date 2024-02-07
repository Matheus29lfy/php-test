<?php
namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;
class LeilaoTest extends TestCase
{
 public function testLeilaoNaoDeveReceberLancesRepetidos()
{
    $this->expectException(\DomainException::class);
    $this->expectExceptionMessage('Usuário não pode propor 2 lances consecutivos');
    $leilao = new Leilao('Variante');

    $ana = new Usuario('Ana');

    $leilao->recebeLance(new Lance($ana, 1000));
    $leilao->recebeLance(new Lance($ana, 1500));

    // self::assertCount(1, $leilao->getLances());
    // static::assertEquals(1000,$leilao->getLances()[0]->getValor());

}
  /**
   * @dataProvider geraLances
  */
  public function testLeilaoDeveReceberLances(
        int $qtdLances,
        Leilao $leilao, 
        array $valores
  )
  {

    // $maria = new Usuario('Maria');
    // $joao = new Usuario('João');


    // $leilao = new Leilao('Fiat 147 0KM');

    // $leilao->recebeLance(new Lance($maria, 1000));
    // $leilao->recebeLance(new Lance($joao, 2000));

    // self::assertCount(2, $leilao->getLances());
    self::assertCount($qtdLances, $leilao->getLances());
    foreach($valores as $i => $valorEsperado){
      static::assertEquals($valorEsperado,$leilao->getLances()[$i]->getValor());
    }
    // self::assertEquals(1000, $leilao->getLances()[0]->getValor());
    // self::assertEquals(2000, $leilao->getLances()[1]->getValor());
  
  }

  public static function geraLances()
  {
    $maria = new Usuario('Maria');
    $joao = new Usuario('João');

    $leilaoComDoisLances = new Leilao('Fiat 147 0KM');

    $leilaoComDoisLances->recebeLance(new Lance($maria, 1000));
    $leilaoComDoisLances->recebeLance(new Lance($joao, 2000));

    $leilaoComUmLance = new Leilao('Fusca 1972 0KM');

    $leilaoComUmLance->recebeLance(new Lance($joao, 8000));

    return [
      'dois-lances' => [2, $leilaoComDoisLances, [1000,2000]],
      'um-lance' => [1, $leilaoComUmLance, [8000]]
    ];
  }


  
 public function testLeilaoNaoDeveReceberLancesMaisDeCincoLancesPorUsuario()
 {
      $this->expectException(\DomainException::class);
      $this->expectExceptionMessage('Usuário não pode propor mais de 5 lances por leilão');
     $leilao = new Leilao('Brasília Amarela');
 
     $joao = new Usuario('João');
     $ana = new Usuario('Ana');
 
     $leilao->recebeLance(new Lance($joao, 1000));
     $leilao->recebeLance(new Lance($ana, 1500));
     $leilao->recebeLance(new Lance($joao, 2000));
     $leilao->recebeLance(new Lance($ana, 2500));
     $leilao->recebeLance(new Lance($joao, 3000));
     $leilao->recebeLance(new Lance($ana, 3500));
     $leilao->recebeLance(new Lance($joao, 4000));
     $leilao->recebeLance(new Lance($ana, 4500));
     $leilao->recebeLance(new Lance($joao, 5000));
     $leilao->recebeLance(new Lance($ana, 5500));

     $leilao->recebeLance(new Lance($joao, 6000));

 
    //  self::assertCount(10, $leilao->getLances());
    //  static::assertEquals(5500,$leilao->getLances()[array_key_last($leilao->getLances())]->getValor());
 
 }
}
