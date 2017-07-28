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
    * Página de Formulario de Seleção de Impressora para Relatorio
    * Data de Criação   : 18/02/2005

    * @author Lucas Leusin Oaigen

    * @ignore

    $Revision: 31935 $
    $Name$
    $Author: lbbarreiro $
    $Date: 2008-01-15 12:00:12 -0200 (Ter, 15 Jan 2008) $

    $Id: OCGeraRelatorioEmpenhoEmpenhadoPagoEstornado.php 59612 2014-09-02 12:00:51Z gelson $

    * Casos de uso : uc-02.03.06
*/
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkPDF.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';
include_once( CAM_FW_PDF."RRelatorio.class.php" );

$obRRelatorio = new RRelatorio;
$obPDF        = new ListaFormPDF( "L" );

$arFiltro = Sessao::read('filtroRelatorio');
$rsRecordSet = Sessao::read('rsRecordSet');

// Adicionar logo nos relatorios
if ( count( $arFiltro['inCodEntidade'] ) == 1 ) {
    $obRRelatorio->setCodigoEntidade( $arFiltro['inCodEntidade'][0] );
    $obRRelatorio->setExercicioEntidade ( Sessao::getExercicio() );
}

$obRRelatorio->recuperaCabecalho ( $arConfiguracao                                              );
$obPDF->setModulo                ( "Empenho - ".Sessao::getExercicio()                      );
$stSituacao = "Pagos";
$dtPeriodo = $arFiltro['stDataInicial']." a ".$arFiltro['stDataFinal'] ." - ".$stSituacao;
$obPDF->setSubTitulo             ( $dtPeriodo  );

$obPDF->setUsuario           ( Sessao::getUsername() );
$obPDF->setEnderecoPrefeitura( $arConfiguracao );

$obPDF->addRecordSet( $rsRecordSet );

$obPDF->setAlinhamento ( "L" );
$obPDF->addCabecalho("DATA", 4, 7, 'b');
$obPDF->setAlinhamento ( "C" );
$obPDF->addCabecalho("CATEGORIA", 7, 7, 'b');
$obPDF->setAlinhamento ( "C" );
$obPDF->addCabecalho("TIPO", 4, 7, 'b');
$obPDF->setAlinhamento ( "L" );
$obPDF->addCabecalho("EMPENHO", 6, 7, 'b');
$obPDF->setAlinhamento ( "R" );
$obPDF->addCabecalho("LIQ.", 3, 7, 'b');
$obPDF->addCabecalho("O.P.", 3, 7, 'b');
$obPDF->addCabecalho("CGM", 4, 7, 'b');
$obPDF->setAlinhamento ( "L" );
$obPDF->addCabecalho("RAZÃO SOCIAL",11, 7, 'b');
$obPDF->setAlinhamento ( "R" );
$obPDF->addCabecalho("CONTA", 7, 7, 'b');

if ((isset($arFiltro["stDemonstracaoRecursoEmpenho"]) && $arFiltro["stDemonstracaoRecursoEmpenho"] == "S") && (isset($arFiltro["stDemonstracaoElementoDespesa"]) && $arFiltro["stDemonstracaoElementoDespesa"] == "S") ) {
    $obPDF->setAlinhamento ( "L" );
    $obPDF->addCabecalho("NOME CONTA", 13, 7, 'b');
    $obPDF->setAlinhamento("L");
    $obPDF->addCabecalho("RECURSO", 13, 7, 'b');
    $obPDF->setAlinhamento("L");
    $obPDF->addCabecalho("DESPESA", 7, 7, 'b');
} elseif ((isset($arFiltro["stDemonstracaoRecursoEmpenho"]) && $arFiltro["stDemonstracaoRecursoEmpenho"] == "S") && (!isset($arFiltro["stDemonstracaoElementoDespesa"]) || $arFiltro["stDemonstracaoElementoDespesa"] != "S") ) {
    $obPDF->setAlinhamento ( "L" );
    $obPDF->addCabecalho("NOME CONTA", 20, 7, 'b');
    $obPDF->setAlinhamento("L");
    $obPDF->addCabecalho("RECURSO", 13, 7, 'b');
} elseif ((!isset($arFiltro["stDemonstracaoRecursoEmpenho"]) || $arFiltro["stDemonstracaoRecursoEmpenho"] != "S") && (isset($arFiltro["stDemonstracaoElementoDespesa"]) && $arFiltro["stDemonstracaoElementoDespesa"] == "S") ) {
    $obPDF->setAlinhamento ( "L" );
    $obPDF->addCabecalho("NOME CONTA", 24, 7, 'b');
    $obPDF->setAlinhamento("L");
    $obPDF->addCabecalho("DESPESA", 9, 7, 'b');
} else {
    $obPDF->setAlinhamento ( "L" );
    $obPDF->addCabecalho("NOME CONTA", 33, 7, 'b');
}

$obPDF->setAlinhamento ( "R" );
$obPDF->addCabecalho("PAGO", 6, 7, 'b');
$obPDF->setAlinhamento ( "R" );
$obPDF->addCabecalho("EST.", 6, 7, 'b');
$obPDF->setAlinhamento ( "R" );
$obPDF->addCabecalho("LIQ.PAGO", 6, 7, 'b');
$obPDF->addQuebraLinha("nivel",2,5);

$obPDF->setAlinhamento ( "C" );
$obPDF->addCampo("data", 5 ,'','','','',0 );
$obPDF->setAlinhamento("C");
$obPDF->addCampo("descricao_categoria", 5, '', '', '', 0);
$obPDF->setAlinhamento("C");
$obPDF->addCampo("nom_tipo", 5, '', '', '', 0);
$obPDF->setAlinhamento ( "L" );
$obPDF->addCampo("empenho", 5,'','','','',0  );
$obPDF->setAlinhamento ( "R" );
$obPDF->addCampo("cod_nota", 5,'','','','',0  );
$obPDF->addCampo("ordem", 5,'','','','',0  );
$obPDF->setAlinhamento ( "R" );
$obPDF->addCampo("cgm", 5,'','','','',0  );
$obPDF->setAlinhamento ( "L" );
$obPDF->addCampo("razao_social", 5,'','','','',0  );
$obPDF->setAlinhamento ( "R" );
$obPDF->addCampo("conta", 5,'','','','',0  );
$obPDF->setAlinhamento ( "L" );
$obPDF->addCampo("nome_conta", 5,'','','','',0  );
$obPDF->setAlinhamento ( "R" );

$obPDF->setAlinhamento("L");

if (isset($arFiltro["stDemonstracaoRecursoEmpenho"]) && $arFiltro["stDemonstracaoRecursoEmpenho"] == "S") {
    $obPDF->addCampo("recurso", 5, '', '', '', 0);
}

if (isset($arFiltro["stDemonstracaoElementoDespesa"]) && $arFiltro["stDemonstracaoElementoDespesa"] == "S") {
    $obPDF->addCampo("despesa", 5, '', '', '', 0);
}
$obPDF->setAlinhamento("R");
$obPDF->addCampo("valor", 5,'','','','',0  );
$obPDF->setAlinhamento ( "R" );
$obPDF->addCampo("valor_estornado", 5,'','','','',0  );
$obPDF->setAlinhamento ( "R" );
$obPDF->addCampo("valor_liquido", 5,'','','','',0  );

$arAssinaturas = Sessao::read('assinaturas');
if ( count($arAssinaturas['selecionadas']) > 0 ) {
    include_once( CAM_FW_PDF."RAssinaturas.class.php" );
    $obRAssinaturas = new RAssinaturas;
    $obRAssinaturas->setArAssinaturas( $arAssinaturas['selecionadas'] );
    $obPDF->setAssinaturasDefinidas( $obRAssinaturas->getArAssinaturas() );
    $obRAssinaturas->montaPDF( $obPDF );
}

$obPDF->show();
?>
