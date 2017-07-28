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

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/cabecalho.inc.php';
include_once ( CAM_GT_CEM_NEGOCIO."RCEMConfiguracao.class.php" );
include_once ( CAM_GT_CIM_NEGOCIO."RCIMConfiguracao.class.php" );
include_once( CAM_GT_MON_NEGOCIO."RMONCredito.class.php" );
include_once '../../../../../../gestaoTributaria/fontes/PHP/arrecadacao/classes/componentes/MontaGrupoCredito.class.php';

include_once ( CAM_GA_CGM_COMPONENTES."IPopUpCGM.class.php" );
include_once ( CAM_GT_CIM_COMPONENTES."IPopUpImovel.class.php");

// CONSULTA CONFIGURACAO DO MODULO IMOBILIARIO
$obRCIMConfiguracao = new RCIMConfiguracao;
$obRCIMConfiguracao->setCodigoModulo( 12 );
$obRCIMConfiguracao->setAnoExercicio( Sessao::getExercicio() );
$obRCIMConfiguracao->consultarConfiguracao();
$stMascaraInscricao = $obRCIMConfiguracao->getMascaraIM();

// CONSULTA CONFIGURACAO DO MODULO ECONOMICO
$obRCEMConfiguracao = new RCEMConfiguracao;
$obRCEMConfiguracao->setCodigoModulo( 14 );
$obRCEMConfiguracao->setAnoExercicio( Sessao::getExercicio() );
$obRCEMConfiguracao->consultarConfiguracao();
$stMascaraInscricaoEconomico = $obRCEMConfiguracao->getMascaraInscricao();

//****************************************//
//Define COMPONENTES DO FORMULARIO
//****************************************//

//Instancia o formulário
//Define o nome dos arquivos PHP
$stPrograma = "RelatorioDesonerados";
$pgFilt = "FL".$stPrograma.".php";
$pgList = "LS".$stPrograma.".php";
$pgForm = "FM".$stPrograma.".php";
$pgProc = "PR".$stPrograma.".php";
$pgOcul = "OC".$stPrograma.".php";
$pgJS   = "JS".$stPrograma.".js";
$pgGera = "OCGera".$stPrograma.".php";

$obForm = new Form;
$obForm->setAction($pgGera);
$obForm->setTarget("telaPrincipal");

//Define o objeto da ação stAcao
$obHdnAcao = new Hidden;
$obHdnAcao->setName("stAcao");
$obHdnAcao->setValue($stAcao);

$obHdnCtrl = new Hidden;
$obHdnCtrl->setName("stCtrl");
$obHdnCtrl->setValue($stCtrl);

// Imovel
$obPopUpImovel = new IPopUpImovel;
$obPopUpImovel->obInnerImovel->setNull(true);

// Exercicio
$obTxtExercicio = new TextBox;
$obTxtExercicio->setName        ("stExercicio");
$obTxtExercicio->setInteiro     (true);
$obTxtExercicio->setMaxLength   (4);
$obTxtExercicio->setSize        (4);
$obTxtExercicio->setRotulo      ("Exercício");
$obTxtExercicio->setTitle       ("Exercício");
$obTxtExercicio->setNull        (true);

// Grupo de Credito
$obMontaGrupoCredito = new MontaGrupoCredito;

// Contribuinte
$obPopUpCGM = new IPopUpCGM($obForm);
$obPopUpCGM->setNull(true);
$obPopUpCGM->setRotulo("Contribuinte");
$obPopUpCGM->setTitle("Código do Contribuinte");

//****************************************//
//Monta FORMULARIO
//****************************************//
$obFormulario = new Formulario;
$obFormulario->addForm( $obForm );
$obFormulario->addHidden($obHdnAcao);
$obFormulario->addHidden($obHdnCtrl);
$obFormulario->addTitulo("Dados para Filtro");

$obPopUpImovel->geraFormulario($obFormulario);
$obFormulario->addComponente($obTxtExercicio);
$obFormulario->addComponente($obPopUpCGM);
$obMontaGrupoCredito->geraFormulario( $obFormulario, true, false );

$obFormulario->OK();
$obFormulario->show();

?>
