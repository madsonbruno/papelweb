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
    * Interface de processamento da Função Orçamentátia
    * Funções orçamentárias que fazem parte da classificação funcional-programática da despesa
    * Data de Criação   : 14/07/2004

    * @author Analista: Jorge B.
    * @author Desenvolvedor: Roberto Pawelski Rodrigues

    * @ignore

    $Revision: 31000 $
    $Name$
    $Autor: $
    $Date: 2006-07-05 17:51:50 -0300 (Qua, 05 Jul 2006) $

    * Casos de uso: uc-02.01.03
*/

/*
$Log$
Revision 1.5  2006/07/05 20:42:33  cleisson
Adicionada tag Log aos arquivos

*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/cabecalho.inc.php';
include_once (CAM_GF_ORC_NEGOCIO."ROrcamentoFuncao.class.php"        );

/**
* Define o nome dos arquivos PHP
*/
$stPrograma = "Funcao";
$pgFilt = "FL".$stPrograma.".php";
$pgList = "LS".$stPrograma.".php";
$pgForm = "FM".$stPrograma.".php";
$pgProc = "PR".$stPrograma.".php";
$pgOcul = "OC".$stPrograma.".php";
$pgJS   = "JS".$stPrograma.".js";

include_once( $pgJS );

$stCaminho = CAM_GF_ORC_INSTANCIAS."classFuncional/";

/**
* Instância o OBJETO da regra de negócios RFuncaoOrçamento
*/
$obROrcamentoFuncao         = new ROrcamentoFuncao;

/**
*Define a função do arquivo, ex: incluir, excluir, alterar, consultar, etc
*/
$stAcao = $_GET['stAcao'] ?  $_GET['stAcao'] : $_POST['stAcao'];
if ( empty( $stAcao ) ) {
    $stAcao = "alterar";
}

/**
* Define arquivos PHP para cada ação
*/
switch ($stAcao) {
    case 'alterar': $pgProx = $pgForm; break;
    case 'excluir': $pgProx = $pgProc; break;
    DEFAULT       : $pgProx = $pgForm;
}

/**
* Monta sessão com os valores do filtro
*/
$arFiltro = Sessao::read('filtro');
if ( !Sessao::read('paginando') ) {
    foreach ($_POST as $stCampo => $stValor) {
        $arFiltro['filtro'][$stCampo] = $stValor;
    }
    $inPg = $_GET['pg'] ? $_GET['pg'] : 0;
    $inPos = $_GET['pos']? $_GET['pos'] : 0;
    $boPaginando = true;

    Sessao::write('filtro',$arFiltro);
    Sessao::write('pg',$inPg);
    Sessao::write('pos',$inPos);
    Sessao::write('paginando',$boPaginando);
} else {
    $inPg = $_GET['pg'];
    $inPos = $_GET['pos'];
    foreach ($arFiltro['filtro'] AS $stKey=>$stValue) {
        $_REQUEST[$stKey] = $stValue;
    }
}

if ($_REQUEST['inCodigoFuncao']) {
    $obROrcamentoFuncao->setCodigoFuncao( $_REQUEST['inCodigoFuncao'] );
    $stLink .= '&inCodigoFuncao='.$_REQUEST['inCodigoFuncao'];
}
if ($_REQUEST['stDescricao']) {
    $obROrcamentoFuncao->setDescricao( $_REQUEST['stDescricao'] );
    $stLink .= '&stDescricao='.$_REQUEST['stDescricao'];
}

$stLink .= "&stAcao=".$stAcao;

if ($_GET["pg"] and  $_GET["pos"]) {
    $stLinkPagina = "&pg=".$_GET["pg"]."&pos=".$_GET["pos"];
}

$obROrcamentoFuncao->obRConfiguracaoOrcamento->setExercicio(Sessao::getExercicio());
$obROrcamentoFuncao->listar( $rsLista );

/**
* Instância o OBJETO Lista
*/
$obLista = new Lista;

$obLista->obPaginacao->setFiltro("&stLink=".$stLink );

$obLista->setRecordSet( $rsLista );
$obLista->addCabecalho();
$obLista->ultimoCabecalho->addConteudo("&nbsp;");
$obLista->ultimoCabecalho->setWidth( 2 );
$obLista->commitCabecalho();
$obLista->addCabecalho();
$obLista->ultimoCabecalho->addConteudo("Código ");
$obLista->ultimoCabecalho->setWidth( 10 );
$obLista->commitCabecalho();
$obLista->addCabecalho();
$obLista->ultimoCabecalho->addConteudo( "Descrição" );
$obLista->ultimoCabecalho->setWidth( 55 );
$obLista->commitCabecalho();
$obLista->addCabecalho();
$obLista->ultimoCabecalho->addConteudo("&nbsp;");
$obLista->ultimoCabecalho->setWidth( 2 );
$obLista->commitCabecalho();

$obLista->addDado();
$obLista->ultimoDado->setCampo( "cod_funcao" );
$obLista->ultimoDado->setAlinhamento( 'DIREITA' );
$obLista->commitDado();
$obLista->addDado();
$obLista->ultimoDado->setCampo( "descricao" );
$obLista->commitDado();
$obLista->addAcao();
$obLista->ultimaAcao->setAcao( $stAcao );
$obLista->ultimaAcao->addCampo("&inCodigoFuncao","cod_funcao");
$obLista->ultimaAcao->addCampo("&stDescricao","descricao");
$obLista->ultimaAcao->addCampo("&stDescQuestao","descricao");
if ($stAcao == "excluir") {
    $obLista->ultimaAcao->addCampo("&inCodigoFuncao","cod_funcao");
    $obLista->ultimaAcao->setLink( $stCaminho.$pgProx."?".Sessao::getId().$stLink.$stLinkPagina );
} else {
    $obLista->ultimaAcao->addCampo("&inCodigoFuncao","cod_funcao");
    $obLista->ultimaAcao->setLink( $pgProx."?".Sessao::getId().$stLink.$stLinkPagina );
}
$obLista->commitAcao();
$obLista->show();
?>
