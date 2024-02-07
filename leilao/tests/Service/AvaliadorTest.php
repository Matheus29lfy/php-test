<?php
namespace Alura\Leilao\Tests\Service;

use PHPUnit\Framework\TestCase;
use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use DomainException;

class AvaliadorTest extends TestCase
{

  /**@var Avaliador */
  private $leiloeiro;

  //PhpUnit inicializa método automaticamente
  protected function setUp():void
  {
    $this->leiloeiro = new Avaliador();
  }

  /**
   * @dataProvider leilaoEmOrdemAleatoria
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
    */
  public function testAvaliadorDeveEncontrarMaiorValorDeLances(Leilao $leilao)
  {
    //Arrumo a casa para o teste - Arrange / Given

    // $leilao = $this->leilaoEmOrdemCrescente();
    
    
    //Executo o código a ser testado - Act / When
    $this->leiloeiro->avalia($leilao);
    
    $maiorValor = $this->leiloeiro->getMaiorValor();
    
    //Verifico a saída a ser testado - Assert - Then
    self::assertEquals(2500, $maiorValor);
  
  }

      // public function testAvaliadorDeveEncontrarMaiorValorEmOrdemCrescente()
      // {
      //   //Arrumo a casa para o teste - Arrange / Given

      //   $leilao = $this->leilaoEmOrdemCrescente();
        
      //   $leiloeiro = new Avaliador();
        
      //   //Executo o código a ser testado - Act / When
      //   $leiloeiro->avalia($leilao);
        
      //   $maiorValor = $leiloeiro->getMaiorValor();
        
      //   //Verifico a saída a ser testado - Assert - Then
      //   self::assertEquals(2500, $maiorValor);
      
      // }
      
    /**
   * @dataProvider leilaoEmOrdemAleatoria
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
    */
      public function testAvaliadorDeveEncontrarMaiorValorEmOrdemDecrescente(Leilao $leilao)
      {
        //Arrumo a casa para o teste - Arrange / Given

        // $leilao = $this->leilaoEmOrdemDecrescente();
        // $leiloeiro = new Avaliador();
        //Executo o código a ser testado - Act / When
        $this->leiloeiro->avalia($leilao);
        
        $maiorValor =$this->leiloeiro->getMaiorValor();
        
        //Verifico a saída a ser testado - Assert - Then
        self::assertEquals(2500, $maiorValor);
      
      }

  /**
   * @dataProvider leilaoEmOrdemAleatoria
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
    */
      public function testAvaliadorDeveEncontrarMenorValorEmOrdemDecrescente(Leilao $leilao)
      {
        //Arrumo a casa para o teste - Arrange / Given

        // $leilao =$this->leilaoEmOrdemCrescente();
        
        // $leiloeiro = new Avaliador();
        
        //Executo o código a ser testado - Act / When
        $this->leiloeiro->avalia($leilao);
        // $leiloeiro->avalia($leilao);
        // $menorValor = $leiloeiro->getMenorValor();
        // $menorValor = $leiloeiro->getMenorValor();
        // $menorValor = $leiloeiro->getMenorValor();
        $menorValor = $this->leiloeiro->getMenorValor();
        //Verifico a saída a ser testado - Assert - Then
        self::assertEquals(1700, $menorValor);
      
      }

  /**
   * @dataProvider leilaoEmOrdemAleatoria
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
    */
      public function testAvaliadorDeveEncontrarMenorValorEmOrdemCrescente( Leilao $leilao)
      {
        //Arrumo a casa para o teste - Arrange / Given

        // $leilao = $this->leilaoEmOrdemDecrescente();
        
        
        //Executo o código a ser testado - Act / When
        $this->leiloeiro->avalia($leilao);
        
        $menor = $this->leiloeiro->getMenorValor();
        
        //Verifico a saída a ser testado - Assert - Then
        self::assertEquals(1700, $menor);
      
      }
  /**
   * @dataProvider leilaoEmOrdemAleatoria
   * @dataProvider leilaoEmOrdemCrescente
   * @dataProvider leilaoEmOrdemDecrescente
    */
      public function testAvaliadorDeveBuscarTresMaioresValores( Leilao $leilao)
      {
        //Arrumo a casa para o teste - Arrange / Given

        // $leilao = new Leilao('Fiat 147 0KM');

        // $maria = new Usuario('Maria');
        // $joao = new Usuario('João');
        // $ana = new Usuario('Ana');
        // $jorge = new Usuario('Jorge');

        // $leilao->recebeLance(new Lance($joao, 1500));
        // $leilao->recebeLance(new Lance($maria, 2000));
        // $leilao->recebeLance(new Lance($ana, 1500));
        // $leilao->recebeLance(new Lance($jorge, 1700));
        
        // $this->criaAvaliador(); 
        
        //Executo o código a ser testado - Act / When
        $this->leiloeiro->avalia($leilao);
        
        $maioresValores = $this->leiloeiro->getMaioresLances();
        
        //Verifico a saída a ser testado - Assert - Then
        self::assertCount(3, $maioresValores);
        self::assertEquals(2500, $maioresValores[0]->getValor());
        self::assertEquals(2000, $maioresValores[1]->getValor());
        self::assertEquals(1700, $maioresValores[2]->getValor());
      
      }

      public static function leilaoEmOrdemCrescente()
      {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($ana, 1700));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        return [
          'ordem-crescente' =>   [$leilao]
            ];
      }
      public function testLeilaoVazioNaoPodeSerAvaliado()
      {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage( 'Não é possível avaliar leilão vazio');
        $leilao = new Leilao('Fusca Azul');
        $this->leiloeiro->avalia($leilao);
        }

      public static function leilaoEmOrdemDecrescente()
      {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($ana, 1700));

        return  [
          'ordem-decrescente' => [$leilao]
        ];
      }
      public  static function leilaoEmOrdemAleatoria()
      {
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($ana, 1700));

        return  [
          'ordem-aleatoria' => [$leilao]
        ];
      }


      // public function entregaLeiloes()
      // {
      //   return [
      //     $this->leilaoEmOrdemCrescente(),
      //     $this->leilaoEmOrdemDecrescente(),
      //     $this->leilaoEmOrdemAleatoria()
      //   ];
      // }
}
