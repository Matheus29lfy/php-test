#
Descrição dos testes

A tarefa mais demorada ao escrever testes de unidade normalmente é preparar o cenário, utilizando os dados necessários para o teste, e depois desfazer as ações que possam afetar outros testes.

Para executar código antes ou depois de testes, o PHPUnit nos fornece as fixtures. São métodos que vão ser executados em momentos específicos.

public static function setUpBeforeClass(): void - Método executado uma vez só, antes de todos os testes da classe
public function setUp(): void - Método executado antes de cada teste da classe
public function tearDown(): void - Método executado após cada teste da classe
public static function tearDownAfterClass(): void - Método executado uma vez só, após todos os testes da classe
Para ter mais detalhes e ver alguns exemplos práticos, você pode conferir a documentação desta feature do PHPUnit.