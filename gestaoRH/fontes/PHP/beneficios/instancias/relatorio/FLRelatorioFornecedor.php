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
* Página filtro para relatório de Fornecedor
* Data de Criação   : 13/07/2005

* @author Analista: Vandré Miguel Ramos
* @author Desenvolvedor: Diego Lemos de Souza

* @ignore

$Revision: 30566 $
$Name$
$Author: vandre $
$Date: 2006-08-08 14:53:12 -0300 (Ter, 08 Ago 2006) $

* Casos de uso: uc-04.06.04
*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/cabecalho.inc.php';
// include_once ( CAM_GRH_PES_NEGOCIO."RValetransporteEmpresaTransporte.class.php" );

// $obREmpresaTransporte  = new RValetransporteEmpresaTransporte;

$obForm = new Form;
$obForm->setAction( CAM_FW_POPUPS."relatorio/OCRelatorio.php" );
$obForm->setTarget( "oculto" );

$obHdnCaminho = new Hidden;
$obHdnCaminho->setName("stCaminho");
$obHdnCaminho->setValue( CAM_GRH_BEN_INSTANCIAS."relatorio/OCRelatorioFornecedor.php" );

// Tipo do benefício
$obCmbTipoBeneficio = new Select;
$obCmbTipoBeneficio->setName       ( "inTipoBeneficio"      );
$obCmbTipoBeneficio->setValue      ( $inTipoBeneficio       );
$obCmbTipoBeneficio->setRotulo     ( "Tipo do Benefício"    );
$obCmbTipoBeneficio->setNull       ( false                  );
$obCmbTipoBeneficio->addOption     ( "", "Selecione"        );
$obCmbTipoBeneficio->addOption     ( "1", "Vale-Transporte" );
$obCmbTipoBeneficio->setStyle      ( "width: 200px"         );

//FORM
$obFormulario = new Formulario;

$obFormulario->addForm               ( $obForm                  );
$obFormulario->addHidden             ( $obHdnCaminho            );

$obFormulario->addTitulo             ( "Filtro para Impressão"  );
$obFormulario->addComponente         ( $obCmbTipoBeneficio      );

$obFormulario->OK();
$obFormulario->show();
