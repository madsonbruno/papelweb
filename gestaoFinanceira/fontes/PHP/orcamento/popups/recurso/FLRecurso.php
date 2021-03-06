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
    * Página de Formulario de Inclusao/Alteracao de Fornecedores
    * Data de Criação   : 29/07/2004

    * @author Desenvolvedor: Marcelo Boezzio Paulino

    * @ignore

    $Revision: 31000 $
    $Name$
    $Autor: $
    $Date: 2006-07-17 15:57:57 -0300 (Seg, 17 Jul 2006) $

    * Casos de uso: uc-02.01.05
*/

/*
$Log$
Revision 1.6  2006/07/17 18:57:57  andre.almeida
Bug #6401#

Revision 1.5  2006/07/05 20:44:01  cleisson
Adicionada tag Log aos arquivos

*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/cabecalho.inc.php';
include_once ( CAM_GF_ORC_NEGOCIO."ROrcamentoConfiguracao.class.php" );

//Define o nome dos arquivos PHP
$stRecurso = "Recurso";
$pgFilt = "FL".$stRecurso.".php";
$pgList = "LS".$stRecurso.".php";
$pgForm = "FM".$stRecurso.".php";
$pgProc = "PR".$stRecurso.".php";
$pgOcul = "OC".$stRecurso.".php";

$obRConfiguracaoOrcamento = new ROrcamentoConfiguracao;
$obRConfiguracaoOrcamento->consultarConfiguracao();

//Define a função do arquivo, ex: incluir, excluir, alterar, consultar, etc
$stAcao = $request->get('stAcao');
if ( empty( $stAcao ) ) {
    $stAcao = "excluir";
}

//destroi arrays de sessao que armazenam os dados do FILTRO
Sessao::remove('filtroPopUp');
Sessao::remove('pg');
Sessao::remove('pos');
Sessao::remove('paginando');
Sessao::remove('link');
//****************************************//
//Define COMPONENTES DO FORMULARIO
//****************************************//
//Instancia o formulário
$obForm = new Form;
$obForm->setAction( $pgList );
//$obForm->setTarget( "telaPrincipal" ); //oculto - telaPrincipal

//Define o objeto da ação stAcao
$obHdnAcao = new Hidden;
$obHdnAcao->setName ( "stAcao" );
$obHdnAcao->setValue( $stAcao );

$obHdnForm = new Hidden;
$obHdnForm->setName( "nomForm" );
$obHdnForm->setValue( $_REQUEST['nomForm'] );

$obHdnCampoNum = new Hidden;
$obHdnCampoNum->setName( "campoNum" );
$obHdnCampoNum->setValue( $_REQUEST['campoNum'] );

//Define HIDDEN com o o nome do campo texto
$obHdnCampoNom = new Hidden;
$obHdnCampoNom->setName( "campoNom" );
$obHdnCampoNom->setValue( $_REQUEST['campoNom'] );

//Define o objeto TEXT para armazenar o NUMERO DO ORGAO NO ORCAMENTO
$obTxtCodRecurso = new TextBox;
$obTxtCodRecurso->setName     ( "inCodRecurso" );
$obTxtCodRecurso->setValue    ( $request->get('inCodRecurso') );
$obTxtCodRecurso->setRotulo   ( "Código" );
$obTxtCodRecurso->setSize     ( 10 );
$obTxtCodRecurso->setMaxLength( strlen($obRConfiguracaoOrcamento->getMascRecurso()) );
$obTxtCodRecurso->setNull     ( true );
$obTxtCodRecurso->setTitle    ( 'Informe um código' );
$obTxtCodRecurso->setInteiro  ( true );

//Define o objeto TEXT para armazenar a DESCRICAO DO ORGAO
$obTxtDescRecurso = new TextBox;
$obTxtDescRecurso->setName     ( "stDescricao" );
$obTxtDescRecurso->setRotulo   ( "Descrição" );
$obTxtDescRecurso->setSize     ( 80 );
$obTxtDescRecurso->setMaxLength( 80 );
$obTxtDescRecurso->setNull     ( true );
$obTxtDescRecurso->setTitle    ( 'Informe uma descrição' );

//****************************************//
//Monta FORMULARIO
//****************************************//
$obFormulario = new Formulario;
$obFormulario->addForm( $obForm );

$obFormulario->addHidden( $obHdnAcao              );
$obFormulario->addHidden( $obHdnForm              );
$obFormulario->addHidden( $obHdnCampoNum          );
$obFormulario->addHidden( $obHdnCampoNom          );

$obFormulario->addTitulo( "Dados para Filtro de Recurso"     );
$obFormulario->addComponente( $obTxtCodRecurso   );
$obFormulario->addComponente( $obTxtDescRecurso  );

$obFormulario->OK();
$obFormulario->show();

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/rodape.inc.php';

?>
