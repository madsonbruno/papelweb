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
    * Página de Formulario de Inclusao/Alteracao de Detalhamento de Destinações de Recursos
    * Data de Criação   : 31/10/2007

    * @author Desenvolvedor: Anderson cAko Konze

    $Id: FMDetalhamentoDestinacoes.php 59612 2014-09-02 12:00:51Z gelson $

    * Casos de uso: uc-02.01.38
*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once( CAM_GF_INCLUDE."validaGF.inc.php");
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/cabecalho.inc.php';

//Define o nome dos arquivos PHP
$stProjeto = "DetalhamentoDestinacoes";
$pgFilt = "FL".$stProjeto.".php";
$pgList = "LS".$stProjeto.".php";
$pgForm = "FM".$stProjeto.".php";
$pgProc = "PR".$stProjeto.".php";
$pgOcul = "OC".$stProjeto.".php";

//Define a função do arquivo, ex: incluir, excluir, alterar, consultar, etc
$stAcao = $_GET['stAcao'] ?  $_GET['stAcao'] : $_POST['stAcao'];

if ( empty( $stAcao ) ) {
    $stAcao = "incluir";
}

//****************************************//
//Define COMPONENTES DO FORMULARIO
//****************************************//
//Instancia o formulário
$obForm = new Form;
$obForm->setAction( $pgProc );
$obForm->setTarget( "oculto" );

//Define o objeto da ação stAcao
$obHdnAcao = new Hidden;
$obHdnAcao->setName ( "stAcao" );
$obHdnAcao->setValue( $stAcao );

//Define o objeto de controle
$obHdnCtrl = new Hidden;
$obHdnCtrl->setName ( "stCtrl" );
$obHdnCtrl->setValue( "" );

    $obTxtCod = new TextBox;
    $obTxtCod->setName     ( "inCodDetalhamento"  );
    $obTxtCod->setId       ( "inCodDetalhamento"  );
    $obTxtCod->setRotulo   ( "Código do Detalhamento"  );
    $obTxtCod->setValue    ( $_GET['inCodDetalhamento'] );
    $obTxtCod->setSize     ( 4 );
    $obTxtCod->setMaxLength( 6 );
    $obTxtCod->obEvento->setOnBlur("executaFuncaoAjax('mascaraDetalhamento','&inCodDetalhamento='+this.value);");
    $obTxtCod->setNull     ( false              );
    $obTxtCod->setInteiro  ( true               );
    if ($stAcao == 'alterar') {
        $obTxtCod->setLabel ( true );
    } else {
        $obTxtCod->setTitle    ( "Informe o Código do Detalhamento de Destinações de Recursos.");
    }

    $obTxtDesc = new TextBox;
    $obTxtDesc->setName     ( "stDescricao"           );
    $obTxtDesc->setValue    ( $_GET['stDescricao'] );
    $obTxtDesc->setRotulo   ( "Descrição"        );
    $obTxtDesc->setTitle    ( "Informe a descrição do Detalhamento de Destinações de Recursos." );
    $obTxtDesc->setSize     ( 80                 );
    $obTxtDesc->setMaxLength( 200                );
    $obTxtDesc->setNull     ( false              );

if ($stAcao == 'incluir') {
    include_once ( CAM_GF_ORC_MAPEAMENTO."TOrcamentoDetalhamentoDestinacaoRecurso.class.php");
    $obTOrcamentoDetalhamentoDestinacaoRecurso = new TOrcamentoDetalhamentoDestinacaoRecurso;
    $obTOrcamentoDetalhamentoDestinacaoRecurso->recuperaTodos( $rsDetalhamento," WHERE exercicio = '".Sessao::getExercicio() ,"' ORDER BY cod_detalhamento " );

    $obLista = new Lista;
    $obLista->setRecordSet( $rsDetalhamento);
    $obLista->setTitulo( "Detalhamentos de Destinações já inclusos") ;
    $obLista->setMostraPaginacao(false);
    $obLista->addCabecalho();
    $obLista->ultimoCabecalho->addConteudo("&nbsp;");
    $obLista->ultimoCabecalho->setWidth( 5 );
    $obLista->commitCabecalho();
    $obLista->addCabecalho();
    $obLista->ultimoCabecalho->addConteudo("Código");
    $obLista->ultimoCabecalho->setWidth( 8 );
    $obLista->commitCabecalho();
    $obLista->addCabecalho();
    $obLista->ultimoCabecalho->addConteudo("Descrição");
    $obLista->ultimoCabecalho->setWidth( 75 );
    $obLista->commitCabecalho();

    $obLista->addDado();
    $obLista->ultimoDado->setCampo( "cod_detalhamento" );
    $obLista->ultimoDado->setAlinhamento( 'CENTRO' );
    $obLista->commitDado();
    $obLista->addDado();
    $obLista->ultimoDado->setCampo( "descricao" );
    $obLista->ultimoDado->setAlinhamento( 'ESQUERDA' );
    $obLista->commitDado();

}

//****************************************//
//Monta FORMULARIO
//****************************************//
$obFormulario = new Formulario;
$obFormulario->addForm( $obForm );
//$obFormulario->setAjuda ( "UC-02.01.38"                );
$obFormulario->addHidden( $obHdnCtrl                   );
$obFormulario->addHidden( $obHdnAcao                   );

$obFormulario->addTitulo( "Dados para o Detalhamento de Destinações de Recursos" );
$obFormulario->addComponente( $obTxtCod );
$obFormulario->addComponente( $obTxtDesc);

//Define os botões de ação do formulário
$obBtnOK = new OK;
$obBtnOK->setId( "ok");

$obBtnLimpar = new Button;
$obBtnLimpar->setName( "btnLimpar" );
$obBtnLimpar->setValue( "Limpar" );
$obBtnLimpar->obEvento->setOnClick ( "document.frm.reset();" );

$stLocation = $pgList.'?'.Sessao::getId().'&stAcao='.$stAcao;

$arBtn = array();
$arBtn[] = $obBtnOK;
$arBtn[] = $obBtnLimpar;
if ($stAcao=='alterar') {
    $obFormulario->Cancelar($stLocation);
} else {
    $obFormulario->defineBarra( $arBtn );
    $obFormulario->addLista     ( $obLista  );
}

include_once ( CAM_GF_ORC_NEGOCIO."ROrcamentoConfiguracao.class.php" );
$obRConfiguracaoOrcamento = new ROrcamentoConfiguracao;
$obRConfiguracaoOrcamento->setExercicio(Sessao::getExercicio());
$obRConfiguracaoOrcamento->consultarConfiguracao();
$boDestinacao = $obRConfiguracaoOrcamento->getDestinacaoRecurso();

if ($boDestinacao == 'false') {
    SistemaLegado::exibeAviso("Ação não permitida. O sistema não está configurado para utilizar a Destinação de Recursos.","","erro");
    $obFormulario = new Formulario;
}

$obFormulario->show();

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/rodape.inc.php';

?>
