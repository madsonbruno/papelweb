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
    * Página de Filtro de Procura de Regioes
    * Data de Criação   : 18/06/2007

    * @author Desenvolvedor: Marcio Medeiros

    * @ignore

    * Casos de uso: uc-02.09.11
*/

/*
$Log$
Revision 1.1  2007/06/21 19:38:28  leandro.zis
popup produto do ppa
*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/cabecalho.inc.php';

//Define o nome dos arquivos PHP
$stPrograma 	= "ProcurarRegioes";
$pgFilt 				= "FL".$stPrograma.".php";
$pgList 			= "LS".$stPrograma.".php";
$pgOcul 			= "OC".$stPrograma.".php";
$pgJS  				= "JS".$stPrograma.".js";

$sessao->link 	= "";

//Define a função do arquivo, ex: incluir, excluir, alterar, consultar, etc
$stAcao = $_GET['stAcao'] ?  $_GET['stAcao'] : $_POST['stAcao'];

//Instancia o formulário
$obForm = new Form;
$obForm->setAction($pgList);

//Define o objeto da ação stAcao
$obHdnForm = new Hidden;
$obHdnForm->setName('nomForm');
$obHdnForm->setValue($_REQUEST['nomForm']);

$obHdnAcao = new Hidden;
$obHdnAcao->setName('stAcao');
$obHdnAcao->setValue($stAcao);

$obHdnCtrl = new Hidden;
$obHdnCtrl->setName('stCtrl');
$obHdnCtrl->setValue('buscaRegiao');

$obHdnCampoNum = new Hidden;
$obHdnCampoNum->setName('campoNum');
$obHdnCampoNum->setValue($_REQUEST['campoNum']);

$obHdnCampoNom = new Hidden;
$obHdnCampoNom->setName('campoNom');
$obHdnCampoNom->setValue($_REQUEST['campoNom']);

$obTxtNome = new TextBox;
$obTxtNome->setName('stNome');
$obTxtNome->setRotulo('Nome da Região');
$obTxtNome->setSize(80);
$obTxtNome->setMaxLength(80);
$obTxtNome->setNull(true);
$obTxtNome->setTitle('Informe o Nome da Região.');

$obTipoBuscaNome = new TipoBusca($obTxtNome);

$obFormulario = new Formulario;
$obFormulario->addTitulo('Dados para Filtro');
$obFormulario->addForm($obForm);
$obFormulario->addHidden($obHdnAcao);
$obFormulario->addHidden($obHdnCtrl);
$obFormulario->addHidden($obHdnForm);
$obFormulario->addHidden($obHdnCampoNum);
$obFormulario->addHidden($obHdnCampoNom);
$obFormulario->addComponente($obTxtNome);
$obFormulario->OK();
$obFormulario->show();

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/rodape.inc.php';

?>
