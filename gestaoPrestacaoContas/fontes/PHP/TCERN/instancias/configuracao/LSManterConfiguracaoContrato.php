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
    * @author Analista: Carlos Adriano
    * @author Desenvolvedor: Carlos Adriano
*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/cabecalho.inc.php';
include_once(CAM_GPC_TCERN_MAPEAMENTO."TTCERNContrato.class.php");

$stPrograma = "ManterConfiguracaoContrato";
$pgFilt     = "FL".$stPrograma.".php";
$pgList     = "LS".$stPrograma.".php";
$pgForm     = "FM".$stPrograma.".php";
$pgProc     = "PR".$stPrograma.".php";
$pgOcul     = "OC".$stPrograma.".php";
$pgJs       = "JS".$stPrograma.".js";

$stAcao = $request->get('stAcao');

$arLink = Sessao::read('link');

$obForm = new Form;
$obForm->setAction ( $pgList );

$obHdnAcao = new Hidden;
$obHdnAcao->setName( "stAcao" );
$obHdnAcao->setValue( "manter" );

$obHdnCtrl = new Hidden;
$obHdnCtrl->setName( "stCtrl" );
$obHdnCtrl->setValue( "" );

$arFiltro = array();

###CONVÊNIO
if ($_REQUEST['inCodConvenioInicial'] != '' && $_REQUEST['inCodConvenioFinal'] != '') {
    $arFiltro[] = " num_convenio >= ".$_REQUEST['inCodConvenioInicial']." and num_convenio <= ".$_REQUEST['inCodConvenioFinal'];

} elseif ($_REQUEST['inCodConvenioInicial'] != '') {
    $arFiltro[] = " num_convenio = ".$_REQUEST['inCodConvenioInicial'];

} elseif ($_REQUEST['inCodConvenioFinal'] != '') {
    $arFiltro[] = " num_convenio = ".$_REQUEST['inCodConvenioFinal'];
}

###CONTRATO
if ($_REQUEST['inCodContratoInicial'] != '' && $_REQUEST['inCodContratoFinal'] != '') {
    $arFiltro[] = " num_contrato >= ".$_REQUEST['inCodContratoInicial']." and num_contrato <= ".$_REQUEST['inCodContratoFinal'];

} elseif ($_REQUEST['inCodContratoInicial'] != '') {
    $arFiltro[] = " num_contrato = ".$_REQUEST['inCodContratoFinal'];

} elseif ($_REQUEST['inCodContratoInicial'] != '') {
    $arFiltro[] = " num_contrato = ".$_REQUEST['inCodContratoFinal'];
}

if ($_REQUEST['inCodEntidade'] != '') {
    $arFiltro[] = " cod_entidade IN (".implode(",", $_REQUEST['inCodEntidade']).")";
}

if ( count( $arFiltro ) > 0 ) {
    $stFiltro = " WHERE " .implode ( ' and ' , $arFiltro );
}

$obTTCERNContrato = new TTCERNContrato;
$obTTCERNContrato->recuperaTodos($rsRecordSet, $stFiltro);

$obLista = new Lista;
$obLista->setRecordSet( $rsRecordSet );
$obLista->obPaginacao->setFiltro("&stLink=".$stLink );

$obLista->addCabecalho();
$obLista->ultimoCabecalho->addConteudo("&nbsp;");
$obLista->ultimoCabecalho->setWidth( 5 );
$obLista->commitCabecalho();

$obLista->addCabecalho();
$obLista->ultimoCabecalho->addConteudo('Exercício');
$obLista->ultimoCabecalho->setWidth( 10 );
$obLista->commitCabecalho();

$obLista->addCabecalho();
$obLista->ultimoCabecalho->addConteudo('Convênio');
$obLista->ultimoCabecalho->setWidth( 10 );
$obLista->commitCabecalho();

$obLista->addCabecalho();
$obLista->ultimoCabecalho->addConteudo('Cód. Entidade');
$obLista->ultimoCabecalho->setWidth( 10 );
$obLista->commitCabecalho();

$obLista->addCabecalho();
$obLista->ultimoCabecalho->addConteudo('Contrato');
$obLista->ultimoCabecalho->setWidth( 10 );
$obLista->commitCabecalho();

$obLista->addCabecalho();
$obLista->ultimoCabecalho->addConteudo('Bimestre');
$obLista->ultimoCabecalho->setWidth( 10 );
$obLista->commitCabecalho();

$obLista->addCabecalho();
$obLista->ultimoCabecalho->addConteudo("Ação");
$obLista->ultimoCabecalho->setWidth( 5 );
$obLista->commitCabecalho();

$obLista->addDado();
$obLista->ultimoDado->setAlinhamento("CENTRO");
$obLista->ultimoDado->setCampo( "exercicio" );
$obLista->commitDado();

$obLista->addDado();
$obLista->ultimoDado->setAlinhamento("CENTRO");
$obLista->ultimoDado->setCampo( "num_convenio" );
$obLista->commitDado();

$obLista->addDado();
$obLista->ultimoDado->setAlinhamento("CENTRO");
$obLista->ultimoDado->setCampo( "cod_entidade" );
$obLista->commitDado();

$obLista->addDado();
$obLista->ultimoDado->setAlinhamento("CENTRO");
$obLista->ultimoDado->setCampo( "num_contrato" );
$obLista->commitDado();

$obLista->addDado();
$obLista->ultimoDado->setAlinhamento("CENTRO");
$obLista->ultimoDado->setCampo( "bimestre" );
$obLista->commitDado();

$obLista->addAcao();

$obLista->ultimaAcao->setAcao( "ALTERAR" );
$obLista->ultimaAcao->setLink( $pgForm."?stAcao=manter&".Sessao::getId() );

$obLista->ultimaAcao->addCampo("&inNumConvenio"       , "num_convenio"       );
$obLista->ultimaAcao->addCampo("&stExercicio"         , "exercicio"          );
$obLista->ultimaAcao->addCampo("&inCodEntidade"       , "cod_entidade"       );
$obLista->ultimaAcao->addCampo("&inNumContrato"       , "num_contrato"       );
$obLista->ultimaAcao->addCampo("&stExercicioContrato" , "exercicio_contrato" );

$obLista->commitAcao();
$obLista->show();

?>
