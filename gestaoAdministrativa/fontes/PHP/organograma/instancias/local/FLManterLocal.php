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
* Arquivo de instância para manutenção de locais
* Data de Criação: 25/07/2005

* @author Analista: Cassiano
* @author Desenvolvedor: Cassiano

$Revision: 21837 $
$Name$
$Author: cassiano $
$Date: 2007-04-13 15:09:00 -0300 (Sex, 13 Abr 2007) $

Casos de uso: uc-01.05.03
*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/cabecalho.inc.php';
include_once ( CAM_GA_ORGAN_NEGOCIO."ROrganogramaLocal.class.php"     );

//Define o nome dos arquivos PHP
$stPrograma  = "ManterLocal";
$pgFilt      = "FL".$stPrograma.".php";
$pgList      = "LS".$stPrograma.".php";
$pgForm      = "FM".$stPrograma.".php";
$pgFormBaixa = "FM".$stPrograma."Baix.php";
$pgProc      = "PR".$stPrograma.".php";
$pgOcul      = "OC".$stPrograma.".php";
$pgJs        = "JS".$stPrograma.".js";

$pgProx = $pgList;

include( $pgJs );

Sessao::remove('link');

$stAcao = $_POST["stAcao"] ? $_POST["stAcao"] : $_GET["stAcao"];
if ( empty( $stAcao ) ) {
    $stAcao = "incluir";
}

//DEFINICAO DOS COMPONENTES DO FORMULARIO
$obHdnAcao = new Hidden;
$obHdnAcao->setName                     ( "stAcao" );
$obHdnAcao->setValue                    ( $stAcao );

$obHdnCtrl = new Hidden;
$obHdnCtrl->setName                     ( "stCtrl" );
$obHdnCtrl->setValue                    ( "" );

$obTxtCodigo = new Inteiro();
$obTxtCodigo->setRotulo     ("Código");
$obTxtCodigo->setTitle      ("Código do Local.");
$obTxtCodigo->setName       ("inCodigo");
$obTxtCodigo->setMaxLength  (5);
$obTxtCodigo->setSize       (5);

$obTxtFiltro = new TextBox;
$obTxtFiltro->setRotulo                 ( "Descrição"        );
$obTxtFiltro->setTitle                  ( "Informe o filtro." );
$obTxtFiltro->setName                   ( "stDescricao"      );
$obTxtFiltro->setValue                  ( $stDescricao       );
$obTxtFiltro->setSize                   ( 80 );
$obTxtFiltro->setMaxLength              ( 80 );
$obTxtFiltro->setInteiro                ( False );

$obForm = new Form;
$obForm->setAction                      ( $pgProx );
$obForm->setTarget                      ( "telaPrincipal" );

//DEFINICAO DO FORMULARIO
$obFormulario = new Formulario;
$obFormulario->addForm                  ( $obForm             );
$obFormulario->addHidden                ( $obHdnAcao          );
$obFormulario->addHidden                ( $obHdnCtrl          );
$obFormulario->addTitulo                ( "Dados para Filtro" );
$obFormulario->addComponente            ( $obTxtCodigo        );
$obFormulario->addComponente            ( $obTxtFiltro        );
$obFormulario->OK                       ();
$obFormulario->show                     ();

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/rodape.inc.php';

?>
