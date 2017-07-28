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
* Arquivo de instância para manutenção de funções
* Data de Criação: 25/07/2005

* @author Analista: Cassiano
* @author Desenvolvedor: Cassiano

$Revision: 5624 $
$Name$
$Author: lizandro $
$Date: 2006-01-26 17:48:55 -0200 (Qui, 26 Jan 2006) $

Casos de uso: uc-01.03.95
*/

include_once '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/valida.inc.php';

$stPrograma = "PopupAtribuicao";
$pgFilt = "FL".$stPrograma.".php";
$pgList = "LS".$stPrograma.".php";
$pgForm = "FM".$stPrograma.".php";
$pgProc = "PR".$stPrograma.".php";
$pgOcul = "OC".$stPrograma.".php";
$pgJs   = "JS".$stPrograma.".js";

//Armazena as funções presentes na atribuição, pois estavam dando problema na verificação.
#sessao->transf3['Funcoes'] = array();

//ssao::remove('Funcao');
//Recupera todas as variáveis que chegam até este arquivo por GET
foreach($_REQUEST as $key=>$value)
    $stUrl .= "&$key=$value";

if ( empty($_REQUEST['stAcao'])||$_REQUEST['stAcao']=="incluir" ) {
//    Sessao::remove('Funcao');
    $_REQUEST['stAcao'] = "incluir";
    if ( ($_POST['stTipoAtribuicao']=='Simples') ) {
        $stArquivo = 'FMPopupAtribuicaoSimples.php?';
//    } elseif ($_POST['stTipoAtribuicao']=='Funcao') {
//        $stArquivo = 'FMPopupAtribuicaoFuncao.php?';
    } else {
        $stArquivo = 'FMPopupAtribuicaoTrataErros.php?';
    }
} elseif ($_REQUEST['stAcao']) {
    $arPosicao  = explode("-",$_REQUEST['stPosicao']); //Primeira posição: Indice numérico - Segunda posição: Nível
    $arFuncao = Sessao::read('Funcao');
    $stConteudo =$arFuncao['Corpo'][ $arPosicao[0] ]['Conteudo'];

    if ( (strpos($stConteudo,'(')!==false) && (strpos($stConteudo,')')!==false) ) {
        $stTemp = substr($stConteudo, strpos($stConteudo, '<')+2);
        $arTemp = explode(' ', $stTemp);
        $stTemp = '';

        foreach ($arTemp as $teste) {
            if ( !($teste[0] == '"'|| $teste[1] == '"' )) {
                $stTemp .= $teste." ";
            }
        }

        if ((strpos($stTemp, '+')!==false)||(strpos($stTemp, '-')!==false)||(strpos($stTemp, '*')!==false)||(strpos($stTemp, '/')!==false)) {
            $stArquivo = 'FMPopupAtribuicaoSimples.php?';
        } else {
            $stArquivo = 'FMPopupAtribuicaoTrataErros.php?';
        }
    } else {
        $stArquivo = 'FMPopupAtribuicaoSimples.php?';
    }
}
$stLocation = $stArquivo.Sessao::getId().$stUrl;
header("Location: ".$stLocation);
exit;
/*

**************

*/

?>
