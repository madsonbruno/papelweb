<?php
/*
    **********************************************************************************
    *                                                                                *
    * @package URBEM CNM - Soluções em Gestão Pública                                *
    * @copyright (c) 2013 Confederação Nacional de Municípos                         *
    * @author Confederação Nacional de Municípios                                    *
    *                                                                                *
    * O URBEM CNM é um software livre; você pode redistribuí-lo e/ou modificá-lo sob *
    * os  termos  da Licença Pública Geral GNU conforme  publicada  pela Fundação do *
    * Software Livre (FSF - Free Software Foundation); na versão 2 da Licença.       *
    *                                                                                *
    * Este  programa  é  distribuído  na  expectativa  de  que  seja  útil,   porém, *
    * SEM NENHUMA GARANTIA; nem mesmo a garantia implícita  de  COMERCIABILIDADE  OU *
    * ADEQUAÇÃO A UMA FINALIDADE ESPECÍFICA. Consulte a Licença Pública Geral do GNU *
    * para mais detalhes.                                                            *
    *                                                                                *
    * Você deve ter recebido uma cópia da Licença Pública Geral do GNU "LICENCA.txt" *
    * com  este  programa; se não, escreva para  a  Free  Software Foundation  Inc., *
    * no endereço 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.       *
    *                                                                                *
    **********************************************************************************
*/
?>
<?php
/**
    * Página de Formulário do Exportação Remessa BESC
    * Data de Criação: 27/09/2007

    * @author Analista: Dagiane	Vieira
    * @author Desenvolvedor: <Alex Cardoso>

    * @ignore

    * Casos de uso: uc-04.08.08
*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/cabecalho.inc.php';
include_once ( CAM_GRH_FOL_NEGOCIO."RFolhaPagamentoFolhaSituacao.class.php"                             );
include_once ( CAM_GRH_FOL_NEGOCIO."RFolhaPagamentoPeriodoMovimentacao.class.php"                       );
include_once ( CAM_GRH_PES_COMPONENTES."IFiltroCompetencia.class.php"                                   );
include_once ( CAM_GRH_IMA_MAPEAMENTO."TIMAConfiguracaoConvenioBesc.class.php"                          );
include_once ( CAM_GRH_FOL_MAPEAMENTO."TFolhaPagamentoPeriodoMovimentacao.class.php"                    );

//Define o nome dos arquivos PHP
$stPrograma = "ExportarRemessaBESC";
$pgFilt     = "FL".$stPrograma.".php";
$pgList     = "LS".$stPrograma.".php";
$pgOcul     = "OC".$stPrograma.".php";
$pgProc     = "PR".$stPrograma.".php";
$pgJS       = "JS".$stPrograma.".js";

$jsOnload  = "montaParametrosGET('gerarSpan','stSituacao');	";
$jsOnload .= "montaParametrosGET('atualizarGrupoConta','inAno,inCodMes'); ";

$obRFolhaPagamentoPeriodoMovimentacao = new RFolhaPagamentoPeriodoMovimentacao;
$obRFolhaPagamentoFolhaSituacao = new RFolhaPagamentoFolhaSituacao($obRFolhaPagamentoPeriodoMovimentacao);

$stAcao = $request->get('stAcao');

//DEFINICAO DOS COMPONENTES
$obHdnAcao =  new Hidden;
$obHdnAcao->setName   ( "stAcao" );
$obHdnAcao->setValue  ( $stAcao  );

$obHdnCtrl =  new Hidden;
$obHdnCtrl->setName   ( "stCtrl" );
$obHdnCtrl->setValue  ( $stCtrl  );

$obHdnTipoFiltroExtra = new hiddenEval();
$obHdnTipoFiltroExtra->setName("hdnTipoFiltroExtra");
$obHdnTipoFiltroExtra->setValue("eval(document.frm.hdnTipoFiltro.value);");

//DEFINICAO DO FORM
$obForm = new Form;
$obForm->setAction  ( $pgProc  );
$obForm->setTarget  ( "oculto" );

$obBtnOk = new Ok();
$obBtnOk->obEvento->setOnClick("montaParametrosGET('submeter','inTipoMovimento,inCodConfiguracao,stSituacao,stAcao,inCodComplementar,stDesdobramento,stTipoFiltro,inCodAtributo,inCodMes,inAno,inNumeroSequencial',true);");

$obBtnLimpar = new Limpar();
$obBtnLimpar->obEvento->setOnClick("executaFuncaoAjax('limparForm');");

$obComboCadastro = new Select;
$obComboCadastro->setRotulo                         ( "Cadastro"                                      );
$obComboCadastro->setTitle                          ( "Selecione o cadastro para filtro."             );
$obComboCadastro->setName                           ( "stSituacao"                                    );
$obComboCadastro->setValue                          ( "ativos"                                        );
$obComboCadastro->setStyle                          ( "width: 200px"                                  );
$obComboCadastro->addOption                         ( "", "Selecione"                                 );
$obComboCadastro->addOption                         ( "ativos", "Ativos"                              );
$obComboCadastro->addOption                         ( "aposentados", "Aposentados"                    );
$obComboCadastro->addOption                         ( "pensionistas", "Pensionistas"                  );
$obComboCadastro->addOption                         ( "estagiarios", "Estagiários"                    );
$obComboCadastro->addOption                         ( "rescindidos", "Rescindidos"                    );
$obComboCadastro->addOption                         ( "pensao_judicial", "Pensão Judicial"            );
$obComboCadastro->addOption                         ( "todos", "Todos"                                );
$obComboCadastro->setNull                           ( false                                           );
$obComboCadastro->obEvento->setOnChange("montaParametrosGET('gerarSpan','stSituacao');");

$obSpnCadastro = new Span();
$obSpnCadastro->setId("spnCadastro");

$obSpnAtivosAposentadosPensionistas = new Span();
$obSpnAtivosAposentadosPensionistas->setId("spnAtivosAposentadosPensionistas");

$obMonValorLiquidoInicial = new Moeda();
$obMonValorLiquidoInicial->setRotulo("Filtrar Valores Líquidos de:");
$obMonValorLiquidoInicial->setName("nuValorLiquidoInicial");
$obMonValorLiquidoInicial->setTitle("Informe a faixa de salários líquidos que deverão ser considerados no arquivo.");
$obMonValorLiquidoInicial->setValue("0,00");
$obMonValorLiquidoInicial->obEvento->setOnChange("montaParametrosGET('validarValores','nuValorLiquidoInicial,nuValorLiquidoFinal');");

$obLblAte = new Label();
$obLblAte->setValue("Até");

$obMonValorLiquidoFinal = new Moeda();
$obMonValorLiquidoFinal->setName("nuValorLiquidoFinal");
$obMonValorLiquidoFinal->setValue("99.999.999,99");
$obMonValorLiquidoFinal->obEvento->setOnChange("montaParametrosGET('validarValores','nuValorLiquidoInicial,nuValorLiquidoFinal');");

$arFiltrarValores = array($obMonValorLiquidoInicial,$obLblAte,$obMonValorLiquidoFinal);

$obPercentual = new Numerico();
$obPercentual->setRotulo("Percentual à Pagar do Líquido:");
$obPercentual->setName("nuPercentualPagar");
$obPercentual->setTitle("Informe o percentual à pagar do salário líquido de cada servidor.");
$obPercentual->setSize(10);
$obPercentual->setMaxLength(6);
$obPercentual->setValue("100,00");

$obLblPercentual = new Label();
$obLblPercentual->setValue("%");

$arPercentual = array($obPercentual,$obLblPercentual);

$obTIMAConfiguracaoConvenioBesc = new TIMAConfiguracaoConvenioBesc();
$obTIMAConfiguracaoConvenioBesc->recuperaTodos($rsConfiguracaoConvenio);
Sessao::write("rsConfiguracaoConvenio", $rsConfiguracaoConvenio);

$obLblCodigoConvenio = new Label();
$obLblCodigoConvenio->setRotulo("Código do Convênio no Banco");
$obLblCodigoConvenio->setNull(false);
$obLblCodigoConvenio->setValue($rsConfiguracaoConvenio->getCampo("cod_convenio_banco"));

$obSpnGrupoContas = new Span();
$obSpnGrupoContas->setId("spnGrupoContas");

$obDtGeracaoArquivo = new Data();
$obDtGeracaoArquivo->setRotulo("Data da Geração Arquivo");
$obDtGeracaoArquivo->setName("dtGeracaoArquivo");
$obDtGeracaoArquivo->setTitle("Informar a data de geração do arquivo.");
$obDtGeracaoArquivo->setNull(false);
$obDtGeracaoArquivo->setValue(date('d/m/Y'));

$obDtPagamento = new Data();
$obDtPagamento->setRotulo("Data do Pagamento");
$obDtPagamento->setName("dtPagamento");
$obDtPagamento->setTitle("Informar a data provável de pagamento.");
$obDtPagamento->setNull(false);
$obDtPagamento->setValue(date('d/m/Y'));
$obDtPagamento->obEvento->setOnChange("montaParametrosGET('validarDataPagamento','dtPagamento,dtGeracaoArquivo')");

$obCmbTipoMovimento = new Select();
$obCmbTipoMovimento->setName("inTipoMovimento");
$obCmbTipoMovimento->setRotulo("Tipo de Movimento");
$obCmbTipoMovimento->setTitle("Selecionar o tipo de movimento do arquivo. Para inclusão de lançamento novo, informar no campo Sequencial do arquivo um número novo, para Alteração de Lançamento, utilizar mesmo número de Sequencial do arquivo gerado anteriormente.");
$obCmbTipoMovimento->setNull(false);
$obCmbTipoMovimento->setStyle( "width: 250px" );
$obCmbTipoMovimento->setValue("0");
$obCmbTipoMovimento->addOption("","Selecione");
$obCmbTipoMovimento->addOption("0","0 - Inclusão de Lançamento Novo");
$obCmbTipoMovimento->addOption("5","5 - Alteração de Lançamento");

$obCmbInstrucaoMovimento = new Select();
$obCmbInstrucaoMovimento->setName("inInstrucaoMovimento");
$obCmbInstrucaoMovimento->setRotulo("Instrução de Movimento");
$obCmbInstrucaoMovimento->setTitle("Informar a instrução de movimento do arquivo, relacionada com o tipo de remessa, informada no campo anterior.");
$obCmbInstrucaoMovimento->setStyle( "width: 250px" );
$obCmbInstrucaoMovimento->setValue("0");
$obCmbInstrucaoMovimento->addOption("","Selecione");
$obCmbInstrucaoMovimento->addOption("0","00 - Inclusão de Lançamento Novo");
$obCmbInstrucaoMovimento->addOption("17","17 - Alteração do valor do lançamento");
$obCmbInstrucaoMovimento->addOption("19","19 - Alteração da data do lançamento");
$obCmbInstrucaoMovimento->addOption("29","29 - Cancelamento de Lançamento");

include_once(CAM_GA_ADM_MAPEAMENTO."TAdministracaoConfiguracao.class.php");
$obTFolhaPagamentoPeriodoMovimentacao = new TFolhaPagamentoPeriodoMovimentacao();
$obTFolhaPagamentoPeriodoMovimentacao->recuperaUltimaMovimentacao($rsUltimaMovimentacao);
$arPeriodoMovimentacaoAtual = explode("/",$rsUltimaMovimentacao->getCampo('dt_final'));
$dtPeriodoMovimentacaoAtual = $arPeriodoMovimentacaoAtual[2].$arPeriodoMovimentacaoAtual[1];

$obTAdministracaoConfiguracao = new TAdministracaoConfiguracao();
$obTAdministracaoConfiguracao->setDado("exercicio",Sessao::getExercicio());
$obTAdministracaoConfiguracao->setDado("cod_modulo",40);
$obTAdministracaoConfiguracao->setDado("parametro","dt_num_sequencial_arquivo_besc".Sessao::getEntidade());
$obTAdministracaoConfiguracao->recuperaPorChave($rsConfiguracao);

$arDataConfiguracao = explode("-",$rsConfiguracao->getCampo("valor"));
$dtConfiguracao = $arDataConfiguracao[0].$arDataConfiguracao[1];

if ($dtPeriodoMovimentacaoAtual > $dtConfiguracao) {
    $inNumeroSequencial = 1;
} else {
    $obTAdministracaoConfiguracao->setDado("parametro","num_sequencial_arquivo_besc".Sessao::getEntidade());
    $obTAdministracaoConfiguracao->recuperaPorChave($rsConfiguracao);
    $inNumeroSequencial = $rsConfiguracao->getCampo("valor");
}

$obIntNumeroSequencial = new Inteiro();
$obIntNumeroSequencial->setRotulo("Número Seqüencial Arquivo");
$obIntNumeroSequencial->setTitle("Informar o número da remessa. Deve ser seqüencial e maior que zero. Deve repetir-se somente quando o tipo de movimento for Alteração de Lançamento. Para Inclusões de Lançamentos Novos, o número deverá ser crescente (sequencial anterior + 1).");
$obIntNumeroSequencial->setName("inNumeroSequencial");
$obIntNumeroSequencial->setValue($inNumeroSequencial);
$obIntNumeroSequencial->setNull(false);

//DEFINICAO DO FORMULARIO
$obFormulario = new Formulario();
$obFormulario->addForm                          ( $obForm                                                               );
$obFormulario->addTitulo                        ( $obRFolhaPagamentoFolhaSituacao->consultarCompetencia() ,"right"      );
$obFormulario->addHidden                        ( $obHdnAcao                                                            );
$obFormulario->addHidden                        ( $obHdnCtrl                                                            );
$obFormulario->addHidden                        ( $obHdnTipoFiltroExtra,true											);
$obFormulario->addComponente($obComboCadastro);
$obFormulario->addSpan($obSpnCadastro);
$obFormulario->addSpan($obSpnAtivosAposentadosPensionistas);
$obFormulario->addTitulo( "Informações Gerais para emissão do arquivo" ,"left");
$obFormulario->agrupaComponentes($arFiltrarValores);
$obFormulario->agrupaComponentes($arPercentual);
$obFormulario->addComponente($obLblCodigoConvenio);
$obFormulario->addSpan($obSpnGrupoContas);
$obFormulario->addComponente($obDtGeracaoArquivo);
$obFormulario->addComponente($obDtPagamento);
$obFormulario->addComponente($obCmbTipoMovimento);
$obFormulario->addComponente($obCmbInstrucaoMovimento);
$obFormulario->addComponente($obIntNumeroSequencial);
$obFormulario->defineBarra(array($obBtnOk,$obBtnLimpar));
$obFormulario->show();

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/rodape.inc.php';
?>
