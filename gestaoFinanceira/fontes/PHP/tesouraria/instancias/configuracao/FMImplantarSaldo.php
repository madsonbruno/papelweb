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
    * Formulario para Implantação de Saldo da Tesouraria
    p
    * Data de Criação   : 17/02/2006

    * @author Analista: Lucas Leusin Oaigen
    * @author Desenvolvedor: Anderson R. M. Buzo

    * @ignore

    $Revision: 30668 $
    $Name$
    $Autor:$
    $Date: 2008-03-20 12:09:41 -0300 (Qui, 20 Mar 2008) $

    * Casos de uso: uc-02.04.22
*/

/*
$Log$
Revision 1.9  2007/07/24 20:44:47  hboaventura
Bug#9478#

Revision 1.8  2006/07/05 20:39:21  cleisson
Adicionada tag Log aos arquivos

*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/cabecalho.inc.php';
include_once ( CAM_GF_ORC_NEGOCIO."ROrcamentoEntidade.class.php" );

//Define o nome dos arquivos PHP
$stPrograma      = "ImplantarSaldo";
$pgFilt          = "FL".$stPrograma.".php";
$pgList          = "LS".$stPrograma.".php";
$pgForm          = "FM".$stPrograma.".php";
$pgProc          = "PR".$stPrograma.".php";
$pgOcul          = "OC".$stPrograma.".php";
$pgJs            = "JS".$stPrograma.".js";

include_once( $pgJs );

$obROrcamentoEntidade = new ROrcamentoEntidade;
$obROrcamentoEntidade->setExercicio( Sessao::getExercicio() );
$obROrcamentoEntidade->obRCGM->setNumCGM( Sessao::read('numCgm') );
$obROrcamentoEntidade->listarUsuariosEntidade( $rsEntidade );

$stAcao = $request->get('stAcao');
if ( empty( $stAcao ) ) {
    $stAcao = "incluir";
}

// DEFINICAO DOS COMPONENTES
$obForm = new Form;
$obForm->setAction( $pgProc );
$obForm->setTarget ( "oculto" );

$obHdnCtrl = new Hidden;
$obHdnCtrl->setName  ( "stCtrl"            );
$obHdnCtrl->setValue ( $_REQUEST["stCtrl"] );

$obHdnAcao = new Hidden;
$obHdnAcao->setName  ( "stAcao" );
$obHdnAcao->setValue ( $stAcao  );

$obHdnCodigoEntidade = new Hidden;
$obHdnCodigoEntidade->setName( "inCodigoEntidade" );
$obHdnCodigoEntidade->setValue( ""           );

if ($_REQUEST['inCodEntidade']) {
    SistemaLegado::executaFramePrincipal( "buscaDado('mostraSpanContaBanco');");
}

// Define Objeto Select para Entidade
$obCmbEntidade = new Select();
$obCmbEntidade->setRotulo    ( "*Entidade"                );
$obCmbEntidade->setName      ( "inCodEntidade"            );
$obCmbEntidade->setTitle     ( "Selecione a Entidade"     );
$obCmbEntidade->setCampoId   ( "cod_entidade"             );
$obCmbEntidade->setCampoDesc ( "nom_cgm"                  );
$obCmbEntidade->setValue     ( $inCodEntidade             );
$obCmbEntidade->setNull      ( true                       );
if ($rsEntidade->getNumLinhas() > 1) {
      $obCmbEntidade->addOption    ( ""            ,"Selecione" );
      $obCmbEntidade->obEvento->setOnChange( "buscaDado('mostraSpanContaBanco');" );
} else $jsSL = "buscaDado('mostraSpanContaBanco');";
$obCmbEntidade->preencheCombo( $rsEntidade                );

// Define Objeto BuscaInner para conta de banco
$obBscContaBanco = new BuscaInner;
$obBscContaBanco->setRotulo ( "Conta de Banco" );
$obBscContaBanco->setTitle  ( "Informe a Conta Banco para implantação de saldo" );
$obBscContaBanco->setId     ( "stNomConta"  );
$obBscContaBanco->setValue  ( $stNomConta   );
$obBscContaBanco->setNull   ( false         );
$obBscContaBanco->obCampoCod->setName     ( "inCodPlano" );
$obBscContaBanco->obCampoCod->setSize     ( 10           );
$obBscContaBanco->obCampoCod->setNull     ( false        );
$obBscContaBanco->obCampoCod->setMaxLength( 8            );
$obBscContaBanco->obCampoCod->setValue    ( $inCodPlano  );
$obBscContaBanco->obCampoCod->setAlign    ( "left"       );
$obBscContaBanco->setFuncaoBusca("abrePopUp('".CAM_GF_CONT_POPUPS."planoConta/FLPlanoConta.php','frm','inCodPlano','stNomConta','banco','".Sessao::getId()."','800','550');");
$obBscContaBanco->setValoresBusca(CAM_GF_CONT_POPUPS.'planoConta/OCPlanoConta.php?'.Sessao::getId(),$obForm->getName(),'banco');

$obSpanContaBanco = new Span;
$obSpanContaBanco->setId( "spnContaBanco" );

// Define Obeto Numerico para valor da arrecadacao
$obTxtSaldo = new Moeda();
$obTxtSaldo->setRotulo   ( "Valor"                           );
$obTxtSaldo->setTitle    ( "Digite o Valor a ser Implantado" );
$obTxtSaldo->setName     ( "nuValor"                         );
$obTxtSaldo->setId       ( "nuValor"                         );
$obTxtSaldo->setNull     ( false                              );
$obTxtSaldo->setDecimais ( 2                                 );
$obTxtSaldo->setNegativo ( true                              );
$obTxtSaldo->setSize     ( 17                                );
$obTxtSaldo->setMaxLength( 17                                );
//$obTxtSaldo->setMinValue ( 0.01                               );

//DEFINICAO DO FORMULARIO
$obFormulario = new Formulario;
$obFormulario->addForm      ( $obForm               );
$obFormulario->addHidden    ( $obHdnCtrl            );
$obFormulario->addHidden    ( $obHdnAcao            );
$obFormulario->addHidden    ( $obHdnCodigoEntidade  );
$obFormulario->addTitulo    ( "Dados para Implantação de Saldo" );
$obFormulario->addComponente( $obCmbEntidade        );
$obFormulario->addSpan      ( $obSpanContaBanco     );
//$obFormulario->addComponente( $obBscContaBanco   );
$obFormulario->addComponente( $obTxtSaldo           );

$obOk   = new Ok;

$obLimpar = new Button;
$obLimpar->setName  ( "Limpar" );
$obLimpar->setValue ( "Limpar" );
$obLimpar->obEvento->setOnClick("limpar();");

$obFormulario->defineBarra( array($obOk,  $obLimpar ) );

$obFormulario->show();
if ($jsSL) SistemaLegado::executaFrameOculto($jsSL);

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/rodape.inc.php';

?>
