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
    * Página de Processamento de Aulção de suplementação
    * Data de Criação   : 20/04/2005

    * @author Analista: Diego Barbosa Victoria
    * @author Desenvolvedor: Anderson R. M. Buzo

    * @ignore

    $Revision: 30813 $
    $Name$
    $Author: cleisson $
    $Date: 2006-07-05 17:51:50 -0300 (Qua, 05 Jul 2006) $

    * Casos de uso: uc-02.01.07
*/

/*
$Log$
Revision 1.5  2006/07/05 20:42:23  cleisson
Adicionada tag Log aos arquivos

*/

include '../../../../../../gestaoAdministrativa/fontes/PHP/pacotes/FrameworkHTML.inc.php';
include_once '../../../../../../gestaoAdministrativa/fontes/PHP/framework/include/cabecalho.inc.php';
include( CAM_GF_ORC_NEGOCIO."ROrcamentoSuplementacao.class.php" );

//Define o nome dos arquivos PHP
$stPrograma = "AnularSuplementacao";
$pgFilt    = "FL".$stPrograma.".php";
$pgList    = "LS".$stPrograma.".php";
$pgForm    = "FM".$stPrograma.".php";
$pgProc    = "PR".$stPrograma.".php";
$pgOcul    = "OC".$stPrograma.".php";

$obROrcamentoSuplementacao = new ROrcamentoSuplementacao();

$stAcao = $_POST["stAcao"] ? $_POST["stAcao"] : $_GET["stAcao"];

//valida a utilização da rotina de encerramento do mês contábil
$boUtilizarEncerramentoMes = SistemaLegado::pegaConfiguracao('utilizar_encerramento_mes', 9);
include_once CAM_GF_CONT_MAPEAMENTO."TContabilidadeEncerramentoMes.class.php";
$obTContabilidadeEncerramentoMes = new TContabilidadeEncerramentoMes;
$obTContabilidadeEncerramentoMes->setDado('exercicio', Sessao::getExercicio());
$obTContabilidadeEncerramentoMes->setDado('situacao', 'F');
$obTContabilidadeEncerramentoMes->recuperaEncerramentoMes($rsUltimoMesEncerrado, '', ' ORDER BY mes DESC LIMIT 1 ');

$arDtAutorizacao = explode('/', $_POST['stDataAnulacao']);
if ($boUtilizarEncerramentoMes == 'true' AND $rsUltimoMesEncerrado->getCampo('mes') >= $arDtAutorizacao[1]) {
    SistemaLegado::exibeAviso(urlencode("Mês da Anulação encerrado!"),"n_incluir","erro");
    exit;
}

switch ($stAcao) {
    case "anular":

        switch ($_POST['inCodTipo']) {
            case  1: $stTipoAnulacao = 'Reducao';             break;
            case  2: $stTipoAnulacao = 'Operacao de Credito'; break;
            case  3: $stTipoAnulacao = 'Auxilios';            break;
            case  4: $stTipoAnulacao = 'Excesso';             break;
            case  5: $stTipoAnulacao = 'Superavit';           break;
            case  6: $stTipoAnulacao = 'Reducao';             break;
            case  7: $stTipoAnulacao = 'Operacao de Credito'; break;
            case  8: $stTipoAnulacao = 'Auxilios';            break;
            case  9: $stTipoAnulacao = 'Excesso';             break;
            case 10: $stTipoAnulacao = 'Superavit';           break;
            case 11: $stTipoAnulacao = 'Extraordinario';      break;
            case 12: $stTipoAnulacao = '';                    break;
            case 13: $stTipoAnulacao = '';                    break;
            case 14: $stTipoAnulacao = '';                    break;
            case 15: $stTipoAnulacao = 'AnulacaoExternaReduzida'; break;
        }

        $arDespesaSuplementada = Sessao::read('arDespesaSuplementada');
        $arDespesaReducao      = Sessao::read('arDespesaReducao');

        $obROrcamentoSuplementacao->setExercicio( Sessao::getExercicio() );
        $obROrcamentoSuplementacao->setCodSuplementacaoAnulada( $_POST['inCodSuplementacao'] );
        $obROrcamentoSuplementacao->setCodTipo( 16 ); // Anulação
        $obROrcamentoSuplementacao->setCodTipoAnulacao( $_POST['inCodTipo'] );  // Tipo a ser anulado
        $obROrcamentoSuplementacao->obRNorma->setCodNorma( $_POST['inCodNorma'] );
        $obROrcamentoSuplementacao->setVlTotal( $_POST['nuVlTotal'] );
        $obROrcamentoSuplementacao->obRContabilidadeTransferenciaDespesa->obRContabilidadeLancamentoTransferencia->obRContabilidadeLancamento->obRContabilidadeLote->obROrcamentoEntidade->setCodigoEntidade( $_POST['inCodEntidade'] );
        $obROrcamentoSuplementacao->setCredSuplementar( $stTipoAnulacao );
        $obROrcamentoSuplementacao->setMotivo( $_POST['stMotivo'] );
        $obROrcamentoSuplementacao->setDtLancamento( $_POST['stDtLancamento'] );
        $obROrcamentoSuplementacao->setDtAnulacao( $_POST['stDataAnulacao'] );
        $obROrcamentoSuplementacao->setUltimoDespesaReducao( $arDespesaSuplementada[count($arDespesaSuplementada)-1] );
        $obROrcamentoSuplementacao->setUltimoDespesaSuplementada( $arDespesaReducao[count($arDespesaReducao)-1] );

        $obROrcamentoSuplementacao->setDespesaSuplementada( $arDespesaSuplementada );
        $obROrcamentoSuplementacao->setDespesaReducao( $arDespesaReducao );

        $obErro = $obROrcamentoSuplementacao->anularSuplementacao();
        if ( !$obErro->ocorreu() ) {
            SistemaLegado::alertaAviso($pgFilt.'?'.Sessao::getId()."&stAcao=".$stAcao, $obROrcamentoSuplementacao->getDecreto() , "incluir", "aviso", Sessao::getId(), "../");
        } else {
            SistemaLegado::exibeAviso(urlencode($obErro->getDescricao()),"n_incluir","erro");
        }
    break;
}
?>
